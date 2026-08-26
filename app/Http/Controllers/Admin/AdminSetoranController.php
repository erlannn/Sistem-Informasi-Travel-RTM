<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminSetoranController extends Controller
{
    /**
     * Helper to apply date/period filtering query and generate period label
     */
    private function applyFilter($query, Request $request): array
    {
        $filterType = $request->input('filter_type');
        $selectedPeriod = $request->input('period');
        $selectedDate = $request->input('tanggal', Carbon::today()->toDateString());

        // Backward compatibility if only period was passed
        if (!$filterType && $selectedPeriod) {
            $filterType = 'bulanan';
        } elseif (!$filterType) {
            $filterType = 'semua';
        }

        $periodLabel = 'Semua Periode';

        if ($filterType === 'harian') {
            $date = Carbon::parse($selectedDate);
            $query->whereDate('tanggal', $date->toDateString());
            $periodLabel = 'Harian (' . $date->translatedFormat('d F Y') . ')';
        } elseif ($filterType === 'mingguan') {
            $date = Carbon::parse($selectedDate);
            $startOfWeek = $date->copy()->startOfWeek()->toDateString();
            $endOfWeek = $date->copy()->endOfWeek()->toDateString();
            $query->whereBetween('tanggal', [$startOfWeek, $endOfWeek]);
            $periodLabel = 'Mingguan (' . Carbon::parse($startOfWeek)->translatedFormat('d M') . ' - ' . Carbon::parse($endOfWeek)->translatedFormat('d M Y') . ')';
        } elseif ($filterType === 'bulanan') {
            $p = $selectedPeriod ?: Carbon::today()->format('Y-m');
            try {
                $date = Carbon::createFromFormat('Y-m', $p);
            } catch (\Exception $e) {
                $date = Carbon::today();
                $p = $date->format('Y-m');
            }
            $query->whereBetween('tanggal', [$date->copy()->startOfMonth()->toDateString(), $date->copy()->endOfMonth()->toDateString()]);
            $periodLabel = 'Bulanan (' . $date->translatedFormat('F Y') . ')';
            $selectedPeriod = $p;
        }

        return [
            'filterType' => $filterType,
            'selectedDate' => $selectedDate,
            'selectedPeriod' => $selectedPeriod,
            'periodLabel' => $periodLabel,
        ];
    }

    /**
     * Tampilkan rekap Laporan Pembagian Hasil (Supir vs Admin/Perusahaan)
     */
    public function index(Request $request)
    {
        $query = Jadwal::with(['sopir', 'armada', 'pemesanans' => function ($q) {
            $q->where(function ($sq) {
                $sq->where('status_perjalanan', 'Selesai')
                    ->orWhere('status_pembayaran', 'Lunas');
            });
        }]);

        $filterData = $this->applyFilter($query, $request);
        $filterType = $filterData['filterType'];
        $selectedDate = $filterData['selectedDate'];
        $selectedPeriod = $filterData['selectedPeriod'];
        $periodLabel = $filterData['periodLabel'];

        // Calculate overall summary metrics for the active filter
        $allJadwalsForSummary = (clone $query)->get();

        $totalPendapatanKotorSemua = 0;
        $totalHakSupirSemua = 0;
        $totalSetoranWajibSemua = 0;
        $totalSudahSetorSemua = 0;
        $totalBelumSetorSemua = 0;

        foreach ($allJadwalsForSummary as $jSummary) {
            $lunas = $jSummary->pemesanans->filter(function ($p) {
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
            $lunasPemesanans = $jadwal->pemesanans->filter(function ($p) {
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
                'total_hak_sopir' => $totalHakSupir,
                'total_setoran_wajib' => $totalSetoranWajib,
                'total_sudah_setor' => $totalSudahSetor,
                'total_belum_setor' => $totalBelumSetor,
                'is_fully_setor' => $isFullySetor,
                'jumlah_pemesanan_lunas' => $lunasPemesanans->count(),
            ];
        });

        // Generate list of available periods for monthly option
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
            'filterType',
            'selectedDate',
            'selectedPeriod',
            'periodLabel',
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
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $query = Jadwal::with(['sopir', 'armada', 'pemesanans' => function ($q) {
            $q->where(function ($sq) {
                $sq->where('status_perjalanan', 'Selesai')
                    ->orWhere('status_pembayaran', 'Lunas');
            });
        }]);

        $filterData = $this->applyFilter($query, $request);
        $filterType = $filterData['filterType'];
        $selectedDate = $filterData['selectedDate'];
        $selectedPeriod = $filterData['selectedPeriod'];
        $periodLabel = $filterData['periodLabel'];

        $jadwals = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        $rekapJadwal = $jadwals->map(function ($jadwal) {
            $lunasPemesanans = $jadwal->pemesanans->filter(function ($p) {
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
                'total_hak_sopir' => $totalHakSupir,
                'total_setoran_wajib' => $totalSetoranWajib,
                'total_sudah_setor' => $totalSudahSetor,
                'total_belum_setor' => $totalBelumSetor,
                'is_fully_setor' => $isFullySetor,
                'jumlah_pemesanan_lunas' => $lunasPemesanans->count(),
            ];
        });

        $totalPendapatanKotorSemua = $rekapJadwal->sum('total_pendapatan_kotor');
        $totalHakSupirSemua = $rekapJadwal->sum('total_hak_supir');
        $totalSetoranWajibSemua = $rekapJadwal->sum('total_setoran_wajib');
        $totalSudahSetorSemua = $rekapJadwal->sum('total_sudah_setor');
        $totalBelumSetorSemua = $rekapJadwal->sum('total_belum_setor');

        return Pdf::loadView('admin.setoran.pdf', compact(
            'rekapJadwal',
            'filterType',
            'selectedDate',
            'selectedPeriod',
            'periodLabel',
            'totalPendapatanKotorSemua',
            'totalHakSupirSemua',
            'totalSetoranWajibSemua',
            'totalSudahSetorSemua',
            'totalBelumSetorSemua'
        ))
            ->setPaper('a4', 'landscape')
            ->download('Laporan-Setoran-RTM-' . str_replace([' ', '(', ')', '/'], '-', $periodLabel) . '.pdf');
    }

    /**
     * Verifikasi setoran kas dari supir untuk jadwal tertentu
     */
    public function verifikasiSetoran(int|string $id_jadwal)
    {
        $updatedCount = Pemesanan::query()->where('id_jadwal', $id_jadwal)
            ->where(function ($q) {
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
