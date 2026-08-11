@extends('layouts.admin')

@section('title', 'Edit Data Penumpang - CV Travel RTM')
@section('page_title', 'Edit Data Penumpang')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                Edit Penumpang #{{ $penumpang->id_penumpang }}
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-black tracking-tight mt-2">
                Edit Data {{ $penumpang->nama }}
            </h1>
            <p class="text-xs sm:text-sm text-black font-medium mt-1 leading-relaxed">Perbarui informasi diri, email, kontak, atau password akun penumpang.</p>
        </div>
        <a href="{{ route('admin.penumpang.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 active:scale-95 text-black font-bold text-xs sm:text-sm rounded-xl transition flex items-center gap-2 cursor-pointer shrink-0">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.penumpang.update', $penumpang->id_penumpang) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Nama Lengkap Penumpang <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama', $penumpang->nama) }}" required placeholder="Contoh: Budi Santoso"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('nama')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email', $penumpang->email) }}" required placeholder="budi@example.com"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('email')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    No. Handphone / WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $penumpang->no_hp) }}" required placeholder="081234567890"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('no_hp')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Alamat Lengkap <span class="text-red-500">*</span>
                </label>
                <textarea name="alamat" rows="3" required placeholder="Jl. Merdeka No. 123"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">{{ old('alamat', $penumpang->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Password Baru <span class="text-black font-normal lowercase">(kosongkan jika tidak diubah)</span>
                </label>
                <input type="password" name="password" placeholder="Minimal 6 karakter"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('password')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.penumpang.index') }}" class="px-5 py-3 text-xs sm:text-sm font-bold text-black hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 text-xs sm:text-sm font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-95 rounded-xl shadow-sm transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
