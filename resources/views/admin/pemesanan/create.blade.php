@extends('layouts.admin')

@section('title', 'Tambah Pemesanan Manual - CV Travel RTM')
@section('page_title', 'Tambah Pemesanan Manual')

@section('content')
<div class="max-w-3xl mx-auto space-y-8" x-data="{
    selectedJadwalId: '{{ old('id_jadwal', '') }}',
    selectedKursiId: '{{ old('id_kursi', '') }}',
    jadwals: {{ json_encode($jadwals) }}
}">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                Form Transaksi Manual
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-black tracking-tight mt-2">
                Tambah Pemesanan Tiket Manual
            </h1>
            <p class="text-xs sm:text-sm text-black font-medium mt-1 leading-relaxed">Buat pemesanan tiket baru untuk penumpang secara langsung oleh admin.</p>
        </div>
        <a href="{{ route('admin.pemesanan.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 active:scale-95 text-black font-bold text-xs sm:text-sm rounded-xl transition flex items-center gap-2 cursor-pointer shrink-0">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.pemesanan.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Pilih Penumpang <span class="text-red-500">*</span>
                </label>
                <select name="id_penumpang" required
                    class="w-full px-4 py-3.5 text-sm font-bold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    <option value="">-- Pilih Penumpang --</option>
                    @foreach($penumpangs as $pn)
                        <option value="{{ $pn->id_penumpang }}" {{ old('id_penumpang') == $pn->id_penumpang ? 'selected' : '' }}>
                            {{ $pn->nama }} ({{ $pn->no_hp ?? $pn->email }})
                        </option>
                    @endforeach
                </select>
                @error('id_penumpang')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Pilih Jadwal Perjalanan <span class="text-red-500">*</span>
                </label>
                <select name="id_jadwal" x-model="selectedJadwalId" required
                    class="w-full px-4 py-3.5 text-sm font-bold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach($jadwals as $j)
                        <option value="{{ $j->id_jadwal }}">
                            {{ $j->asal }} &rarr; {{ $j->tujuan }} ({{ $j->tanggal }} - Jam {{ $j->jam }}) - Rp {{ number_format($j->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('id_jadwal')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Pilih Nomor Kursi Tersedia <span class="text-red-500">*</span>
                </label>
                <select name="id_kursi" x-model="selectedKursiId" required :disabled="!selectedJadwalId"
                    class="w-full px-4 py-3.5 text-sm font-bold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition disabled:opacity-50 outline-none">
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
                <p x-show="!selectedJadwalId" class="text-xs text-amber-700 font-bold mt-1.5">
                    Silakan pilih <strong>Jadwal Perjalanan</strong> di atas terlebih dahulu untuk memuat daftar kursi.
                </p>
                @error('id_kursi')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Status Pembayaran <span class="text-red-500">*</span>
                </label>
                <select name="status" required
                    class="w-full px-4 py-3.5 text-sm font-bold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending (Menunggu Bayar)</option>
                    <option value="Lunas" {{ old('status') == 'Lunas' ? 'selected' : '' }}>Lunas (Telah Dibayar)</option>
                    <option value="Batal" {{ old('status') == 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pemesanan.index') }}" class="px-5 py-3 text-xs sm:text-sm font-bold text-black hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 text-xs sm:text-sm font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-95 rounded-xl shadow-sm transition cursor-pointer">
                    Simpan Pemesanan Tiket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
