@extends('layouts.penumpang')

@section('title', 'Jadwal Perjalanan - RTM Family')

@section('content')
@php
    $asal = request('asal', $asal ?? 'Sijunjung');
    $tujuan = request('tujuan', $tujuan ?? 'Padang');
    $tanggal = request('tanggal', $tanggal ?? date('Y-m-d'));
@endphp

<div class="py-8 bg-slate-50 md:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">
        
        <!-- Header Title -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Jadwal Perjalanan</h1>
            <p class="mt-1 text-sm text-slate-500">Pilih armada terbaik yang sesuai dengan kebutuhan perjalanan Anda</p>
        </div>

        <!-- Search Summary Bar (UX Correction: Interactive Inline Form with defaults) -->
        <form action="{{ route('penumpang.jadwal') }}" method="GET" class="bg-slate-900 text-white rounded-2xl p-5 md:p-6 mb-8 shadow-md border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 divide-y sm:divide-y-0 sm:divide-x divide-slate-800 w-full md:w-auto flex-grow">
                <!-- Asal -->
                <div class="flex flex-col pr-2">
                    <label for="summary-asal" class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Asal</label>
                    <div class="relative">
                        <select id="summary-asal" name="asal" class="bg-transparent text-sm font-semibold text-white outline-none cursor-pointer border-b border-transparent hover:border-slate-500 transition-colors py-0.5 pr-4 appearance-none">
                            <option value="Sijunjung" class="text-slate-900" {{ $asal == 'Sijunjung' ? 'selected' : '' }}>Sijunjung</option>
                            <option value="Padang" class="text-slate-900" {{ $asal == 'Padang' ? 'selected' : '' }}>Padang</option>
                            <option value="Solok" class="text-slate-900" {{ $asal == 'Solok' ? 'selected' : '' }}>Solok</option>
                            <option value="Bukittinggi" class="text-slate-900" {{ $asal == 'Bukittinggi' ? 'selected' : '' }}>Bukittinggi</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pointer-events-none text-slate-400 text-xs">▼</span>
                    </div>
                </div>
                <!-- Tujuan -->
                <div class="flex flex-col sm:pl-4 pr-2 pt-2 sm:pt-0">
                    <label for="summary-tujuan" class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Tujuan</label>
                    <div class="relative">
                        <select id="summary-tujuan" name="tujuan" class="bg-transparent text-sm font-semibold text-white outline-none cursor-pointer border-b border-transparent hover:border-slate-500 transition-colors py-0.5 pr-4 appearance-none">
                            <option value="Padang" class="text-slate-900" {{ $tujuan == 'Padang' ? 'selected' : '' }}>Padang</option>
                            <option value="Sijunjung" class="text-slate-900" {{ $tujuan == 'Sijunjung' ? 'selected' : '' }}>Sijunjung</option>
                            <option value="Solok" class="text-slate-900" {{ $tujuan == 'Solok' ? 'selected' : '' }}>Solok</option>
                            <option value="Bukittinggi" class="text-slate-900" {{ $tujuan == 'Bukittinggi' ? 'selected' : '' }}>Bukittinggi</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pointer-events-none text-slate-400 text-xs">▼</span>
                    </div>
                </div>
                <!-- Tanggal -->
                <div class="flex flex-col sm:pl-4 pr-2 pt-2 sm:pt-0">
                    <label for="summary-tanggal" class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Tanggal Perjalanan</label>
                    <input type="date" id="summary-tanggal" name="tanggal" value="{{ $tanggal }}" class="bg-transparent text-sm font-semibold text-white outline-none cursor-pointer border-b border-transparent hover:border-slate-500 transition-colors py-0.5" style="color-scheme: dark;">
                </div>
                <!-- Harga (Statis info) -->
                <div class="flex flex-col sm:pl-4 pt-2 sm:pt-0">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Status Pencarian</span>
                    <span class="text-sm font-extrabold text-gold-400 py-0.5">{{ count($jadwals) }} Jadwal</span>
                </div>
            </div>
            
            <!-- Update Button -->
            <button type="submit" class="px-4 py-2.5 text-xs font-bold text-slate-900 bg-gold-400 hover:bg-gold-500 rounded-xl shadow-sm transition-colors text-center shrink-0 cursor-pointer flex items-center justify-center gap-1.5 focus:outline-none focus:ring-2 focus:ring-gold-500">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                Update Jadwal
            </button>
        </form>

        <!-- Schedule Cards List -->
        <div class="space-y-6">
            @forelse($jadwals as $index => $j)
                @php
                    $availableSeats = $j->kursis ? $j->kursis->where('status', 'Kosong')->count() : 6;
                @endphp
                <div class="group relative bg-white hover:bg-slate-50/20 rounded-2xl border border-slate-200/80 p-5 md:p-6 transition-all duration-300 hover:shadow-card hover:border-gold-500/30 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    @if($loop->first)
                        <!-- Glowing Gold Edge Ribbon for CBF recommendation -->
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gold-500 rounded-l-2xl"></div>
                    @endif

                    <div class="flex items-start gap-4">
                        <!-- Custom Car Icon inside badge -->
                        <div class="mt-1 flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100 text-slate-700 shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>

                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-base md:text-lg font-bold text-slate-900">Armada : {{ $j->armada->merk ?? 'Toyota Avanza' }}</h3>
                                
                                @if($loop->first)
                                    <!-- Content-Based Filtering Badge -->
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-extrabold text-gold-700 bg-gold-50 border border-gold-200/50 rounded-full select-none cursor-help relative group/tooltip shadow-[0_1px_4px_rgba(245,158,11,0.08)]">
                                        <span>★</span> Rekomendasi CBF
                                        
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover/tooltip:block w-48 p-2 text-[10px] font-medium text-white bg-slate-950 rounded-lg text-center leading-normal shadow-md z-30 pointer-events-none">
                                            Cocok dengan rute {{ $j->asal }} &rarr; {{ $j->tujuan }} dan jam keberangkatan pilihan.
                                        </span>
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500">
                                <!-- Time -->
                                <span class="flex items-center gap-1 font-semibold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-lg">
                                    Jam : {{ \Carbon\Carbon::parse($j->jam)->format('H.i') }} WIB ({{ $j->tanggal }})
                                </span>
                                <span class="text-slate-300 hidden sm:inline">|</span>
                                <!-- Seats -->
                                <span class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $availableSeats > 0 ? 'bg-status-success' : 'bg-status-danger' }}"></span>
                                    Kursi Tersedia : <strong class="text-slate-800 font-bold">{{ $availableSeats }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Column -->
                    <div class="flex items-center md:flex-col md:items-end justify-between md:justify-center border-t md:border-t-0 border-slate-200/60 pt-4 md:pt-0 gap-3">
                        <div class="text-left md:text-right">
                            <span class="text-xs text-slate-400 block">Total Bayar</span>
                            <span class="text-base font-extrabold text-gold-600">Rp {{ number_format($j->harga, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('penumpang.pilih_kursi', $j->id_jadwal) }}" class="px-5 py-2.5 text-xs font-bold text-white bg-slate-900 hover:bg-slate-950 border border-gold-500/20 hover:border-gold-500/50 rounded-xl shadow-xs transition-colors cursor-pointer text-center">
                            Pilih Jadwal
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-slate-600 font-bold text-base">Tidak ditemukan jadwal untuk kriteria pencarian ini.</p>
                    <p class="text-xs text-slate-400 mt-1">Coba ubah kota asal, tujuan, atau tanggal perjalanan Anda.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
