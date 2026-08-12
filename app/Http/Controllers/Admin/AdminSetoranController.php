<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        $jadwals = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        // Calculate totals per schedule according to driver revenue sharing logic
        $rekapJadwal = $jadwals->map(function ($jadwal) {
            $lunasPemesanans = $jadwal->pemesanans->filter(function($p) {
                return $p->status_perjalanan === 'Selesai' || $p->status_pembayaran === 'Lunas';
            });

            $totalPenumpangLunas = $lunasPemesanans->sum('jumlah_penumpang');
            $totalPendapatanKotor = $lunasPemesanans->sum('total_bayar'); // Total ticket sales

            // Driver share calculation
            $hakSupirPerPenumpang = $jadwal->bagi_hasil_sopir ?? 0;
            $totalHakSupir = $totalPenumpangLunas * $hakSupirPerPenumpang;

            // Company/Admin share = Total Tiket - Hak Supir
            $totalSetoranWajib = max(0, $totalPendapatanKotor - $totalHakSupir);

            // Verified setoran breakdown
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

        return view('admin.setoran.index', compact('rekapJadwal', 'selectedPeriod', 'periods'));
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
