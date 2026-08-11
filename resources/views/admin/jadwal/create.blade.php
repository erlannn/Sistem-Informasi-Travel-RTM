@extends('layouts.admin')

@section('title', 'Buat Jadwal Baru - CV Travel RTM')
@section('page_title', 'Buat Jadwal Keberangkatan Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                Form Jadwal Perjalanan
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-black tracking-tight mt-2">
                Buat Jadwal Perjalanan Baru
            </h1>
            <p class="text-xs sm:text-sm text-black font-medium mt-1 leading-relaxed">Atur rute, tanggal, jam keberangkatan, armada, sopir, dan harga tiket travel.</p>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 active:scale-95 text-black font-bold text-xs sm:text-sm rounded-xl transition flex items-center gap-2 cursor-pointer shrink-0">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                        Kota Asal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="asal" value="{{ old('asal', 'Sijunjung') }}" required placeholder="Contoh: Sijunjung"
                        class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    @error('asal')
                        <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                        Kota Tujuan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tujuan" value="{{ old('tujuan', 'Padang') }}" required placeholder="Contoh: Padang"
                        class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    @error('tujuan')
                        <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                        Tanggal Keberangkatan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                        class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    @error('tanggal')
                        <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                        Jam Keberangkatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="jam" value="{{ old('jam', '08:00') }}" required placeholder="08:00"
                        class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    @error('jam')
                        <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Pilih Armada Kendaraan <span class="text-red-500">*</span>
                </label>
                <select name="id_armada" required
                    class="w-full px-4 py-3.5 text-sm font-bold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    <option value="">-- Pilih Armada --</option>
                    @foreach($armadas as $a)
                        <option value="{{ $a->id_armada }}" {{ old('id_armada') == $a->id_armada ? 'selected' : '' }}>
                            {{ $a->merk }} ({{ $a->warna }}) - Status: {{ $a->status }}
                        </option>
                    @endforeach
                </select>
                @error('id_armada')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Pilih Sopir Ditugaskan <span class="text-red-500">*</span>
                </label>
                <select name="id_sopir" required
                    class="w-full px-4 py-3.5 text-sm font-bold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    <option value="">-- Pilih Sopir --</option>
                    @foreach($sopirs as $s)
                        <option value="{{ $s->id_sopir }}" {{ old('id_sopir') == $s->id_sopir ? 'selected' : '' }}>
                            {{ $s->nama }} (HP: {{ $s->no_hp }})
                        </option>
                    @endforeach
                </select>
                @error('id_sopir')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Harga Tiket per Kursi (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="harga" value="{{ old('harga', '100000') }}" required min="0" step="1000" placeholder="100000"
                    class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                @error('harga')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.jadwal.index') }}" class="px-5 py-3 text-xs sm:text-sm font-bold text-black hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 text-xs sm:text-sm font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-95 rounded-xl shadow-sm transition cursor-pointer">
                    Simpan & Buat 6 Kursi Otomatis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
