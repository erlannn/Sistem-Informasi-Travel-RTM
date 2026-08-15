<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\LaravelPdf\Facades\Pdf;

class AdminSetoranController extends Controller
{
    /**
     * Tampilkan rekap Laporan Pembagian Hasil (Supir vs Admin/Perusahaan)
     */
    public function index(Request $request)
    {
        $selectedPeriod = $request->input('period');

        $query = Jadwal::with(['sopir', 'armada', 'pemesanans' => function($q) {
            $q->where(function($sq) {
                $sq->where('status_perjalanan', 'Selesai')
                  ->orWhere('status_pembayaran', 'Lunas');
            });
        }]);

        if ($selectedPeriod) {
            $date = Carbon::createFromFormat('Y-m', $selectedPeriod);
            $query->whereBetween('tanggal', [$date->copy()->startOfMonth()->toDateString(), $date->copy()->endOfMonth()->toDateString()]);
        }

        // Calculate overall summary metrics for the active filter
        $allJadwalsForSummary = (clone $query)->get();

        $totalPendapatanKotorSemua = 0;
        $totalHakSupirSemua = 0;
        $totalSetoranWajibSemua = 0;
        $totalSudahSetorSemua = 0;
        $totalBelumSetorSemua = 0;

        foreach ($allJadwalsForSummary as $jSummary) {
            $lunas = $jSummary->pemesanans->filter(function($p) {
                return $p->status_perjalanan === 'Selesai' || $p->status_pembayaran === 'Lunas';
            });
            $penumpangCount = $lunas->sum('jumlah_penumpang');
            $kotor = $lunas->sum('total_bayar');
            $hakSupir = $penumpangCount * ($jSummary->bagi_hasil_sopir ?? 0);
            $setoranWajib = max(0, $kotor - $hakSupir);

            $lunasSudahSetor = $lunas->where('is_setor_admin', true);
            $lunasBelumSetor = $lunas->where('is_setor_admin', false);

            $penumpangSudahSetor = $lunasSudahSetor->sum('jumlah_penumpang');
            $penumpangBelumSetor = $lunasBelumSetor->sum('jumlah_penumpang');

            $sudahSetor = max(0, $lunasSudahSetor->sum('total_bayar') - ($penumpangSudahSetor * ($jSummary->bagi_hasil_sopir ?? 0)));
            $belumSetor = max(0, $lunasBelumSetor->sum('total_bayar') - ($penumpangBelumSetor * ($jSummary->bagi_hasil_sopir ?? 0)));

            $totalPendapatanKotorSemua += $kotor;
            $totalHakSupirSemua += $hakSupir;
            $totalSetoranWajibSemua += $setoranWajib;
            $totalSudahSetorSemua += $sudahSetor;
            $totalBelumSetorSemua += $belumSetor;
        }

        // Paginate table data (10 items per page)
        $jadwalsPaginated = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10)
            ->withQueryString();

        $rekapJadwal = $jadwalsPaginated->through(function ($jadwal) {
            $lunasPemesanans = $jadwal->pemesanans->filter(function($p) {
                return $p->status_perjalanan === 'Selesai' || $p->status_pembayaran === 'Lunas';
            });

            $totalPenumpangLunas = $lunasPemesanans->sum('jumlah_penumpang');
            $totalPendapatanKotor = $lunasPemesanans->sum('total_bayar');

            $hakSupirPerPenumpang = $jadwal->bagi_hasil_sopir ?? 0;
            $totalHakSupir = $totalPenumpangLunas * $hakSupirPerPenumpang;

            $totalSetoranWajib = max(0, $totalPendapatanKotor - $totalHakSupir);

            $lunasSudahSetor = $lunasPemesanans->where('is_setor_admin', true);
            $lunasBelumSetor = $lunasPemesanans->where('is_setor_admin', false);

            $penumpangSudahSetor = $lunasSudahSetor->sum('jumlah_penumpang');
            $penumpangBelumSetor = $lunasBelumSetor->sum('jumlah_penumpang');

            $totalSudahSetor = max(0, $lunasSudahSetor->sum('total_bayar') - ($penumpangSudahSetor * $hakSupirPerPenumpang));
            $totalBelumSetor = max(0, $lunasBelumSetor->sum('total_bayar') - ($penumpangBelumSetor * $hakSupirPerPenumpang));

            $isFullySetor = ($totalBelumSetor == 0) && ($totalSetoranWajib > 0);

            return [
                'jadwal' => $jadwal,
                'total_penumpang_lunas' => $totalPenumpangLunas,
                'total_pendapatan_kotor' => $totalPendapatanKotor,
                'total_hak_supir' => $totalHakSupir,
                'total_setoran_wajib' => $totalSetoranWajib,
                'total_sudah_setor' => $totalSudahSetor,
                'total_belum_setor' => $totalBelumSetor,
                'is_fully_setor' => $isFullySetor,
                'jumlah_pemesanan_lunas' => $lunasPemesanans->count(),
            ];
        });

