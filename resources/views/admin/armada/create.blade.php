@extends('layouts.admin')

@section('title', 'Tambah Armada Baru - CV Travel RTM')
@section('page_title', 'Tambah Armada Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Tambah Kendaraan Armada Baru
            </h1>
        </div>
        <a href="{{ route('admin.armada.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition flex items-center gap-2">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.armada.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Input: Merk Armada -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Merk Armada <span class="text-red-500">*</span>
                </label>
                <input type="text" name="merk" value="{{ old('merk') }}" required placeholder="Contoh: Toyota HiAce Commuter / Kijang Innova Reborn"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('merk')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input: Warna Kendaraan -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Warna Kendaraan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="warna" value="{{ old('warna') }}" required placeholder="Contoh: Putih / Hitam / Silver"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('warna')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input: Kapasitas Kursi -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Jumlah / Kapasitas Kursi <span class="text-red-500">*</span>
                </label>
                <input type="number" name="kursi" value="{{ old('kursi', 5) }}" min="1" max="50" required placeholder="Contoh: 5 (Avanza) atau 3 (Honda Jazz)"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                <p class="text-[11px] text-slate-400 mt-1">Masukkan jumlah kursi total kendaraan (misal 5 untuk Avanza, 3 untuk Honda Jazz).</p>
                @error('kursi')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input: Status Operasional -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Status Operasional <span class="text-red-500">*</span>
                </label>
                <select name="status" required class="w-full px-4 py-3.5 text-sm font-bold text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none cursor-pointer">
                    <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif (Default)</option>
                    <option value="Perbaikan" {{ old('status') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan / Servis</option>
                    <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi Form -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.armada.index') }}" class="px-5 py-3 text-xs sm:text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 text-xs sm:text-sm font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-95 rounded-xl shadow-xs transition cursor-pointer">
                    Simpan Armada Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection