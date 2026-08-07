<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Pemesanan;
use App\Models\Penumpang;
use Illuminate\Http\Request;

class AdminPemesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with(['penumpang', 'jadwal.armada', 'jadwal.sopir', 'kursi'])->latest('id_pemesanan');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pemesanans = $query->get();
        $penumpangs = Penumpang::all();
        $jadwals = Jadwal::with(['armada', 'sopir', 'kursis'])->orderBy('tanggal', 'desc')->get();

        return view('admin.pemesanan.index', compact('pemesanans', 'penumpangs', 'jadwals'));
    }

    public function create()
    {
        $penumpangs = Penumpang::all();
        $jadwals = Jadwal::with(['armada', 'sopir', 'kursis'])->orderBy('tanggal', 'desc')->get();
        return view('admin.pemesanan.create', compact('penumpangs', 'jadwals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_penumpang' => 'required|exists:penumpangs,id_penumpang',
            'id_jadwal' => 'required|exists:jadwals,id_jadwal',
            'id_kursi' => 'required|exists:kursis,id_kursi',
            'status' => 'required|in:Pending,Lunas,Batal',
        ]);

        $kursi = Kursi::findOrFail($validated['id_kursi']);
        if ($validated['status'] !== 'Batal') {
            $kursi->status = 'Terisi';
        } else {
            $kursi->status = 'Tersedia';
        }
        $kursi->save();

        Pemesanan::create([
            'id_penumpang' => $validated['id_penumpang'],
            'id_jadwal' => $validated['id_jadwal'],
            'id_kursi' => $validated['id_kursi'],
            'tanggal_pesan' => now()->toDateString(),
            'jumlah_penumpang' => 1,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.pemesanan.index')->with('success', 'Transaksi pemesanan manual berhasil dibuat!');
    }

    public function show(int|string $id)
    {
        $pemesanan = Pemesanan::with(['penumpang', 'jadwal.armada', 'jadwal.sopir', 'kursi'])->findOrFail($id);
        return view('admin.pemesanan.show', compact('pemesanan'));
    }

    public function edit(int|string $id)
    {
        $pemesanan = Pemesanan::with(['penumpang', 'jadwal.armada', 'jadwal.sopir', 'kursi'])->findOrFail($id);
        $penumpangs = Penumpang::all();
        $jadwals = Jadwal::with(['armada', 'sopir', 'kursis'])->orderBy('tanggal', 'desc')->get();
        return view('admin.pemesanan.edit', compact('pemesanan', 'penumpangs', 'jadwals'));
    }

    public function update(Request $request, int|string $id)
    {
        /** @var Pemesanan $pemesanan */
        $pemesanan = Pemesanan::findOrFail($id);

        $validated = $request->validate([
            'id_penumpang' => 'required|exists:penumpangs,id_penumpang',
            'id_jadwal' => 'required|exists:jadwals,id_jadwal',
            'id_kursi' => 'required|exists:kursis,id_kursi',
            'status' => 'required|in:Pending,Lunas,Batal',
        ]);

        // If seat changed, release old seat
        if ($pemesanan->id_kursi && $pemesanan->id_kursi != $validated['id_kursi']) {
            $oldKursi = Kursi::find($pemesanan->id_kursi);
            if ($oldKursi) {
                $oldKursi->status = 'Tersedia';
                $oldKursi->save();
            }
        }

        // Update new seat status
        $newKursi = Kursi::findOrFail($validated['id_kursi']);
        if ($validated['status'] === 'Batal') {
            $newKursi->status = 'Tersedia';
        } else {
            $newKursi->status = 'Terisi';
        }
        $newKursi->save();

        $pemesanan->update([
            'id_penumpang' => $validated['id_penumpang'],
            'id_jadwal' => $validated['id_jadwal'],
            'id_kursi' => $validated['id_kursi'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.pemesanan.index')->with('success', "Transaksi pemesanan #{$id} berhasil diperbarui!");
    }

    public function updateStatus(Request $request, int|string $id)
    {
        /** @var Pemesanan $pemesanan */
        $pemesanan = Pemesanan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Pending,Lunas,Batal',
        ]);

        $pemesanan->status = $request->status;
        $pemesanan->save();

        // Update seat status if order is cancelled or confirmed
        if ($pemesanan->id_kursi) {
            /** @var Kursi|null $kursi */
            $kursi = Kursi::query()->where('id_kursi', '=', $pemesanan->id_kursi)->first();
            if ($kursi) {
                if ($request->status === 'Batal') {
                    $kursi->status = 'Tersedia';
                } else {
                    $kursi->status = 'Terisi';
                }
                $kursi->save();
            }
        }

        return redirect()->route('admin.pemesanan.index')->with('success', "Status pemesanan #{$id} berhasil diperbarui menjadi {$request->status}!");
    }

    public function destroy(int|string $id)
    {
        /** @var Pemesanan $pemesanan */
        $pemesanan = Pemesanan::findOrFail($id);

        // Free up seat if exists
        if ($pemesanan->id_kursi) {
            /** @var Kursi|null $kursi */
            $kursi = Kursi::query()->where('id_kursi', '=', $pemesanan->id_kursi)->first();
            if ($kursi) {
                $kursi->status = 'Tersedia';
                $kursi->save();
            }
        }

        $pemesanan->delete();

        return redirect()->route('admin.pemesanan.index')->with('success', "Transaksi pemesanan #{$id} berhasil dihapus!");
    }
}
