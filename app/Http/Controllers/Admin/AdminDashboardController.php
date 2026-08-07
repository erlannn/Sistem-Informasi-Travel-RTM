<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Pemesanan;
use App\Models\Penumpang;
use App\Models\Sopir;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_admin' => Admin::query()->count(),
            'total_penumpang' => Penumpang::query()->count(),
            'total_sopir' => Sopir::query()->count(),
            'total_armada' => Armada::query()->count(),
            'total_jadwal' => Jadwal::query()->count(),
            'total_kursi' => Kursi::query()->count(),
            'total_pemesanan' => Pemesanan::query()->count(),
        ];

        $recentPemesanans = Pemesanan::with(['penumpang', 'jadwal', 'kursi'])
            ->latest('id_pemesanan')
            ->take(5)
            ->get();

        $recentJadwals = Jadwal::with(['armada', 'sopir'])
            ->latest('id_jadwal')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPemesanans', 'recentJadwals'));
    }
}
