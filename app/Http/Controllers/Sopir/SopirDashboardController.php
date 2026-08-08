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
        return Sopir::where('nama', '=', $user->name)->first();
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
                'tarifPerPenumpang' => 50000, 
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

        // Calculate specific requested dashboard stats:
        // 1. Jumlah jadwal perjalanan yang menjadi tanggung jawab sopir
        $jumlahJadwal = $assignedJadwals->count();

        // 2. Jumlah penumpang yang akan dilayani (status Pending atau Lunas)
        $jumlahPenumpangAkanDilayani = Pemesanan::whereHas('jadwal', function($q) use ($sopir) {
                $q->where('id_sopir', '=', $sopir->id_sopir);
            })
            ->whereIn('status', ['Pending', 'Lunas'])
            ->sum('jumlah_penumpang');

        // Next upcoming schedule
        $nextJadwal = Jadwal::with(['armada'])
            ->where('id_sopir', '=', $sopir->id_sopir)
            ->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->first();

        // Calculate completed bookings and salary for current month
        $currentMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $currentMonthEnd = Carbon::now()->endOfMonth()->toDateString();

        $completedBookingsCount = Pemesanan::whereHas('jadwal', function($q) use ($sopir) {
                $q->where('id_sopir', '=', $sopir->id_sopir);
            })
            ->where('status', '=', 'Selesai')
            ->whereBetween('tanggal_pesan', [$currentMonthStart, $currentMonthEnd])
            ->sum('jumlah_penumpang');

        $tarifPerPenumpang = 50000;
        $totalKomisi = $completedBookingsCount * $tarifPerPenumpang;
        $totalGaji = $sopir->gaji + $totalKomisi;

        return view('sopir.dashboard', compact(
            'sopir', 
            'assignedJadwals', 
            'nextJadwal', 
            'completedBookingsCount', 
            'tarifPerPenumpang', 
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

    public function jadwalDetail($id)
    {
        $sopir = $this->getSopir();
        if (!$sopir) {
            return redirect()->route('login')->with('error', 'Data sopir tidak ditemukan.');
        }

        $jadwal = Jadwal::with(['armada', 'pemesanans.penumpang'])
            ->where('id_sopir', '=', $sopir->id_sopir)
            ->where('id_jadwal', '=', $id)
            ->firstOrFail();

        $jumlahPenumpang = $jadwal->pemesanans->where('status', '!=', 'Batal')->sum('jumlah_penumpang');

        return view('sopir.jadwal_detail', compact('sopir', 'jadwal', 'jumlahPenumpang'));
    }

    public function selesaikanPerjalanan(Request $request, $id)
    {
        $sopir = $this->getSopir();
        if (!$sopir) {
            return redirect()->route('login')->with('error', 'Data sopir tidak ditemukan.');
        }

        $jadwal = Jadwal::where('id_sopir', '=', $sopir->id_sopir)
            ->where('id_jadwal', '=', $id)
            ->firstOrFail();

        // Get all active bookings for this schedule (status Lunas / Pending)
        $pemesanans = Pemesanan::where('id_jadwal', '=', $jadwal->id_jadwal)
            ->whereIn('status', ['Lunas', 'Pending'])
            ->get();

        if ($pemesanans->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada pemesanan aktif (Pending/Lunas) untuk diselesaikan pada jadwal ini.');
        }

        foreach ($pemesanans as $pemesanan) {
            $pemesanan->status = 'Selesai';
            $pemesanan->save();

            // Release seat
            if ($pemesanan->id_kursi) {
                $kursi = Kursi::find($pemesanan->id_kursi);
                if ($kursi) {
                    $kursi->status = 'Tersedia';
                    $kursi->save();
                }
            }
        }

        return redirect()->route('sopir.jadwal.detail', $id)->with('success', 'Perjalanan berhasil diselesaikan! Status pemesanan semua penumpang telah diperbarui menjadi Selesai.');
    }

    public function penumpang(Request $request, $id)
    {
        $sopir = $this->getSopir();
        if (!$sopir) {
            return redirect()->route('login')->with('error', 'Data sopir tidak ditemukan.');
        }

        $jadwal = Jadwal::where('id_sopir', '=', $sopir->id_sopir)
            ->where('id_jadwal', '=', $id)
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
            ->where('status', '=', 'Selesai')
            ->whereBetween('tanggal_pesan', [$monthStart, $monthEnd])
            ->get();

        $totalPenumpang = $completedBookings->sum('jumlah_penumpang');
        $tarifPerPenumpang = 50000; // Flat Rp 50.000 commission
        $totalKomisi = $totalPenumpang * $tarifPerPenumpang;
        
        // Accumulate salary: Gaji Pokok + Komisi
        $baseSalary = $sopir->gaji;
        $totalGaji = $baseSalary + $totalKomisi;

        // Cash payments collected by driver from passenger directly
        $totalTunaiDiterima = 0;
        foreach ($completedBookings as $cb) {
            $totalTunaiDiterima += $cb->jumlah_penumpang * ($cb->jadwal->harga ?? 0);
        }

        // Generate list of available periods based on driver schedules
        $periods = [];
        $driverJadwalDates = Jadwal::where('id_sopir', '=', $sopir->id_sopir)
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
            'tarifPerPenumpang',
            'totalKomisi',
            'baseSalary',
            'totalGaji',
            'totalTunaiDiterima'
        ));
    }
}