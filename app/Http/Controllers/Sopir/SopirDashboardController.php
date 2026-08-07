<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Sopir;
use Illuminate\Support\Facades\Auth;

class SopirDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sopir = Sopir::where('nama', $user->name)->first();

        $assignedJadwals = collect();
        if ($sopir) {
            $assignedJadwals = Jadwal::with(['armada', 'pemesanans.penumpang'])
                ->where('id_sopir', $sopir->id_sopir)
                ->get();
        }

        return view('sopir.dashboard', compact('sopir', 'assignedJadwals'));
    }
}
