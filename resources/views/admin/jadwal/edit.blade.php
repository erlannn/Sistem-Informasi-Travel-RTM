@extends('layouts.admin')

@section('title', 'Edit Jadwal Perjalanan - CV Travel RTM')
@section('page_title', 'Edit Jadwal Keberangkatan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <span class="px-3 py-1 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[11px] font-extrabold uppercase tracking-wider">
                Edit Jadwal #{{ $jadwal->id_jadwal }}
            </span>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Edit Rute {{ $jadwal->asal }} &rarr; {{ $jadwal->tujuan }}
            </h1>
            <p class="text-xs text-slate-500 font-medium">Perbarui informasi tanggal, waktu, armada, sopir, atau harga tiket.</p>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition flex items-center gap-2">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.jadwal.update', $jadwal->id_jadwal) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kota Asal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="asal" value="{{ old('asal', $jadwal->asal) }}" required placeholder="Contoh: Sijunjung"
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    @error('asal')
                        <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kota Tujuan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tujuan" value="{{ old('tujuan', $jadwal->tujuan) }}" required placeholder="Contoh: Padang"
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    @error('tujuan')
                        <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Tanggal Keberangkatan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal) }}" required
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    @error('tanggal')
                        <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Jam Keberangkatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="jam" value="{{ old('jam', $jadwal->jam) }}" required placeholder="08:00"
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    @error('jam')
                        <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Pilih Armada Kendaraan <span class="text-red-500">*</span>
                </label>
                <select name="id_armada" required
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    <option value="">-- Pilih Armada --</option>
                    @foreach($armadas as $a)
                        <option value="{{ $a->id_armada }}" {{ old('id_armada', $jadwal->id_armada) == $a->id_armada ? 'selected' : '' }}>
                            {{ $a->merk }} ({{ $a->warna }}) - Status: {{ $a->status }}
                        </option>
                    @endforeach
                </select>
                @error('id_armada')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Pilih Sopir Ditugaskan <span class="text-red-500">*</span>
                </label>
                <select name="id_sopir" required
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    <option value="">-- Pilih Sopir --</option>
                    @foreach($sopirs as $s)
                        <option value="{{ $s->id_sopir }}" {{ old('id_sopir', $jadwal->id_sopir) == $s->id_sopir ? 'selected' : '' }}>
                            {{ $s->nama }} (HP: {{ $s->no_hp }})
                        </option>
                    @endforeach
                </select>
                @error('id_sopir')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Harga Tiket per Kursi (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="harga" value="{{ old('harga', $jadwal->harga) }}" required min="0" step="1000" placeholder="100000"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('harga')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.jadwal.index') }}" class="px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">
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