        // Generate list of available periods
        $periods = [];
        $allDates = Jadwal::select('tanggal')->orderBy('tanggal', 'desc')->pluck('tanggal')->toArray();
        foreach ($allDates as $dDate) {
            if ($dDate) {
                $p = Carbon::parse($dDate)->format('Y-m');
                if (!isset($periods[$p])) {
                    $periods[$p] = Carbon::parse($dDate)->translatedFormat('F Y');
                }
            }
        }

        return view('admin.setoran.index', compact(
            'rekapJadwal',
            'selectedPeriod',
            'periods',
            'totalPendapatanKotorSemua',
            'totalHakSupirSemua',
            'totalSetoranWajibSemua',
            'totalSudahSetorSemua',
            'totalBelumSetorSemua'
        ));
    }

    /**
     * Cetak PDF Laporan Setoran Admin via Spatie PDF
     */
    public function cetakPdf(Request $request)
    {
        $selectedPeriod = $request->input('period');

        $query = Jadwal::with(['sopir', 'armada', 'pemesanans' => function($q) {
            $q->where(function($sq) {
                $sq->where('status_perjalanan', 'Selesai')
                  ->orWhere('status_pembayaran', 'Lunas');
            });
        }]);

        $periodLabel = 'Semua Periode';
        if ($selectedPeriod) {
            $date = Carbon::createFromFormat('Y-m', $selectedPeriod);
            $query->whereBetween('tanggal', [$date->copy()->startOfMonth()->toDateString(), $date->copy()->endOfMonth()->toDateString()]);
            $periodLabel = $date->translatedFormat('F Y');
        }

        $jadwals = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        $rekapJadwal = $jadwals->map(function ($jadwal) {
            $lunasPemesanans = $jadwal->pemesanans->filter(function($p) {
                return $p->status_perjalanan === 'Selesai' || $p->status_pembayaran === 'Lunas';
            });

            $totalPenumpangLunas = $lunasPemesanans->sum('jumlah_penumpang');
            $totalPendapatanKotor = $lunasPemesanans->sum('total_bayar');

            $hakSupirPerPenumpang = $jadwal->bagi_hasil_sopir ?? 0;
            $totalHakSupir = $totalPenumpangLunas * $hakSupirPerPenumpang;

            $totalSetoranWajib = max(0, $totalPendapatanKotor - $totalHakSupir);

            $lunasSudahSetor = $lunasPemesanans->where('is_setor_admin', true);
            $lunasBelumSetor = $lunasPemesanans->where('is_setor_admin', false);

            $penumpangSudahSetor = $lunasSudahSetor->sum('jumlah_penumpang');
            $penumpangBelumSetor = $lunasBelumSetor->sum('jumlah_penumpang');

            $totalSudahSetor = max(0, $lunasSudahSetor->sum('total_bayar') - ($penumpangSudahSetor * $hakSupirPerPenumpang));
            $totalBelumSetor = max(0, $lunasBelumSetor->sum('total_bayar') - ($penumpangBelumSetor * $hakSupirPerPenumpang));

            $isFullySetor = ($totalBelumSetor == 0) && ($totalSetoranWajib > 0);

            return [
                'jadwal' => $jadwal,
                'total_penumpang_lunas' => $totalPenumpangLunas,
                'total_pendapatan_kotor' => $totalPendapatanKotor,
                'total_hak_supir' => $totalHakSupir,
                'total_setoran_wajib' => $totalSetoranWajib,
                'total_sudah_setor' => $totalSudahSetor,
                'total_belum_setor' => $totalBelumSetor,
                'is_fully_setor' => $isFullySetor,
            ];
        });

        $totalPendapatanKotorSemua = $rekapJadwal->sum('total_pendapatan_kotor');
        $totalHakSupirSemua = $rekapJadwal->sum('total_hak_supir');
        $totalSetoranWajibSemua = $rekapJadwal->sum('total_setoran_wajib');
        $totalSudahSetorSemua = $rekapJadwal->sum('total_sudah_setor');
        $totalBelumSetorSemua = $rekapJadwal->sum('total_belum_setor');

        return Pdf::view('admin.setoran.pdf', compact(
            'rekapJadwal',
            'selectedPeriod',
            'periodLabel',
            'totalPendapatanKotorSemua',
            'totalHakSupirSemua',
            'totalSetoranWajibSemua',
            'totalSudahSetorSemua',
            'totalBelumSetorSemua'
        ))
        ->format('a4')
        ->landscape()
        ->name('Laporan-Setoran-RTM-' . ($selectedPeriod ?? 'Semua-Periode') . '.pdf');
    }

    /**
     * Verifikasi setoran kas dari supir untuk jadwal tertentu
     */
    public function verifikasiSetoran(int|string $id_jadwal)
    {
        $updatedCount = Pemesanan::query()->where('id_jadwal', $id_jadwal)
            ->where(function($q) {
                $q->where('status_perjalanan', 'Selesai')
                  ->orWhere('status_pembayaran', 'Lunas');
            })
            ->where('is_setor_admin', false)
            ->update([
                'is_setor_admin' => true,
                'tanggal_setor' => now(),
            ]);

        return back()->with('success', "Setoran bagian admin dari supir untuk jadwal tersebut berhasil diverifikasi ({$updatedCount} transaksi).");
    }
}
