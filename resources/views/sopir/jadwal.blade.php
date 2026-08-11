@extends('layouts.sopir')

@section('title', 'Jadwal Perjalanan Saya - CV RTM Travel')
@section('page_title', 'Jadwal Perjalanan Saya')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-md">
        <h1 class="text-lg font-black text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-calendar-days text-amber-500"></i> Jadwal Perjalanan
        </h1>
        <p class="text-[11px] text-slate-500 mt-0.5 font-semibold">Cari dan kelola jadwal perjalanan travel yang ditugaskan kepada Anda.</p>
    </div>

    <!-- Search Form -->
    <form action="{{ route('sopir.jadwal') }}" method="GET" class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-md space-y-3 no-print">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="relative">
                <label for="search" class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider block mb-1.5">Cari Rute / Armada</label>
                <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Contoh: Sijunjung, Toyota..." 
                    class="w-full bg-slate-50 border border-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-xs rounded-xl py-2.5 px-3 outline-none text-slate-800 placeholder-slate-400 font-bold transition-all">
            </div>
            <div class="relative">
                <label for="search_date" class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider block mb-1.5">Tanggal Keberangkatan</label>
                <input type="date" name="search_date" id="search_date" value="{{ $searchDate ?? '' }}" 
                    class="w-full bg-slate-50 border border-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-xs rounded-xl py-2.5 px-3 outline-none text-slate-800 font-bold transition-all">
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-1">
            @if($search || $searchDate)
                <a href="{{ route('sopir.jadwal') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-colors flex items-center justify-center">
                    Reset Filter
                </a>
            @endif
            <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-950 text-white font-extrabold text-xs rounded-xl shadow-sm transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-magnifying-glass"></i> Cari Jadwal
            </button>
        </div>
    </form>

    <!-- Schedule List (Card-based Layout) -->
    <div class="space-y-3.5">
        @forelse($jadwals as $index => $j)
            <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-md hover:border-amber-500/40 transition-all flex flex-col gap-3 relative overflow-hidden group">
                <!-- Index Badge -->
                <div class="absolute top-0 right-0 px-3 py-1 bg-slate-100 group-hover:bg-amber-500 group-hover:text-white rounded-bl-2xl text-[9px] font-bold text-slate-500 transition-colors">
                    #{{ $index + 1 }}
                </div>

                <!-- Rute & Tanggal -->
                <div class="pr-8">
                    <span class="text-[9px] text-slate-400 font-extrabold tracking-wider uppercase block">RUTE PERJALANAN</span>
                    <div class="text-sm font-black text-slate-900 mt-0.5 flex items-center gap-1.5 leading-snug">
                        <span>{{ $j->asal }}</span>
                        <i class="fa-solid fa-circle-arrow-right text-amber-500 text-xs shrink-0"></i>
                        <span>{{ $j->tujuan }}</span>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-2 gap-2 text-[11px] bg-slate-50 border border-slate-100 p-2.5 rounded-2xl">
                    <div class="space-y-1">
                        <span class="text-slate-400 font-medium block leading-none">Jadwal Keberangkatan</span>
                        <span class="font-bold text-slate-800 block">
                            <i class="fa-regular fa-calendar mr-1 text-slate-500"></i>{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}
                        </span>
                        <span class="font-bold text-slate-800 block">
                            <i class="fa-regular fa-clock mr-1 text-slate-500"></i>{{ \Carbon\Carbon::parse($j->jam)->format('H:i') }} WIB
                        </span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 font-medium block leading-none">Armada Mobil</span>
                        <span class="font-bold text-slate-800 block leading-tight">
                            <i class="fa-solid fa-car mr-1 text-slate-500"></i>{{ $j->armada->merk ?? 'Mobil' }}
                        </span>
                        <span class="font-bold text-slate-800 block">
                            <i class="fa-solid fa-id-card-clip mr-1 text-slate-500"></i>{{ $j->armada->plat_nomor ?? '-' }}
                        </span>
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="flex justify-between items-center pt-1 mt-0.5">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[10px] text-slate-500 font-bold">Harga Tiket: Rp {{ number_format($j->harga, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('sopir.jadwal.detail', $j->id_jadwal) }}" class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-slate-950 text-white font-extrabold text-[11px] py-1.5 px-4 rounded-xl shadow-sm transition-colors">
                        Lihat Detail <i class="fa-solid fa-circle-arrow-right"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-10 bg-white border border-slate-200/80 rounded-3xl shadow-sm space-y-2">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-lg mx-auto">
                    <i class="fa-solid fa-route"></i>
                </div>
                <p class="text-xs text-slate-500 font-medium italic">Tidak ada jadwal perjalanan yang ditemukan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
