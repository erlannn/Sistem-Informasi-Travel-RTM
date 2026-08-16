<?php

namespace App\Http\Controllers\Penumpang;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Pemesanan;
use App\Models\Penumpang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Services\ContentBasedFilteringService;

class PenumpangDashboardController extends Controller
{
    protected ContentBasedFilteringService $cbfService;

    public function __construct(ContentBasedFilteringService $cbfService)
    {
        $this->cbfService = $cbfService;
    }

    /**
     * Dashboard view
     */
    public function index()
    {
        $user = Auth::user();
        $penumpang = Penumpang::query()->where('email', $user->email)->first();

        $hasHistory = $penumpang ? Pemesanan::query()->where('id_penumpang', $penumpang->id_penumpang)
            ->where('status_perjalanan', '!=', 'Batal')
            ->exists() : false;

        $recommendedJadwals = $this->cbfService->getRecommendations($penumpang, 6);
        $availableJadwals = $recommendedJadwals;

        $myPemesanans = $penumpang ? Pemesanan::with(['jadwal.armada', 'kursi'])
            ->where('id_penumpang', $penumpang->id_penumpang)
            ->latest('id_pemesanan')
            ->get() : collect([]);

        return view('penumpang.dashboard', compact('penumpang', 'recommendedJadwals', 'availableJadwals', 'hasHistory', 'myPemesanans'));
    }

    /**
     * Beranda view
     */
    public function beranda()
    {
        $user = Auth::user();
        $penumpang = Penumpang::query()->where('email', $user->email)->first();

        $hasHistory = $penumpang ? Pemesanan::query()->where('id_penumpang', $penumpang->id_penumpang)
            ->where('status_perjalanan', '!=', 'Batal')
            ->exists() : false;

        $recommendedJadwals = $this->cbfService->getRecommendations($penumpang, 6);
        $jadwals = $recommendedJadwals;

        return view('penumpang.beranda', compact('penumpang', 'recommendedJadwals', 'jadwals', 'hasHistory'));
    }

    /**
     * Cari Jadwal Tiket
     */
    public function jadwal(Request $request)
    {
        $asal = $request->input('asal');
        $tujuan = $request->input('tujuan');
        $tanggal = $request->input('tanggal');

        $query = Jadwal::with(['armada', 'sopir', 'kursis'])->armadaAktif();

        if ($asal) {
            $query->where('asal', 'LIKE', "%{$asal}%");
        }
        if ($tujuan) {
            $query->where('tujuan', 'LIKE', "%{$tujuan}%");
        }

        $query->validForDate($tanggal);

        $jadwals = $query->orderBy('tanggal', 'asc')->orderBy('jam', 'asc')->paginate(10)->withQueryString();

        $defaultCities = ['Sijunjung', 'Solok', 'Padang', 'BIM'];
        $dbAsal = Jadwal::distinct()->pluck('asal')->filter()->toArray();
        $dbTujuan = Jadwal::distinct()->pluck('tujuan')->filter()->toArray();

        $optAsal = array_unique(array_merge($defaultCities, $dbAsal));
        $optTujuan = array_unique(array_merge($defaultCities, $dbTujuan));

        return view('penumpang.jadwal', compact('jadwals', 'asal', 'tujuan', 'tanggal', 'optAsal', 'optTujuan'));
    }

    /**
     * Pilih Kursi
     */
    public function pilihKursi(Request $request, $id_jadwal = null)
    {
        $id_jadwal = $id_jadwal ?? $request->input('id_jadwal');

        if (!$id_jadwal) {
            $jadwal = Jadwal::with(['armada', 'sopir', 'kursis'])
                ->armadaAktif()
                ->mendatang()
                ->orderBy('tanggal', 'asc')
                ->orderBy('jam', 'asc')
                ->first();
        } else {
            $jadwal = Jadwal::with(['armada', 'sopir', 'kursis'])->find($id_jadwal);
        }

        if (!$jadwal || $jadwal->isPast() || ($jadwal->armada && $jadwal->armada->status !== 'Aktif')) {
            return redirect()->route('penumpang.jadwal')->with('error', 'Jadwal ini tidak dapat dipesan karena armada kendaraan sedang non-aktif / dalam perbaikan.');
        }

        $kursis = Kursi::query()->where('id_jadwal', $jadwal->id_jadwal)->get();

        return view('penumpang.pilih_kursi', compact('jadwal', 'kursis'));
    }

