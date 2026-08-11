<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Kursi;
use Illuminate\Http\Request;

class AdminPemesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with(['penumpang', 'jadwal.armada', 'jadwal.sopir', 'kursi'])->latest('id_pemesanan');

        $status = $request->input('status_perjalanan', $request->input('status'));
        if ($status && in_array($status, ['Pending', 'Selesai', 'Batal'])) {
            $query->where('status_perjalanan', $status);
        }

        $pemesanans = $query->get();

        return view('admin.pemesanan.index', compact('pemesanans'));
    }

    public function show(int|string $id)
    {
        $pemesanan = Pemesanan::with(['penumpang', 'jadwal.armada', 'jadwal.sopir', 'kursi'])->findOrFail($id);
        return view('admin.pemesanan.show', compact('pemesanan'));
    }

    public function updateStatus(Request $request, int|string $id)
    {
        /** @var Pemesanan $pemesanan */
        $pemesanan = Pemesanan::findOrFail($id);

        $statusPerjalanan = $request->input('status_perjalanan', $request->input('status'));
        $request->validate([
            'status_perjalanan' => 'nullable|in:Pending,Selesai,Batal',
            'status' => 'nullable|in:Pending,Selesai,Batal',
        ]);

        if ($statusPerjalanan && in_array($statusPerjalanan, ['Pending', 'Selesai', 'Batal'])) {
            $pemesanan->status_perjalanan = $statusPerjalanan;

            if ($statusPerjalanan === 'Selesai') {
                $pemesanan->status_pembayaran = 'Lunas';
                if (!$pemesanan->waktu_bayar) {
                    $pemesanan->waktu_bayar = now();
                }
            }
        }

        $pemesanan->save();

        // Update seat status based on journey status
        if ($pemesanan->id_kursi) {
            /** @var Kursi|null $kursi */
            $kursi = Kursi::query()->where('id_kursi', '=', $pemesanan->id_kursi)->first();
            if ($kursi) {
                if ($pemesanan->status_perjalanan === 'Batal') {
                    $kursi->status = 'Kosong';
                } else {
                    $kursi->status = 'Terisi';
                }
                $kursi->save();
            }
        }

        return redirect()->route('admin.pemesanan.index')->with('success', "Status perjalanan pemesanan #{$id} berhasil diperbarui!");
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
                $kursi->status = 'Kosong';
                $kursi->save();
            }
        }

        Pemesanan::destroy($id);

        return redirect()->route('admin.pemesanan.index')->with('success', "Transaksi pemesanan #{$id} berhasil dihapus!");
    }
}
