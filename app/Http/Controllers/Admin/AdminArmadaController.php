<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Armada;
use Illuminate\Http\Request;

class AdminArmadaController extends Controller
{
    public function index(Request $request)
    {
        $query = Armada::withCount('jadwals')->latest('id_armada');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                  ->orWhere('warna', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $armadas = $query->paginate(10)->withQueryString();

        return view('admin.armada.index', compact('armadas'));
    }

    public function create()
    {
        return view('admin.armada.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'merk' => 'required|string|max:255',
            'warna' => 'required|string|max:100',
            'kursi' => 'required|integer|min:1|max:50',
            'status' => 'nullable|in:Aktif,Nonaktif,Perbaikan',
        ]);

        $validated['status'] = $validated['status'] ?? 'Aktif';

        Armada::create($validated);

        return redirect()->route('admin.armada.index')->with('success', 'Data armada berhasil ditambahkan ke database!');
    }

    public function show(int|string $id)
    {
        $armada = Armada::with(['jadwals.sopir', 'jadwals.pemesanans'])->withCount('jadwals')->findOrFail($id);
        return view('admin.armada.show', compact('armada'));
    }

    public function edit(int|string $id)
    {
        $armada = Armada::findOrFail($id);
        return view('admin.armada.edit', compact('armada'));
    }

    public function update(Request $request, int|string $id)
    {
        /** @var Armada $armada */
        $armada = Armada::findOrFail($id);

        $validated = $request->validate([
            'merk' => 'required|string|max:255',
            'warna' => 'required|string|max:100',
            'kursi' => 'required|integer|min:1|max:50',
            'status' => 'required|in:Aktif,Nonaktif,Perbaikan',
        ]);

        $armada->fill($validated)->save();

        return redirect()->route('admin.armada.index')->with('success', 'Data armada berhasil diperbarui di database!');
    }

    public function destroy(int|string $id)
    {
        /** @var Armada $armada */
        $armada = Armada::findOrFail($id);

        // Check if armada has linked schedules
        if ($armada->jadwals()->count('*') > 0) {
            return redirect()->route('admin.armada.index')->with('error', 'Armada tidak dapat dihapus karena masih terikat pada jadwal perjalanan!');
        }

        Armada::destroy($id);

        return redirect()->route('admin.armada.index')->with('success', 'Data armada berhasil dihapus dari database!');
    }
}
