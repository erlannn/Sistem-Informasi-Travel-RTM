<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use App\Models\Sopir;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sopir' => Sopir::query()->count('*'),
            'total_armada' => Armada::query()->count('*'),
            'total_jadwal' => Jadwal::query()->count('*'),
            'total_pemesanan' => Pemesanan::query()->count('*'),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
