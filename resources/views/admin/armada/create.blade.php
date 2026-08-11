@extends('layouts.admin')

@section('title', 'Tambah Armada Baru - CV Travel RTM')
@section('page_title', 'Tambah Armada Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Tambah Kendaraan Armada Baru
            </h1>
        </div>
        <a href="{{ route('admin.armada.index') }}" class="px-4 py-2.5 bg-red-500 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition flex items-center gap-2">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.armada.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Merk Armada <span class="text-red-500">*</span>
                </label>
                <input type="text" name="merk" value="{{ old('merk') }}" required placeholder="Contoh: Toyota HiAce Commuter / Isuzu Elf"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('merk')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Warna Kendaraan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="warna" value="{{ old('warna') }}" required placeholder="Contoh: Putih Silver / Hitam Metallic"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('warna')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Jumlah / Kapasitas Kursi <span class="text-red-500">*</span>
                </label>
                <input type="number" name="kursi" value="{{ old('kursi', 5) }}" min="1" max="50" required placeholder="Contoh: 5 (Avanza) atau 3 (Honda Jazz)"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                <p class="text-[11px] text-slate-400 mt-1">Masukkan jumlah kursi total kendaraan (misal 5 untuk Avanza, 3 untuk Honda Jazz).</p>
                @error('kursi')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Status Operasional <span class="text-red-500">*</span>
                </label>
                <select name="status" required
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif (Default)</option>
                    <option value="Perbaikan" {{ old('status') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan / Servis</option>
                    <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.armada.index') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-red-500 hover:bg-red-700 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-extrabold text-slate-950 bg-brand-500 hover:bg-brand-600 rounded-xl shadow-xs transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
