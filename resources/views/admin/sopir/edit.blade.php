@extends('layouts.admin')

@section('title', 'Edit Data Sopir - CV Travel RTM')
@section('page_title', 'Edit Data Sopir')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Edit Sopir {{ $sopir->nama }}
            </h1>
        </div>
        <a href="{{ route('admin.sopir.index') }}" class="px-4 py-2.5 bg-red-500 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition flex items-center gap-2">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.sopir.update', $sopir->id_sopir) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Lengkap Sopir <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama', $sopir->nama) }}" required placeholder="Contoh: Pak Joko"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('nama')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    No. Telepon / WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $sopir->no_hp) }}" required placeholder="081234567890"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('no_hp')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Alamat Lengkap Sopir
                </label>
                <textarea name="alamat" rows="3" placeholder="Jl. Raya Utama No. 45"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('alamat', $sopir->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Gaji Sopir (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="gaji" value="{{ old('gaji', $sopir->gaji) }}" required min="0" step="50000" placeholder="2500000"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('gaji')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div> --}}

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.sopir.index') }}" class="px-5 py-2.5 text-xs font-bold bg-red-500 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition flex items-center gap-2">
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
