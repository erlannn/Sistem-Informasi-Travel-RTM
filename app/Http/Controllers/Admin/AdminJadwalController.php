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
    /**
     * Helper to get harga & bagi_hasil_sopir based on route
     */
    private function getRoutePricing(string $asal, string $tujuan): ?array
    {
        $matrix = [
            'Sijunjung-Solok' => ['harga' => 50000.00, 'bagi_hasil_sopir' => 20000.00],
            'Solok-Sijunjung' => ['harga' => 50000.00, 'bagi_hasil_sopir' => 20000.00],

            'Sijunjung-Padang' => ['harga' => 80000.00, 'bagi_hasil_sopir' => 30000.00],
            'Padang-Sijunjung' => ['harga' => 80000.00, 'bagi_hasil_sopir' => 30000.00],

            'Sijunjung-BIM'   => ['harga' => 150000.00, 'bagi_hasil_sopir' => 50000.00],
            'BIM-Sijunjung'   => ['harga' => 150000.00, 'bagi_hasil_sopir' => 50000.00],
        ];

        $key = "{$asal}-{$tujuan}";
        return $matrix[$key] ?? null;
    }

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

        $jadwals = $query->paginate(10)->withQueryString();
        $armadas = Armada::all();
        $sopirs = Sopir::all();

        return view('admin.jadwal.index', compact('jadwals', 'armadas', 'sopirs'));
    }

    public function create()
    {
        $armadas = Armada::all();
        $sopirs = Sopir::query()->where('status', 'Aktif')->get();
        return view('admin.jadwal.create', compact('armadas', 'sopirs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_armada' => 'required|exists:armadas,id_armada',
            'id_sopir' => 'required|exists:sopirs,id_sopir',
            'asal' => 'required|in:Sijunjung,Solok,Padang,BIM',
            'tujuan' => 'required|in:Sijunjung,Solok,Padang,BIM',
            'tanggal' => 'required|date',
            'jam' => 'required|string',
        ]);

        $pricing = $this->getRoutePricing($validated['asal'], $validated['tujuan']);
        if (!$pricing) {
            return back()->withInput()->withErrors(['tujuan' => 'Rute perjalanan tidak valid. Hanya tersedia 6 rute antara Sijunjung, Solok, Padang, dan BIM.']);
        }

        $validated['harga'] = $pricing['harga'];
        $validated['bagi_hasil_sopir'] = $pricing['bagi_hasil_sopir'];

        /** @var Jadwal $jadwal */
        $jadwal = Jadwal::create($validated);

        $armada = Armada::find($validated['id_armada'], ['*']);
        $totalKursi = $armada ? ($armada->kursi ?? 6) : 6;

        // Generate seats automatically matching the armada seat count
        for ($i = 1; $i <= $totalKursi; $i++) {
            Kursi::create([
                'id_jadwal' => $jadwal->id_jadwal,
                'nomor_kursi' => (string) $i,
                'status' => 'Tersedia',
            ]);
        }

        return redirect()->route('admin.jadwal.index')->with('success', "Jadwal perjalanan baru & {$totalKursi} kursi berhasil dibuat!");
    }

    public function show(int|string $id)
    {
        $jadwal = Jadwal::with(['armada', 'sopir', 'kursis', 'pemesanans.penumpang', 'pemesanans.kursi'])->findOrFail($id);
        return view('admin.jadwal.show', compact('jadwal'));
    }

    public function edit(int|string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $armadas = Armada::query()->where('status', 'Aktif')
            ->orWhere('id_armada', $jadwal->id_armada)
            ->get();
        $sopirs = Sopir::query()->where('status', 'Aktif')
            ->orWhere('id_sopir', $jadwal->id_sopir)
            ->get();
        return view('admin.jadwal.edit', compact('jadwal', 'armadas', 'sopirs'));
    }

    public function update(Request $request, int|string $id)
    {
        /** @var Jadwal $jadwal */
        $jadwal = Jadwal::findOrFail($id);

        $validated = $request->validate([
            'id_armada' => 'required|exists:armadas,id_armada',
            'id_sopir' => 'required|exists:sopirs,id_sopir',
            'asal' => 'required|in:Sijunjung,Solok,Padang,BIM',
            'tujuan' => 'required|in:Sijunjung,Solok,Padang,BIM',
            'tanggal' => 'required|date',
            'jam' => 'required|string',
        ]);

        $pricing = $this->getRoutePricing($validated['asal'], $validated['tujuan']);
        if (!$pricing) {
            return back()->withInput()->withErrors(['tujuan' => 'Rute perjalanan tidak valid. Hanya tersedia 6 rute antara Sijunjung, Solok, Padang, dan BIM.']);
        }

        $validated['harga'] = $pricing['harga'];
        $validated['bagi_hasil_sopir'] = $pricing['bagi_hasil_sopir'];

        $jadwal->fill($validated)->save();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal perjalanan berhasil diperbarui!');
    }

    public function destroy(int|string $id)
    {
        /** @var Jadwal $jadwal */
        $jadwal = Jadwal::findOrFail($id);

        if ($jadwal->pemesanans()->count('*') > 0) {
            return redirect()->route('admin.jadwal.index')->with('error', 'Jadwal tidak dapat dihapus karena sudah ada pemesanan tiket pada jadwal ini!');
        }

        // Remove related seats first
        Kursi::query()->where('id_jadwal', '=', $id)->delete();
        Jadwal::destroy($id);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal perjalanan & data kursi berhasil dihapus!');
    }
}