    /**
     * Konfirmasi Pemesanan View
     */
    public function konfirmasi(Request $request)
    {
        $id_jadwal = $request->input('id_jadwal');
        $id_kursi_raw = $request->input('id_kursi');

        $jadwal = Jadwal::with(['armada', 'sopir'])->find($id_jadwal);

        if (!$jadwal || $jadwal->isPast() || ($jadwal->armada && $jadwal->armada->status !== 'Aktif')) {
            return redirect()->route('penumpang.jadwal')->with('error', 'Jadwal ini tidak dapat dipesan karena armada kendaraan sedang non-aktif / dalam perbaikan.');
        }

        if (is_array($id_kursi_raw)) {
            $idKursiArray = $id_kursi_raw;
        } elseif (is_string($id_kursi_raw) && str_contains($id_kursi_raw, ',')) {
            $idKursiArray = explode(',', $id_kursi_raw);
        } else {
            $idKursiArray = (array) $id_kursi_raw;
        }
        $idKursiArray = array_filter(array_map('trim', $idKursiArray));

        $kursis = Kursi::query()->where('id_jadwal', '=', $id_jadwal)
            ->whereIn('id_kursi', $idKursiArray, 'and', false)
            ->get();

        if ($kursis->isEmpty()) {
            $kursis = Kursi::query()->where('id_jadwal', $id_jadwal)->where('status', 'Tersedia')->take(1)->get();
        }

        $user = Auth::user();
        $penumpang = Penumpang::query()->where('email', $user->email)->first();

        $jumlahPenumpang = $kursis->count() > 0 ? $kursis->count() : 1;
        $totalBayar = $jadwal->harga * $jumlahPenumpang;

        return view('penumpang.konfirmasi', compact('jadwal', 'kursis', 'penumpang', 'jumlahPenumpang', 'totalBayar'));
    }

    /**
     * Process Pemesanan Store
     */
    public function konfirmasiStore(Request $request)
    {
        $id_kursi_raw = $request->input('id_kursi');
        if (is_array($id_kursi_raw)) {
            $idKursiArray = $id_kursi_raw;
        } elseif (is_string($id_kursi_raw) && str_contains($id_kursi_raw, ',')) {
            $idKursiArray = explode(',', $id_kursi_raw);
        } else {
            $idKursiArray = (array) $id_kursi_raw;
        }
        $idKursiArray = array_filter(array_map('trim', $idKursiArray));

        $request->merge(['id_kursi_list' => $idKursiArray]);
        $request->validate([
            'id_jadwal' => 'required|exists:jadwals,id_jadwal',
            'id_kursi_list' => 'required|array|min:1',
            'id_kursi_list.*' => 'exists:kursis,id_kursi',
        ]);

        $jadwal = Jadwal::with(['armada'])->find($request->id_jadwal);
        if (!$jadwal || $jadwal->isPast() || ($jadwal->armada && $jadwal->armada->status !== 'Aktif')) {
            return redirect()->route('penumpang.jadwal')->with('error', 'Pemesanan tiket gagal. Armada kendaraan pada jadwal ini sedang non-aktif / dalam perbaikan.');
        }

        $user = Auth::user();
        $penumpang = Penumpang::query()->where('email', $user->email)->firstOrFail();

        $createdPemesanans = [];
        foreach ($idKursiArray as $kId) {
            $kursi = Kursi::findOrFail($kId);
            $kursi->update(['status' => 'Terisi']);

            $pemesanan = Pemesanan::create([
                'id_penumpang' => $penumpang->id_penumpang,
                'id_jadwal' => $request->id_jadwal,
                'id_kursi' => $kursi->id_kursi,
                'tanggal_pesan' => now()->toDateString(),
                'jumlah_penumpang' => 1,
                'total_bayar' => $jadwal->harga,
                'metode_pembayaran' => 'Cash',
                'status_pembayaran' => 'Belum Bayar',
                'status_perjalanan' => 'Pending',
            ]);
            $createdPemesanans[] = $pemesanan;
        }

        $lastPemesanan = end($createdPemesanans);

        return redirect()->route('penumpang.status.detail', $lastPemesanan->id_pemesanan)
            ->with('success', count($createdPemesanans) . ' kursi tiket berhasil dipesan! Pembayaran dilakukan secara cash saat sampai di tujuan.');
    }

