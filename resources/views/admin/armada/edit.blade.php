@extends('layouts.admin')

@section('title', 'Edit Armada - CV Travel RTM')
@section('page_title', 'Edit Data Armada')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                Edit Armada #{{ $armada->id_armada }}
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-black tracking-tight mt-2">
                Edit Armada {{ $armada->merk }}
            </h1>
            <p class="text-xs sm:text-sm text-black font-medium mt-1 leading-relaxed">Perbarui rincian merk, warna, atau status operasional kendaraan.</p>
        </div>
        <a href="{{ route('admin.armada.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 active:scale-95 text-black font-bold text-xs sm:text-sm rounded-xl transition flex items-center gap-2 cursor-pointer shrink-0">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.armada.update', $armada->id_armada) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Merk / Tipe Kendaraan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="merk" value="{{ old('merk', $armada->merk) }}" required placeholder="Contoh: Toyota HiAce Commuter"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('merk')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Warna Kendaraan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="warna" value="{{ old('warna', $armada->warna) }}" required placeholder="Contoh: Putih / Hitam / Silver"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('warna')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Jumlah / Kapasitas Kursi <span class="text-red-500">*</span>
                </label>
                <input type="number" name="kursi" value="{{ old('kursi', $armada->kursi ?? 5) }}" min="1" max="50" required placeholder="Contoh: 5"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('kursi')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Status Operasional <span class="text-red-500">*</span>
                </label>
                <select name="status" required
                    class="w-full px-4 py-3.5 text-sm font-bold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    <option value="Aktif" {{ old('status', $armada->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Perbaikan" {{ old('status', $armada->status) == 'Perbaikan' ? 'selected' : '' }}>Perbaikan / Servis</option>
                    <option value="Nonaktif" {{ old('status', $armada->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.armada.index') }}" class="px-5 py-3 text-xs sm:text-sm font-bold text-black hover:bg-slate-100 rounded-xl transition cursor-pointer">
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
