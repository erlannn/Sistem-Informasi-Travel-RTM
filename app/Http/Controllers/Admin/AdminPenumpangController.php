<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penumpang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPenumpangController extends Controller
{
    public function index(Request $request)
    {
        $query = Penumpang::withCount('pemesanans')->latest('id_penumpang');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $penumpangs = $query->get();

        return view('admin.penumpang.index', compact('penumpangs'));
    }

    public function create()
    {
        return view('admin.penumpang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email|unique:penumpangs,email',
            'password' => 'required|string|min:6',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $hashedPassword = Hash::make($validated['password']);

        // Create User account for authentication
        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => $hashedPassword,
        ]);
        $user->assignRole('Penumpang');

        // Create Penumpang model record
        Penumpang::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => $hashedPassword,
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
        ]);

        return redirect()->route('admin.penumpang.index')->with('success', 'Data penumpang berhasil ditambahkan!');
    }

    public function show(int|string $id)
    {
        $penumpang = Penumpang::with(['pemesanans.jadwal.armada', 'pemesanans.jadwal.sopir', 'pemesanans.kursi'])->findOrFail($id);
        return view('admin.penumpang.show', compact('penumpang'));
    }

    public function edit(int|string $id)
    {
        $penumpang = Penumpang::findOrFail($id);
        return view('admin.penumpang.edit', compact('penumpang'));
    }

    public function update(Request $request, int|string $id)
    {
        /** @var Penumpang $penumpang */
        $penumpang = Penumpang::findOrFail($id);
        $oldEmail = $penumpang->email;
        $user = User::where('email', $oldEmail)->first();

        // Remove empty password string so nullable min:6 validation passes
        if ($request->input('password') === '' || $request->input('password') === null) {
            $request->request->remove('password');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255',
                \Illuminate\Validation\Rule::unique('penumpangs', 'email')->ignore($id, 'id_penumpang'),
                \Illuminate\Validation\Rule::unique('users', 'email')->ignore($user ? $user->id : null),
            ],
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $penumpang->update($updateData);

        // Update corresponding User account if exists
        if ($user) {
            $userData = [
                'name' => $validated['nama'],
                'email' => $validated['email'],
            ];
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            $user->update($userData);
        }

        return redirect()->route('admin.penumpang.index')->with('success', 'Data penumpang berhasil diperbarui!');
    }

    public function destroy(int|string $id)
    {
        /** @var Penumpang $penumpang */
        $penumpang = Penumpang::findOrFail($id);
        $email = $penumpang->email;

        $penumpang->delete();

        // Delete user account if exists
        User::where('email', $email)->delete();

        return redirect()->route('admin.penumpang.index')->with('success', 'Data penumpang berhasil dihapus!');
    }
}
