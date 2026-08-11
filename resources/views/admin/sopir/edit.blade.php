@extends('layouts.admin')

@section('title', 'Edit Data Sopir - CV Travel RTM')
@section('page_title', 'Edit Data Sopir')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
<<<<<<< HEAD
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Edit Sopir {{ $sopir->nama }}
            </h1>
        </div>
        <a href="{{ route('admin.sopir.index') }}" class="px-4 py-2.5 bg-red-500 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition flex items-center gap-2">
=======
            <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                Edit Sopir #{{ $sopir->id_sopir }}
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-black tracking-tight mt-2">
                Edit Data {{ $sopir->nama }}
            </h1>
            <p class="text-xs sm:text-sm text-black font-medium mt-1 leading-relaxed">Perbarui informasi kontak, alamat, atau gaji sopir.</p>
        </div>
        <a href="{{ route('admin.sopir.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 active:scale-95 text-black font-bold text-xs sm:text-sm rounded-xl transition flex items-center gap-2 cursor-pointer shrink-0">
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.sopir.update', $sopir->id_sopir) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Nama Lengkap Sopir <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama', $sopir->nama) }}" required placeholder="Contoh: Pak Joko"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('nama')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    No. Telepon / WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $sopir->no_hp) }}" required placeholder="081234567890"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('no_hp')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Alamat Lengkap Sopir
                </label>
                <textarea name="alamat" rows="3" placeholder="Jl. Raya Utama No. 45"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">{{ old('alamat', $sopir->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

<<<<<<< HEAD
            {{-- <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Gaji Sopir (Rp) <span class="text-red-500">*</span>
=======
            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Gaji Pokok Sopir (Rp) <span class="text-red-500">*</span>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                </label>
                <input type="number" name="gaji" value="{{ old('gaji', $sopir->gaji) }}" required min="0" step="50000" placeholder="2500000"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('gaji')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div> --}}

<<<<<<< HEAD
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.sopir.index') }}" class="px-5 py-2.5 text-xs font-bold bg-red-500 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition flex items-center gap-2">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-extrabold text-slate-950 bg-brand-500 hover:bg-brand-600 rounded-xl shadow-xs transition">
                    Simpan
=======
            <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.sopir.index') }}" class="px-5 py-3 text-xs sm:text-sm font-bold text-black hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 text-xs sm:text-sm font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-95 rounded-xl shadow-sm transition cursor-pointer">
                    Simpan Perubahan
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
