<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminArmadaController;
use App\Http\Controllers\Admin\AdminSopirController;
use App\Http\Controllers\Admin\AdminPenumpangController;
use App\Http\Controllers\Admin\AdminJadwalController;
use App\Http\Controllers\Admin\AdminPemesananController;
use App\Http\Controllers\Admin\AdminSetoranController;
use App\Http\Controllers\Penumpang\PenumpangDashboardController;
use App\Http\Controllers\Sopir\SopirDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Root Landing & Smart Redirect
Route::get('/', function (Illuminate\Http\Request $request) {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Sopir')) {
            return redirect()->route('sopir.dashboard');
        } elseif ($user->hasRole('Penumpang')) {
            return redirect()->route('penumpang.beranda');
        }
    }

    $asal = $request->input('asal');
    $tujuan = $request->input('tujuan');
    $tanggal = $request->input('tanggal');

    $query = App\Models\Jadwal::with(['armada', 'sopir'])->armadaAktif();

    if ($asal) {
        $query->where('asal', 'LIKE', "%{$asal}%");
    }
    if ($tujuan) {
        $query->where('tujuan', 'LIKE', "%{$tujuan}%");
    }
    $query->validForDate($tanggal);

    $jadwals = $query->orderBy('tanggal', 'asc')->orderBy('jam', 'asc')->take(6)->get();

    // Fetch unique locations for search dropdowns with fallbacks
    $lokasiAsal = App\Models\Jadwal::distinct()->pluck('asal')->toArray();
    $lokasiAsal = array_filter(array_map('trim', $lokasiAsal));
    if (empty($lokasiAsal)) {
        $lokasiAsal = ['Padang', 'Sijunjung', 'Solok', 'Bukittinggi'];
    }

    $lokasiTujuan = App\Models\Jadwal::distinct()->pluck('tujuan')->toArray();
    $lokasiTujuan = array_filter(array_map('trim', $lokasiTujuan));
    if (empty($lokasiTujuan)) {
        $lokasiTujuan = ['Padang', 'Sijunjung', 'Solok', 'Bukittinggi'];
    }

    return view('welcome', compact('jadwals', 'asal', 'tujuan', 'tanggal', 'lokasiAsal', 'lokasiTujuan'));
})->middleware('browser.cache');

// Guest Auth Routes
Route::middleware(['guest', 'browser.cache'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Routes (Role: Admin)
    Route::middleware(['role:Admin', 'browser.cache'])->prefix('admin')->as('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/armada', AdminArmadaController::class);
        Route::resource('/sopir', AdminSopirController::class);
        Route::resource('/penumpang', AdminPenumpangController::class);
        Route::resource('/jadwal', AdminJadwalController::class);
        Route::resource('/pemesanan', AdminPemesananController::class)->only(['index', 'show', 'destroy']);
        Route::patch('/pemesanan/{id}/status', [AdminPemesananController::class, 'updateStatus'])->name('pemesanan.update_status');
        
        // Rekap Setoran Kas
        Route::get('/setoran', [AdminSetoranController::class, 'index'])->name('setoran.index');
        Route::get('/setoran/pdf', [AdminSetoranController::class, 'cetakPdf'])->name('setoran.pdf');
        Route::post('/setoran/{id_jadwal}/verifikasi', [AdminSetoranController::class, 'verifikasiSetoran'])->name('setoran.verifikasi');
    });

    // Penumpang Routes (Role: Penumpang)
    Route::middleware(['role:Penumpang', 'browser.cache'])->prefix('penumpang')->as('penumpang.')->group(function () {
        Route::get('/dashboard', [PenumpangDashboardController::class, 'index'])->name('dashboard');
        Route::get('/beranda', [PenumpangDashboardController::class, 'beranda'])->name('beranda');
        Route::get('/jadwal', [PenumpangDashboardController::class, 'jadwal'])->name('jadwal');
        Route::get('/pilih-kursi/{id_jadwal?}', [PenumpangDashboardController::class, 'pilihKursi'])->name('pilih_kursi');
        Route::get('/konfirmasi', [PenumpangDashboardController::class, 'konfirmasi'])->name('konfirmasi');
        Route::post('/konfirmasi', [PenumpangDashboardController::class, 'konfirmasiStore'])->name('konfirmasi.store');
        Route::get('/status', [PenumpangDashboardController::class, 'status'])->name('status');
        Route::get('/status/{id_pemesanan}', [PenumpangDashboardController::class, 'statusDetail'])->name('status.detail');
        Route::post('/status/{id_pemesanan}/batal', [PenumpangDashboardController::class, 'batalkanTiket'])->name('status.batal');
        Route::get('/status/{id_pemesanan}/pdf', [PenumpangDashboardController::class, 'cetakPdf'])->name('status.pdf');
        Route::get('/profil', [PenumpangDashboardController::class, 'profil'])->name('profil');
        Route::put('/profil', [PenumpangDashboardController::class, 'profilUpdate'])->name('profil.update');
    });

    // Sopir Routes (Role: Sopir)
    Route::middleware(['role:Sopir', 'browser.cache'])->prefix('sopir')->as('sopir.')->group(function () {
        Route::get('/dashboard', [SopirDashboardController::class, 'index'])->name('dashboard');
        Route::get('/jadwal', [SopirDashboardController::class, 'jadwal'])->name('jadwal');
        Route::get('/jadwal/{id}', [SopirDashboardController::class, 'jadwalDetail'])->name('jadwal.detail');
        Route::post('/jadwal/{id}/selesaikan', [SopirDashboardController::class, 'selesaikanPerjalanan'])->name('jadwal.selesaikan');
        Route::get('/jadwal/{id}/penumpang', [SopirDashboardController::class, 'penumpang'])->name('jadwal.penumpang');
        Route::get('/penumpang', [SopirDashboardController::class, 'penumpangGlobal'])->name('penumpang');
        Route::get('/gaji', [SopirDashboardController::class, 'gaji'])->name('gaji');
        
        // Action routes per passenger / booking
        Route::post('/pemesanan/{id}/naik', [SopirDashboardController::class, 'penumpangNaik'])->name('pemesanan.naik');
        Route::post('/pemesanan/{id}/terima-cash', [SopirDashboardController::class, 'terimaBayarCash'])->name('pemesanan.terima_cash');
        Route::post('/pemesanan/{id}/batal', [SopirDashboardController::class, 'batalkanPesanan'])->name('pemesanan.batal');
    });
});
