<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Sopir;
use App\Models\Pemesanan;
use App\Models\Kursi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SopirDashboardController extends Controller
{
    private function getSopir()
    {
        $user = Auth::user();
        return Sopir::query()->where('nama', $user->name)->first();
    }

    public function index()
    {
        $sopir = $this->getSopir();
        if (!$sopir) {
            return view('sopir.dashboard', [
                'sopir' => null, 
                'assignedJadwals' => collect(), 
                'nextJadwal' => null, 
                'completedBookingsCount' => 0, 
                'totalGaji' => 0,
                'jumlahJadwal' => 0,
                'jumlahPenumpangAkanDilayani' => 0
            ]);
        }

        // Get schedules assigned to this driver
        $assignedJadwals = Jadwal::with(['armada', 'pemesanans.penumpang'])
            ->where('id_sopir', '=', $sopir->id_sopir)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        // 1. Jumlah jadwal perjalanan yang menjadi tanggung jawab sopir
        $jumlahJadwal = $assignedJadwals->count();

        // 2. Jumlah penumpang yang akan dilayani (status_perjalanan Pending atau Naik)
        $jumlahPenumpangAkanDilayani = Pemesanan::whereHas('jadwal', function($q) use ($sopir) {
                $q->where('id_sopir', '=', $sopir->id_sopir);
            })
            ->whereIn('status_perjalanan', ['Pending', 'Naik'])
            ->sum('jumlah_penumpang');

        // Next upcoming schedule
        $nextJadwal = Jadwal::with(['armada'])
            ->where('id_sopir', '=', $sopir->id_sopir)
            ->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->first();

        // Calculate completed bookings and total driver earnings for current month
        $currentMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $currentMonthEnd = Carbon::now()->endOfMonth()->toDateString();

        $completedBookings = Pemesanan::with(['jadwal'])
            ->whereHas('jadwal', function($q) use ($sopir) {
                $q->where('id_sopir', '=', $sopir->id_sopir);
            })
            ->where('status_perjalanan', '=', 'Selesai')
            ->where('status_pembayaran', '=', 'Lunas')
            ->whereBetween('tanggal_pesan', [$currentMonthStart, $currentMonthEnd])
            ->get();

        $completedBookingsCount = $completedBookings->sum('jumlah_penumpang');

        $totalGaji = 0;
        foreach ($completedBookings as $cb) {
            $bagiHasil = $cb->jadwal->bagi_hasil_sopir ?? 0;
            $totalGaji += ($cb->jumlah_penumpang * $bagiHasil);
        }

        return view('sopir.dashboard', compact(
            'sopir', 
            'assignedJadwals', 
            'nextJadwal', 
            'completedBookingsCount', 
            'totalGaji',
            'jumlahJadwal',
            'jumlahPenumpangAkanDilayani'
        ));
    }

    public function jadwal(Request $request)
    {
        $sopir = $this->getSopir();
        if (!$sopir) {
            return redirect()->route('login')->with('error', 'Data sopir tidak ditemukan.');
        }

        $search = $request->input('search');
        $searchDate = $request->input('search_date');

        $query = Jadwal::with(['armada'])
            ->where('id_sopir', '=', $sopir->id_sopir);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('asal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%")
                  ->orWhereHas('armada', function($qa) use ($search) {
                      $qa->where('merk', 'like', "%{$search}%")
                        ->orWhere('plat_nomor', 'like', "%{$search}%");
                  });
            });
        }

        if ($searchDate) {
            $query->whereDate('tanggal', '=', $searchDate);
        }

        $jadwals = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        return view('sopir.jadwal', compact('sopir', 'jadwals', 'search', 'searchDate'));
    }

    public function jadwalDetail(int|string $id)
    {
        $sopir = $this->getSopir();
        if (!$sopir) {
            return redirect()->route('login')->with('error', 'Data sopir tidak ditemukan.');
        }

        $jadwal = Jadwal::with(['armada', 'pemesanans.penumpang'])
            ->where('id_sopir', '=', $sopir->id_sopir)
            ->where('id_jadwal', '=', $id)
            ->firstOrFail();

        $jumlahPenumpang = $jadwal->pemesanans->where('status_perjalanan', '!=', 'Batal')->sum('jumlah_penumpang');

        return view('sopir.jadwal_detail', compact('sopir', 'jadwal', 'jumlahPenumpang'));
    }

    // Aksi 1: Penumpang naik mobil (Boarding)
    public function penumpangNaik(int|string $id_pemesanan)
    {
        $pemesanan = Pemesanan::findOrFail($id_pemesanan);
        $pemesanan->update([
            'status_perjalanan' => 'Naik',
        ]);

        return back()->with('success', 'Status penumpang diperbarui: Naik ke armada.');
    }

    // Aksi 2: Sampai tujuan dan terima pembayaran cash
    public function terimaBayarCash(int|string $id_pemesanan)
    {
        $pemesanan = Pemesanan::findOrFail($id_pemesanan);
        
        $pemesanan->update([
            'status_perjalanan' => 'Selesai',
            'status_pembayaran' => 'Lunas',
            'waktu_bayar' => now(),
        ]);

        if ($pemesanan->id_kursi) {
            /** @var Kursi|null $kursi */
            $kursi = Kursi::find($pemesanan->id_kursi, ['*']);
            if ($kursi) {
                $kursi->status = 'Kosong';
                $kursi->save();
            }
        }

        return back()->with('success', 'Pembayaran cash diterima dan perjalanan selesai.');
    }

    // Aksi 3: Penumpang Batal / No-Show
    public function batalkanPesanan(int|string $id_pemesanan)
    {
        $pemesanan = Pemesanan::findOrFail($id_pemesanan);
        
        if ($pemesanan->id_kursi) {
            /** @var Kursi|null $kursi */
            $kursi = Kursi::find($pemesanan->id_kursi, ['*']);
            if ($kursi) {
                $kursi->status = 'Kosong';
                $kursi->save();
            }
        }

        $pemesanan->update([
            'status_perjalanan' => 'Batal',
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan dan kursi dilepaskan.');
    }

    public function selesaikanPerjalanan(Request $request, int|string $id)
    {
        $sopir = $this->getSopir();
        if (!$sopir) {
            return redirect()->route('login')->with('error', 'Data sopir tidak ditemukan.');
        }

        $jadwal = Jadwal::query()->where('id_sopir', $sopir->id_sopir)
            ->where('id_jadwal', $id)
            ->firstOrFail();

        // Get all active bookings for this schedule (status_perjalanan Pending / Naik)
        $pemesanans = Pemesanan::query()->where('id_jadwal', $jadwal->id_jadwal)
            ->whereIn('status_perjalanan', ['Pending', 'Naik'])
            ->get();

        if ($pemesanans->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada pemesanan aktif (Pending/Naik) untuk diselesaikan pada jadwal ini.');
        }

        /** @var Pemesanan $pemesanan */
        foreach ($pemesanans as $pemesanan) {
            $pemesanan->update([
                'status_perjalanan' => 'Selesai',
                'status_pembayaran' => 'Lunas',
                'waktu_bayar' => $pemesanan->waktu_bayar ?? now(),
            ]);

            // Release seat
            if ($pemesanan->id_kursi) {
                /** @var Kursi|null $kursi */
                $kursi = Kursi::find($pemesanan->id_kursi, ['*']);
                if ($kursi) {
                    $kursi->status = 'Kosong';
                    $kursi->save();
                }
            }
        }

        return redirect()->route('sopir.jadwal.detail', $id)->with('success', 'Perjalanan berhasil diselesaikan! Status pemesanan semua penumpang telah diperbarui menjadi Selesai.');
    }

    public function penumpang(Request $request, int|string $id)
    {
        $sopir = $this->getSopir();
        if (!$sopir) {
            return redirect()->route('login')->with('error', 'Data sopir tidak ditemukan.');
        }

        $jadwal = Jadwal::query()->where('id_sopir', $sopir->id_sopir)
            ->where('id_jadwal', $id)
            ->firstOrFail();

        $search = $request->input('search');

        $query = Pemesanan::with(['penumpang', 'kursi'])
            ->where('id_jadwal', '=', $jadwal->id_jadwal);

        if ($search) {
            $query->whereHas('penumpang', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $pemesanans = $query->get();

        return view('sopir.penumpang', compact('sopir', 'jadwal', 'pemesanans', 'search'));
    }

    public function penumpangGlobal(Request $request)
    {
        $sopir = $this->getSopir();
        if (!$sopir) {
            return redirect()->route('login')->with('error', 'Data sopir tidak ditemukan.');
        }

        $search = $request->input('search');

        $query = Pemesanan::with(['penumpang', 'kursi', 'jadwal'])
            ->whereHas('jadwal', function($q) use ($sopir) {
                $q->where('id_sopir', '=', $sopir->id_sopir);
            });

        if ($search) {
            $query->whereHas('penumpang', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $pemesanans = $query->orderBy('tanggal_pesan', 'desc')->get();

        return view('sopir.penumpang_global', compact('sopir', 'pemesanans', 'search'));
    }

    public function gaji(Request $request)
    {
        $sopir = $this->getSopir();
        if (!$sopir) {
            return redirect()->route('login')->with('error', 'Data sopir tidak ditemukan.');
        }

        // Get selected period or default to current month
        $selectedPeriod = $request->input('period', Carbon::now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $selectedPeriod);
        $monthStart = $date->copy()->startOfMonth()->toDateString();
        $monthEnd = $date->copy()->endOfMonth()->toDateString();

        // Get all completed passenger bookings for this driver in selected period
        $completedBookings = Pemesanan::with(['jadwal'])
            ->whereHas('jadwal', function($q) use ($sopir) {
                $q->where('id_sopir', '=', $sopir->id_sopir);
            })
            ->where('status_perjalanan', '=', 'Selesai')
            ->where('status_pembayaran', '=', 'Lunas')
            ->whereBetween('tanggal_pesan', [$monthStart, $monthEnd])
            ->get();

        $totalPenumpang = $completedBookings->sum('jumlah_penumpang');

        // Group by route for detailed slip breakdown
        $ruteBreakdown = [];
        $totalGaji = 0;
        $totalTunaiDiterima = 0;

        foreach ($completedBookings as $cb) {
            $j = $cb->jadwal;
            $ruteKey = ($j ? "{$j->asal} → {$j->tujuan}" : 'Perjalanan Travel');
            $hargaTiket = $j ? $j->harga : 0;
            $bagiHasilUnit = $j ? $j->bagi_hasil_sopir : 0;

            $pax = $cb->jumlah_penumpang;
            $subtotalBagiHasil = $pax * $bagiHasilUnit;
            $subtotalCash = $cb->total_bayar > 0 ? $cb->total_bayar : ($pax * $hargaTiket);

            if (!isset($ruteBreakdown[$ruteKey])) {
                $ruteBreakdown[$ruteKey] = [
                    'rute' => $ruteKey,
                    'total_penumpang' => 0,
                    'harga_tiket' => $hargaTiket,
                    'bagi_hasil_per_pax' => $bagiHasilUnit,
                    'total_bagi_hasil' => 0,
                ];
            }

            $ruteBreakdown[$ruteKey]['total_penumpang'] += $pax;
            $ruteBreakdown[$ruteKey]['total_bagi_hasil'] += $subtotalBagiHasil;

            $totalGaji += $subtotalBagiHasil;
            $totalTunaiDiterima += $subtotalCash;
        }

        $totalSetoranPerusahaan = max(0, $totalTunaiDiterima - $totalGaji);

        // Generate list of available periods based on driver schedules
        $periods = [];
        $driverJadwalDates = Jadwal::query()->where('id_sopir', $sopir->id_sopir)
            ->select('tanggal')
            ->orderBy('tanggal', 'desc')
            ->pluck('tanggal')
            ->toArray();

        // Add current period to select list always
        $periods[Carbon::now()->format('Y-m')] = Carbon::now()->translatedFormat('F Y');

        foreach ($driverJadwalDates as $dDate) {
            $p = Carbon::parse($dDate)->format('Y-m');
            if (!isset($periods[$p])) {
                $periods[$p] = Carbon::parse($dDate)->translatedFormat('F Y');
            }
        }

        return view('sopir.gaji', compact(
            'sopir',
            'selectedPeriod',
            'periods',
            'totalPenumpang',
            'ruteBreakdown',
            'totalGaji',
            'totalTunaiDiterima',
            'totalSetoranPerusahaan'
        ));
    }
}