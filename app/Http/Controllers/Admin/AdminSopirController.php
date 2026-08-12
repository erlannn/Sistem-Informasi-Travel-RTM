<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sopir;
use Illuminate\Http\Request;

class AdminSopirController extends Controller
{
    public function index(Request $request)
    {
        $query = Sopir::withCount('jadwals')->latest('id_sopir');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $sopirs = $query->get();

        return view('admin.sopir.index', compact('sopirs'));
    }

    public function create()
    {
        return view('admin.sopir.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'nullable|in:Aktif,Tidak Aktif',
        ]);

        $validated['status'] = $validated['status'] ?? 'Aktif';

        Sopir::create($validated);

        return redirect()->route('admin.sopir.index')->with('success', 'Data sopir berhasil ditambahkan ke database!');
    }

    public function show(int|string $id)
    {
        $sopir = Sopir::with(['jadwals.armada', 'jadwals.pemesanans'])->withCount('jadwals')->findOrFail($id);
        return view('admin.sopir.show', compact('sopir'));
    }

    public function edit(int|string $id)
    {
        $sopir = Sopir::findOrFail($id);
        return view('admin.sopir.edit', compact('sopir'));
    }

    public function update(Request $request, int|string $id)
    {
        /** @var Sopir $sopir */
        $sopir = Sopir::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $sopir->fill($validated)->save();

        return redirect()->route('admin.sopir.index')->with('success', 'Data sopir berhasil diperbarui di database!');
    }

    public function destroy(int|string $id)
    {
        /** @var Sopir $sopir */
        $sopir = Sopir::findOrFail($id);

        $sopir->status = 'Tidak Aktif';
        $sopir->save();

        return redirect()->route('admin.sopir.index')->with('success', 'Data sopir berhasil dinon-aktifkan!');
    }
}
