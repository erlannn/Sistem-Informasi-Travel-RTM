@extends('layouts.admin')

@section('title', 'Tambah Pemesanan Manual - CV Travel RTM')
@section('page_title', 'Tambah Pemesanan Manual')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{
    selectedJadwalId: '{{ old('id_jadwal', '') }}',
    selectedKursiId: '{{ old('id_kursi', '') }}',
    jadwals: {{ json_encode($jadwals) }}
}">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <span class="px-3 py-1 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[11px] font-extrabold uppercase tracking-wider">
                Form Transaksi Manual
            </span>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Tambah Pemesanan Tiket Manual
            </h1>
            <p class="text-xs text-slate-500 font-medium">Buat pemesanan tiket baru untuk penumpang secara langsung oleh admin.</p>
        </div>
        <a href="{{ route('admin.pemesanan.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition flex items-center gap-2">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.pemesanan.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Pilih Penumpang <span class="text-red-500">*</span>
                </label>
                <select name="id_penumpang" required
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    <option value="">-- Pilih Penumpang --</option>
                    @foreach($penumpangs as $pn)
                        <option value="{{ $pn->id_penumpang }}" {{ old('id_penumpang') == $pn->id_penumpang ? 'selected' : '' }}>
                            {{ $pn->nama }} ({{ $pn->no_hp ?? $pn->email }})
                        </option>
                    @endforeach
                </select>
                @error('id_penumpang')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Pilih Jadwal Perjalanan <span class="text-red-500">*</span>
                </label>
                <select name="id_jadwal" x-model="selectedJadwalId" required
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach($jadwals as $j)
                        <option value="{{ $j->id_jadwal }}">
                            {{ $j->asal }} &rarr; {{ $j->tujuan }} ({{ $j->tanggal }} - Jam {{ $j->jam }}) - Rp {{ number_format($j->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('id_jadwal')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Pilih Nomor Kursi Tersedia <span class="text-red-500">*</span>
                </label>
                <select name="id_kursi" x-model="selectedKursiId" required :disabled="!selectedJadwalId"
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition disabled:opacity-50">
                    <option value="">-- Pilih Kursi --</option>
                    @foreach($jadwals as $j)
                        <optgroup label="Kursi {{ $j->asal }} &rarr; {{ $j->tujuan }} ({{ $j->tanggal }})" x-show="selectedJadwalId == '{{ $j->id_jadwal }}'">
                            @foreach($j->kursis as $k)
                                <option value="{{ $k->id_kursi }}"
                                    x-show="'{{ $k->status }}' === 'Tersedia'"
                                    :disabled="'{{ $k->status }}' !== 'Tersedia'">
                                    Kursi {{ $k->nomor_kursi }} @if($k->status !== 'Tersedia') ({{ $k->status }}) @endif
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <p x-show="!selectedJadwalId" class="text-[11px] text-amber-600 font-semibold mt-1">
                    Silakan pilih <strong>Jadwal Perjalanan</strong> di atas terlebih dahulu untuk memuat daftar kursi.
                </p>
                @error('id_kursi')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Status Pembayaran <span class="text-red-500">*</span>
                </label>
                <select name="status" required
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    <option value="Lunas" {{ old('status', 'Lunas') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Batal" {{ old('status') == 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pemesanan.index') }}" class="px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-extrabold text-slate-950 bg-brand-500 hover:bg-brand-600 rounded-xl shadow-xs transition">
                    Buat Transaksi Pemesanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
