@extends('layouts.sopir')

@section('title', 'Semua Manifes Penumpang - CV RTM Travel')
@section('page_title', 'Manifes Penumpang Global')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-md">
        <h1 class="text-lg font-black text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-users text-amber-500"></i> Manifes Penumpang
        </h1>
        <p class="text-[11px] text-slate-500 mt-0.5 font-semibold">Tinjau seluruh daftar manifest penumpang dari jadwal tugas Anda.</p>
    </div>

    <!-- Search Form -->
    <form action="{{ route('sopir.penumpang') }}" method="GET" class="relative">
        <div class="relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama penumpang..." 
                class="w-full bg-white border border-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-xs rounded-2xl py-3 pl-4 pr-10 outline-none text-slate-800 placeholder-slate-400 font-bold transition-all shadow-sm">
            <button type="submit" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-amber-500 transition-colors">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </button>
        </div>
        @if($search)
            <div class="mt-2 flex justify-between items-center px-1">
                <span class="text-[10px] text-slate-500 font-medium">Hasil untuk: <strong class="text-slate-800">"{{ $search }}"</strong></span>
                <a href="{{ route('sopir.penumpang') }}" class="text-[10px] font-bold text-amber-600 hover:underline">Hapus Filter</a>
            </div>
        @endif
    </form>

    <!-- Passenger List (Card-based Layout) -->
    <div class="space-y-3.5">
        @forelse($pemesanans as $index => $p)
            <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-md relative overflow-hidden group">
                <!-- Status Tag Badge -->
                <div class="absolute top-0 right-0">
                    @if($p->status === 'Selesai')
                        <span class="px-3 py-1 bg-emerald-500 text-white text-[9px] font-extrabold rounded-bl-2xl uppercase tracking-wider block">Selesai</span>
                    @elseif($p->status === 'Lunas')
                        <span class="px-3 py-1 bg-blue-600 text-white text-[9px] font-extrabold rounded-bl-2xl uppercase tracking-wider block">Lunas</span>
                    @elseif($p->status === 'Batal')
                        <span class="px-3 py-1 bg-red-500 text-white text-[9px] font-extrabold rounded-bl-2xl uppercase tracking-wider block">Batal</span>
                    @else
                        <span class="px-3 py-1 bg-amber-500 text-white text-[9px] font-extrabold rounded-bl-2xl uppercase tracking-wider block">Pending</span>
                    @endif
                </div>

                <div class="flex gap-3">
                    <!-- Seat Number Badge -->
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-200 flex flex-col items-center justify-center shrink-0 shadow-inner">
                        <span class="text-[8px] text-amber-600 font-extrabold uppercase leading-none">KURSI</span>
                        <span class="text-base font-black text-amber-700 leading-none mt-1">{{ $p->kursi->nomor_kursi ?? '-' }}</span>
                    </div>

                    <!-- Passenger & Route Details -->
                    <div class="space-y-1 pr-14 flex-grow">
                        <span class="text-[8px] text-slate-400 font-extrabold tracking-wider uppercase block">NAMA PENUMPANG</span>
                        <h3 class="text-sm font-black text-slate-900 leading-none">{{ $p->penumpang->nama ?? '-' }}</h3>
                        
                        <div class="text-[9px] text-slate-500 font-bold flex flex-col gap-0.5 mt-1">
                            <div class="text-slate-800">
                                <i class="fa-solid fa-route text-amber-500 mr-1"></i>{{ $p->jadwal->asal }} &rarr; {{ $p->jadwal->tujuan }}
                            </div>
                            <div>
                                <i class="fa-regular fa-calendar text-slate-400 mr-1"></i>{{ \Carbon\Carbon::parse($p->jadwal->tanggal)->translatedFormat('d M Y') }} &bull; {{ \Carbon\Carbon::parse($p->jadwal->jam)->format('H:i') }} WIB
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact & Payment Details inside the Card -->
                <div class="mt-3.5 pt-3.5 border-t border-slate-100 flex flex-col sm:flex-row justify-between gap-3 text-xs">
                    <!-- Contact WhatsApp -->
                    <div class="flex items-center gap-2">
                        <span class="text-slate-400 font-medium">WhatsApp:</span>
                        @if($p->penumpang && $p->penumpang->no_hp)
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $p->penumpang->no_hp) }}" target="_blank" class="font-bold text-slate-700 hover:text-emerald-600 flex items-center gap-1">
                                <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i> {{ $p->penumpang->no_hp }}
                            </a>
                        @else
                            <span class="font-bold text-slate-700">-</span>
                        @endif
                    </div>

                    <!-- Direct Payment State -->
                    <div class="flex items-center gap-2">
                        <span class="text-slate-400 font-medium">Bayar Langsung:</span>
                        @if($p->status === 'Selesai')
                            <span class="font-extrabold text-emerald-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> Rp {{ number_format(($p->jadwal->harga * $p->jumlah_penumpang), 0, ',', '.') }}
                            </span>
                        @elseif($p->status === 'Lunas')
                            <span class="font-extrabold text-blue-600 flex items-center gap-1">
                                <i class="fa-solid fa-credit-card"></i> Rp {{ number_format(($p->jadwal->harga * $p->jumlah_penumpang), 0, ',', '.') }}
                            </span>
                        @elseif($p->status === 'Pending')
                            <span class="font-extrabold text-amber-600 flex items-center gap-1 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-lg text-[10px]">
                                <i class="fa-solid fa-money-bill-wave text-amber-500"></i> Tagih Rp {{ number_format(($p->jadwal->harga * $p->jumlah_penumpang), 0, ',', '.') }}
                            </span>
                        @else
                            <span class="font-bold text-slate-400 line-through">Batal</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-10 bg-white border border-slate-200/80 rounded-3xl shadow-sm space-y-2">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-lg mx-auto">
                    <i class="fa-solid fa-users-slash"></i>
                </div>
                <p class="text-xs text-slate-500 font-medium italic">Tidak ada penumpang terdaftar pada rute Anda.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