    /**
     * Status Pemesanan List
     */
    public function status(Request $request)
    {
        $user = Auth::user();
        $penumpang = Penumpang::query()->where('email', $user->email)->first();

        $search = $request->input('search');

        $query = Pemesanan::with(['jadwal.armada', 'kursi']);

        if ($penumpang) {
            $query->where('id_penumpang', $penumpang->id_penumpang);
        }

        if ($search) {
            $query->where('id_pemesanan', 'LIKE', "%{$search}%");
        }

        $pemesanans = $query->latest('id_pemesanan')->get();

        return view('penumpang.status', compact('pemesanans', 'penumpang', 'search'));
    }

    /**
     * Detail Status Pemesanan
     */
    public function statusDetail(int|string $id_pemesanan)
    {
        $pemesanan = Pemesanan::with(['jadwal.armada', 'jadwal.sopir', 'kursi', 'penumpang'])
            ->findOrFail($id_pemesanan);

        return view('penumpang.status_detail', compact('pemesanan'));
    }

    /**
     * Membatalkan Pemesanan Tiket Penumpang
     */
    public function batalkanTiket(int|string $id_pemesanan)
    {
        $pemesanan = Pemesanan::with(['kursi'])->findOrFail($id_pemesanan);

        $user = Auth::user();
        $penumpang = Penumpang::query()->where('email', $user->email)->first();

        if ($penumpang && $pemesanan->id_penumpang !== $penumpang->id_penumpang) {
            return back()->with('error', 'Anda tidak memiliki akses untuk membatalkan tiket ini.');
        }

        if ($pemesanan->status_perjalanan === 'Selesai') {
            return back()->with('error', 'Tiket tidak dapat dibatalkan karena perjalanan sudah selesai.');
        }

        $relatedPemesanans = Pemesanan::query()->where('id_penumpang', '=', $pemesanan->id_penumpang)
            ->where('id_jadwal', '=', $pemesanan->id_jadwal)
            ->where('tanggal_pesan', '=', $pemesanan->tanggal_pesan)
            ->whereBetween('created_at', [
                \Carbon\Carbon::parse($pemesanan->created_at)->subSeconds(15),
                \Carbon\Carbon::parse($pemesanan->created_at)->addSeconds(15)
            ], 'and', false)
            ->get();

        if ($relatedPemesanans->isEmpty()) {
            $relatedPemesanans = collect([$pemesanan]);
        }

        foreach ($relatedPemesanans as $p) {
            $p->status_perjalanan = 'Batal';
            $p->save();

            if ($p->id_kursi) {
                /** @var Kursi|null $kursi */
                $kursi = Kursi::find($p->id_kursi, ['*']);
                if ($kursi) {
                    $kursi->status = 'Kosong';
                    $kursi->save();
                }
            }
        }

        return redirect()->route('penumpang.status')
            ->with('success', 'Pemesanan tiket berhasil dibatalkan dan data telah diperbarui!');
    }

    /**
     * Cetak Status Pembayaran PDF (Spatie PDF)
     */
    public function cetakPdf(int|string $id_pemesanan)
    {
        $pemesanan = Pemesanan::with(['jadwal.armada', 'jadwal.sopir', 'kursi', 'penumpang'])
            ->findOrFail($id_pemesanan);

        return Pdf::loadView('penumpang.pdf_status', compact('pemesanan'))
            ->setPaper('a4', 'portrait')
            ->download('Bukti-Pembayaran-RTM' . sprintf('%04d', $pemesanan->id_pemesanan) . '.pdf');
    }

    /**
     * Profil View
     */
    public function profil()
    {
        $user = Auth::user();
        $penumpang = Penumpang::query()->where('email', $user->email)->first();

        return view('penumpang.profil', compact('user', 'penumpang'));
    }

    /**
     * Update Profil
     */
    public function profilUpdate(Request $request)
    {
        $user = Auth::user();
        $penumpang = Penumpang::query()->where('email', $user->email)->first();

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:8',
        ]);

        /** @var User $user */
        $user->name = $request->nama;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if ($penumpang) {
            $penumpang->nama = $request->nama;
            $penumpang->no_hp = $request->no_hp;
            $penumpang->alamat = $request->alamat;
            if ($request->filled('password')) {
                $penumpang->password = Hash::make($request->password);
            }
            $penumpang->save();
        }

        return redirect()->route('penumpang.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}

