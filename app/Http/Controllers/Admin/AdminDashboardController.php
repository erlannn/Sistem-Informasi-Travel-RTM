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
            'total_admin' => Admin::count(),
            'total_penumpang' => Penumpang::count(),
            'total_sopir' => Sopir::count(),
            'total_armada' => Armada::count(),
            'total_jadwal' => Jadwal::count(),
            'total_kursi' => Kursi::count(),
            'total_pemesanan' => Pemesanan::count(),
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
