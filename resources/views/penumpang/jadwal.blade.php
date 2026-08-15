@extends('layouts.penumpang')

@section('title', 'Jadwal Perjalanan - RTM Family')

@section('content')
@php
    $asal = request('asal', $asal ?? '');
    $tujuan = request('tujuan', $tujuan ?? '');
    $tanggal = request('tanggal', $tanggal ?? '');
    $optAsal = $optAsal ?? ['Sijunjung', 'Solok', 'Padang', 'BIM'];
    $optTujuan = $optTujuan ?? ['Padang', 'Solok', 'BIM', 'Sijunjung'];
@endphp

<div class="py-8 bg-slate-50 md:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">
        
        <!-- Header Title -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Jadwal Perjalanan</h1>
            <p class="mt-1 text-sm text-slate-500">Pilih armada terbaik yang sesuai dengan kebutuhan perjalanan Anda</p>
        </div>

        <!-- Search Summary Bar (UX Correction: Interactive Inline Form) -->
        <form action="{{ route('penumpang.jadwal') }}" method="GET" class="bg-slate-900 text-white rounded-2xl p-5 md:p-6 mb-8 shadow-md border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 divide-y sm:divide-y-0 divide-slate-800/60 w-full md:w-auto flex-grow">
                <!-- Asal -->
                <div class="flex flex-col items-center justify-center pr-2">
                    <label for="summary-asal" class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1.5 text-center">Asal</label>
                    <div class="relative w-full">
                        <select id="summary-asal" name="asal" class="w-full bg-slate-800/80 text-sm font-semibold text-white outline-none cursor-pointer border border-slate-700 hover:border-slate-500 rounded-xl transition-colors py-2.5 px-6 text-center appearance-none focus:ring-2 focus:ring-gold-500/40">
                            <option value="" class="text-white text-center" {{ empty($asal) ? 'selected' : '' }}>-- Semua Asal --</option>
                            @foreach($optAsal as $item)
                                <option value="{{ $item }}" class="text-white text-center" {{ $asal == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400 text-xs">▼</span>
                    </div>
                </div>
                <!-- Tujuan -->
                <div class="flex flex-col items-center justify-center sm:pl-4 pr-2 pt-2 sm:pt-0">
                    <label for="summary-tujuan" class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1.5 text-center">Tujuan</label>
                    <div class="relative w-full">
                        <select id="summary-tujuan" name="tujuan" class="w-full bg-slate-800/80 text-sm font-semibold text-white outline-none cursor-pointer border border-slate-700 hover:border-slate-500 rounded-xl transition-colors py-2.5 px-6 text-center appearance-none focus:ring-2 focus:ring-gold-500/40">
                            <option value="" class="text-white text-center" {{ empty($tujuan) ? 'selected' : '' }}>-- Semua Tujuan --</option>
                            @foreach($optTujuan as $item)
                                <option value="{{ $item }}" class="text-white text-center" {{ $tujuan == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400 text-xs">▼</span>
                    </div>
                </div>
                <!-- Tanggal -->
                <div class="flex flex-col items-center justify-center sm:pl-4 pr-2 pt-2 sm:pt-0">
                    <label for="summary-tanggal" class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1.5 text-center">Tanggal Perjalanan</label>
                    <div class="relative w-full">
                        <input type="date" id="summary-tanggal" name="tanggal" value="{{ $tanggal }}" min="{{ date('Y-m-d') }}" class="w-full bg-slate-800/80 text-sm font-semibold text-white outline-none cursor-pointer border border-slate-700 hover:border-slate-500 rounded-xl transition-colors py-2 px-4 text-center focus:ring-2 focus:ring-gold-500/40" style="color-scheme: dark;">
                    </div>
                </div>
                <!-- Status Pencarian -->
                <div class="flex flex-col items-center justify-center sm:pl-4 pt-2 sm:pt-0">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1.5 text-center">Status Pencarian</span>
                    <span class="text-sm font-extrabold text-gold-400 py-2.5 text-center">{{ $jadwals->total() }} Jadwal</span>
                </div>
            </div>
            
            <!-- Update Button -->
            <button type="submit" class="px-5 py-3 text-xs font-bold text-slate-900 bg-gold-400 hover:bg-gold-500 rounded-xl shadow-sm transition-colors text-center shrink-0 cursor-pointer flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-gold-500 self-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z" />
                </svg>
                Cari Jadwal
            </button>
        </form>

        <!-- Schedule Cards List -->
        <div class="space-y-6">
            @forelse($jadwals as $index => $j)
                @php
                    $availableSeats = $j->kursis ? $j->kursis->where('status', '!=', 'Terisi')->count() : ($j->armada->kursi ?? 6);
                @endphp
                <div class="group relative bg-white hover:bg-slate-50/20 rounded-2xl border border-slate-200/80 p-5 md:p-6 transition-all duration-300 hover:shadow-card hover:border-gold-500/30 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    @if($loop->first && $jadwals->currentPage() === 1)
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
                                
                                @if($loop->first && $jadwals->currentPage() === 1)
                                    
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

        <!-- Pagination Links -->
        @if($jadwals->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $jadwals->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
