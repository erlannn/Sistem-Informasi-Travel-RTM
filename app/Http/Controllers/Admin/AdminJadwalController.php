<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Sopir;
use Illuminate\Http\Request;

class AdminJadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['armada', 'sopir', 'kursis'])->withCount('pemesanans')->latest('id_jadwal');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('asal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%")
                  ->orWhere('tanggal', 'like', "%{$search}%");
            });
        }

        $jadwals = $query->get();
        $armadas = Armada::all();
        $sopirs = Sopir::all();

        return view('admin.jadwal.index', compact('jadwals', 'armadas', 'sopirs'));
    }

    public function create()
    {
        $armadas = Armada::all();
        $sopirs = Sopir::all();
        return view('admin.jadwal.create', compact('armadas', 'sopirs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_armada' => 'required|exists:armadas,id_armada',
            'id_sopir' => 'required|exists:sopirs,id_sopir',
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required|string',
            'harga' => 'required|numeric|min:0',
        ]);

        /** @var Jadwal $jadwal */
        $jadwal = Jadwal::create($validated);

        // Generate 6 seats automatically for this schedule
        for ($i = 1; $i <= 6; $i++) {
            Kursi::create([
                'id_jadwal' => $jadwal->id_jadwal,
                'nomor_kursi' => 'K' . $i,
                'status' => 'Tersedia',
            ]);
        }

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal perjalanan baru & 6 kursi berhasil dibuat!');
    }

    public function show(int|string $id)
    {
        $jadwal = Jadwal::with(['armada', 'sopir', 'kursis', 'pemesanans.penumpang', 'pemesanans.kursi'])->findOrFail($id);
        return view('admin.jadwal.show', compact('jadwal'));
    }

    public function edit(int|string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $armadas = Armada::all();
        $sopirs = Sopir::all();
        return view('admin.jadwal.edit', compact('jadwal', 'armadas', 'sopirs'));
    }

    public function update(Request $request, int|string $id)
    {
        /** @var Jadwal $jadwal */
        $jadwal = Jadwal::findOrFail($id);

        $validated = $request->validate([
            'id_armada' => 'required|exists:armadas,id_armada',
            'id_sopir' => 'required|exists:sopirs,id_sopir',
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required|string',
            'harga' => 'required|numeric|min:0',
        ]);

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal perjalanan berhasil diperbarui!');
    }

    public function destroy(int|string $id)
    {
        /** @var Jadwal $jadwal */
        $jadwal = Jadwal::findOrFail($id);

        if ($jadwal->pemesanans()->count() > 0) {
            return redirect()->route('admin.jadwal.index')->with('error', 'Jadwal tidak dapat dihapus karena sudah ada pemesanan tiket pada jadwal ini!');
        }

        // Remove related seats first
        Kursi::query()->where('id_jadwal', '=', $id)->delete();
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal perjalanan & data kursi berhasil dihapus!');
    }
}
