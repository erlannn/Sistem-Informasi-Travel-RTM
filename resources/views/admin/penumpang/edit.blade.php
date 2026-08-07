@extends('layouts.admin')

@section('title', 'Edit Data Penumpang - CV Travel RTM')
@section('page_title', 'Edit Data Penumpang')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <span class="px-3 py-1 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[11px] font-extrabold uppercase tracking-wider">
                Edit Penumpang #{{ $penumpang->id_penumpang }}
            </span>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Edit Data {{ $penumpang->nama }}
            </h1>
            <p class="text-xs text-slate-500 font-medium">Perbarui informasi diri, email, kontak, atau password akun penumpang.</p>
        </div>
        <a href="{{ route('admin.penumpang.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition flex items-center gap-2">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.penumpang.update', $penumpang->id_penumpang) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Lengkap Penumpang <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama', $penumpang->nama) }}" required placeholder="Contoh: Budi Santoso"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('nama')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email', $penumpang->email) }}" required placeholder="budi@example.com"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('email')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    No. Handphone / WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $penumpang->no_hp) }}" required placeholder="081234567890"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('no_hp')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Alamat Lengkap <span class="text-red-500">*</span>
                </label>
                <textarea name="alamat" rows="3" required placeholder="Jl. Merdeka No. 123"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('alamat', $penumpang->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Password Baru <span class="text-slate-400 font-normal lowercase">(kosongkan jika tidak diubah)</span>
                </label>
                <input type="password" name="password" placeholder="Minimal 6 karakter"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('password')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.penumpang.index') }}" class="px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-extrabold text-slate-950 bg-brand-500 hover:bg-brand-600 rounded-xl shadow-xs transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
