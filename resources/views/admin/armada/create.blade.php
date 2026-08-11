@extends('layouts.admin')

@section('title', 'Tambah Armada Baru - CV Travel RTM')
@section('page_title', 'Tambah Armada Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
<<<<<<< HEAD
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Tambah Kendaraan Armada Baru
            </h1>
        </div>
        <a href="{{ route('admin.armada.index') }}" class="px-4 py-2.5 bg-red-500 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition flex items-center gap-2">
=======
            <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                Form Armada
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-black tracking-tight mt-2">
                Tambah Kendaraan Armada Baru
            </h1>
            <p class="text-xs sm:text-sm text-black font-medium mt-1 leading-relaxed">Inputkan detail merk, warna, dan status operasional armada ke database.</p>
        </div>
        <a href="{{ route('admin.armada.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 active:scale-95 text-black font-bold text-xs sm:text-sm rounded-xl transition flex items-center gap-2 cursor-pointer shrink-0">
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.armada.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
<<<<<<< HEAD
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Merk Armada <span class="text-red-500">*</span>
=======
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Merk / Tipe Kendaraan <span class="text-red-500">*</span>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                </label>
                <input type="text" name="merk" value="{{ old('merk') }}" required placeholder="Contoh: Toyota HiAce Commuter / Kijang Innova Reborn"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('merk')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Warna Kendaraan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="warna" value="{{ old('warna') }}" required placeholder="Contoh: Putih / Hitam / Silver"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('warna')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
<<<<<<< HEAD
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
=======
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Status Operasional <span class="text-red-500">*</span>
                </label>
                <select name="status" required
                    class="w-full px-4 py-3.5 text-sm font-bold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                    <option value="Perbaikan" {{ old('status') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan / Servis</option>
                    <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

<<<<<<< HEAD
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.armada.index') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-red-500 hover:bg-red-700 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-extrabold text-slate-950 bg-brand-500 hover:bg-brand-600 rounded-xl shadow-xs transition">
                    Simpan
=======
            <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.armada.index') }}" class="px-5 py-3 text-xs sm:text-sm font-bold text-black hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 text-xs sm:text-sm font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-95 rounded-xl shadow-sm transition cursor-pointer">
                    Simpan Armada Baru
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
