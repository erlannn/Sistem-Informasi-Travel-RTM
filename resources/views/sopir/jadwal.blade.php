@extends('layouts.sopir')

@section('title', 'Jadwal Perjalanan Saya - CV RTM Travel')
@section('page_title', 'Jadwal Perjalanan Saya')

@section('content')
<div class="space-y-5">
    <!-- Header Card -->
    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center text-base shadow-xs shrink-0 font-black">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                    Jadwal Perjalanan Saya
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Cari dan kelola jadwal perjalanan travel yang ditugaskan kepada Anda</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter Form Card -->
    <form action="{{ route('sopir.jadwal') }}" method="GET" class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs space-y-4 no-print">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
            <div>
                <label for="search" class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block mb-1.5">Cari Rute / Armada</label>
                <input type="text" name="search" id="search" value="{{ $search ?? '' }}" placeholder="Contoh: Sijunjung, Toyota..." 
                    class="w-full bg-slate-50 border border-slate-200/80 focus:bg-white focus:border-amber-400 focus:ring-2 focus:ring-amber-400/30 text-xs sm:text-sm rounded-xl py-2.5 px-3.5 outline-none text-slate-800 placeholder-slate-400 font-semibold transition-all">
            </div>
            <div>
                <label for="search_date" class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block mb-1.5">Tanggal Keberangkatan</label>
                <input type="date" name="search_date" id="search_date" value="{{ $searchDate ?? '' }}" 
                    class="w-full bg-slate-50 border border-slate-200/80 focus:bg-white focus:border-amber-400 focus:ring-2 focus:ring-amber-400/30 text-xs sm:text-sm rounded-xl py-2.5 px-3.5 outline-none text-slate-800 font-semibold transition-all cursor-pointer">
            </div>
        </div>
        <div class="flex items-center justify-end gap-2.5 pt-1 border-t border-slate-100">
            @if(!empty($search) || !empty($searchDate))
                <a href="{{ route('sopir.jadwal') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl border border-slate-300 transition-all flex items-center justify-center">
                    Reset Filter
                </a>
            @endif
            <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-950 active:scale-[0.99] text-white font-extrabold text-xs rounded-xl shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                <span>Cari Jadwal</span>
            </button>
        </div>
    </form>

    <!-- Schedule List (Card-based Layout) -->
    <div class="space-y-4">
        @forelse($jadwals as $j)
            <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs hover:border-amber-400/60 transition-all flex flex-col gap-3.5 relative overflow-hidden group">
                <!-- Rute Perjalanan Header -->
                <div class="pr-10">
                    <span class="text-[10px] text-slate-400 font-extrabold tracking-wider uppercase block mb-0.5">Rute Perjalanan</span>
                    <div class="text-sm sm:text-base font-extrabold text-slate-900 flex items-center gap-2 leading-snug">
                        <span>{{ $j->asal }}</span>
                        <i class="fa-solid fa-arrow-right text-xs text-amber-500 shrink-0"></i>
                        <span>{{ $j->tujuan }}</span>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-2 gap-3 text-xs sm:text-sm bg-slate-50/90 border border-slate-200/80 p-3.5 rounded-2xl">
                    <div class="space-y-1">
                        <span class="text-slate-400 font-bold block text-[10px] uppercase tracking-wider">Jadwal Keberangkatan</span>
                        <span class="font-extrabold text-slate-900 block">
                            <i class="fa-regular fa-calendar mr-1.5 text-amber-500"></i>{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}
                        </span>
                        <span class="font-extrabold text-slate-900 block">
                            <i class="fa-regular fa-clock mr-1.5 text-amber-500"></i>{{ \Carbon\Carbon::parse($j->jam)->format('H:i') }} WIB
                        </span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 font-bold block text-[10px] uppercase tracking-wider">Armada Mobil</span>
                        <span class="font-extrabold text-slate-900 block leading-tight">
                            <i class="fa-solid fa-van-shuttle mr-1.5 text-slate-400"></i>{{ $j->armada->merk ?? 'Mobil' }}
                        </span>
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="flex justify-between items-center pt-1 border-t border-slate-100">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs text-slate-600 font-bold">Harga Tiket: <strong class="text-amber-600 font-extrabold">Rp {{ number_format($j->harga, 0, ',', '.') }}</strong></span>
                    </div>
                    <a href="{{ route('sopir.jadwal.detail', $j->id_jadwal) }}" class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-slate-950 active:scale-[0.99] text-white font-extrabold text-xs py-2 px-4 rounded-xl shadow-xs transition-all">
                        <span>Lihat Detail</span>
                        <i class="fa-solid fa-arrow-right text-[10px] text-amber-400"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-10 bg-white border border-slate-200/80 rounded-3xl shadow-xs space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-lg mx-auto">
                    <i class="fa-solid fa-route"></i>
                </div>
                <p class="text-xs sm:text-sm text-slate-700 font-bold">Tidak ada jadwal perjalanan yang ditemukan.</p>
                <p class="text-[11px] text-slate-400 font-medium">Coba sesuaikan kata kunci pencarian atau filter tanggal Anda.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    @if($jadwals->hasPages())
        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-center">
            {{ $jadwals->links() }}
        </div>
    @endif
</div>
@endsection