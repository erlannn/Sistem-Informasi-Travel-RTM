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
            'tujuan' => 'required|in:Sijunjung,Solok,Padang,BIM|different:asal',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) use ($request) {
                    // If the selected date is today, the time must be in the future
                    if ($request->tanggal === now()->toDateString()) {
                        $currentTime = now()->format('H:i:s');
                        if ($value <= $currentTime) {
                            $fail('Jam keberangkatan tidak boleh kurang dari atau sama dengan jam saat ini untuk tanggal hari ini.');
                        }
                    }
                },
            ],
            'harga' => 'required|numeric|min:0',
            'bagi_hasil_sopir' => 'required|numeric|min:0|lte:harga',
        ], [
            'tujuan.different' => 'Kota tujuan tidak boleh sama dengan kota asal.',
            'tanggal.after_or_equal' => 'Tanggal keberangkatan tidak boleh di hari yang sudah lewat.',
            'bagi_hasil_sopir.lte' => 'Gaji / bagi hasil sopir tidak boleh melebihi harga tiket.',
        ]);

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
            'tujuan' => 'required|in:Sijunjung,Solok,Padang,BIM|different:asal',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) use ($request) {
                    if ($request->tanggal === now()->toDateString()) {
                        $currentTime = now()->format('H:i:s');
                        if ($value <= $currentTime) {
                            $fail('Jam keberangkatan tidak boleh kurang dari atau sama dengan jam saat ini untuk tanggal hari ini.');
                        }
                    }
                },
            ],
            'harga' => 'required|numeric|min:0',
            'bagi_hasil_sopir' => 'required|numeric|min:0|lte:harga',
        ], [
            'tujuan.different' => 'Kota tujuan tidak boleh sama dengan kota asal.',
            'tanggal.after_or_equal' => 'Tanggal keberangkatan tidak boleh di hari yang sudah lewat.',
            'bagi_hasil_sopir.lte' => 'Gaji / bagi hasil sopir tidak boleh melebihi harga tiket.',
        ]);

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
