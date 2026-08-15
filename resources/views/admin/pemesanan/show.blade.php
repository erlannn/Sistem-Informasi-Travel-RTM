@extends('layouts.admin')

@section('title', 'Detail Transaksi Pemesanan - CV Travel RTM')
@section('page_title', 'Struk & Detail Transaksi Pemesanan')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Back Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pemesanan.index') }}" class="px-4 py-2.5 text-xs sm:text-sm font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 active:scale-95 shadow-xs transition-all inline-flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Daftar Pemesanan</span>
        </a>
    </div>

    <!-- Ticket Invoice Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Header Strip (Tanpa Background pada Logo) -->
        <div class="bg-slate-950 text-white p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800">
            <div class="flex items-center gap-4">
                <!-- Logo tanpa Background Box -->
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo CV. Travel RTM" class="w-full h-auto object-contain">
                </div>
                <div>
                    <span class="text-[11px] text-amber-400 font-extrabold uppercase tracking-widest block">CV. TRAVEL RTM</span>
                    <h1 class="text-lg sm:text-xl font-extrabold text-white tracking-tight">E-TIKET & NOTA PEMESANAN</h1>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">ID Transaksi</span>
                <span class="text-lg sm:text-xl font-extrabold text-amber-400">#{{ $pemesanan->id_pemesanan }}</span>
            </div>
        </div>

        <!-- Body Details -->
        <div class="p-6 sm:p-8 md:p-10 space-y-6">
            
            <!-- Status Alert Bar -->
            <div class="flex items-center justify-between p-4 rounded-2xl border bg-slate-50 border-slate-200/80">
                <div>
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-1">Status Perjalanan</span>
                    @if(($pemesanan->status_perjalanan ?? 'Pending') == 'Selesai')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-black bg-emerald-500 text-white shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            SELESAI
                        </span>
                    @elseif(($pemesanan->status_perjalanan ?? 'Pending') == 'Batal')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-black bg-red-600 text-white shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            BATAL
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-black bg-amber-400 text-slate-950 shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-950"></span>
                            PENDING
                        </span>
                    @endif
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Tanggal Transaksi</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-800">
                        {{ $pemesanan->tanggal_pesan ? \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->translatedFormat('d M Y') : '-' }}
                    </span>
                </div>
            </div>

            <!-- Grid Details: Penumpang & Perjalanan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Data Penumpang -->
                <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3.5">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider border-b border-slate-200 pb-2.5 flex items-center gap-2">
                        <i class="fa-solid fa-user text-amber-500 text-xs"></i>
                        <span>Informasi Penumpang</span>
                    </h3>
                    <div class="space-y-2.5 text-xs md:text-sm">
                        <div>
                            <span class="text-slate-400 font-bold block text-[10px] mb-0.5">Nama Penumpang</span>
                            <span class="font-extrabold text-slate-900 text-sm md:text-base">{{ $pemesanan->penumpang->nama ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold block text-[10px] mb-0.5">Email</span>
                            <span class="font-semibold text-slate-800">{{ $pemesanan->penumpang->email ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold block text-[10px] mb-0.5">No. Telepon / WhatsApp</span>
                            <span class="font-semibold text-slate-800">{{ $pemesanan->penumpang->no_hp ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Data Perjalanan -->
                <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3.5">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider border-b border-slate-200 pb-2.5 flex items-center gap-2">
                        <i class="fa-solid fa-route text-amber-500 text-xs"></i>
                        <span>Rute & Perjalanan</span>
                    </h3>
                    <div class="space-y-2.5 text-xs md:text-sm">
                        <div>
                            <span class="text-slate-400 font-bold block text-[10px] mb-0.5">Rute Travel</span>
                            <div class="flex items-center gap-1.5 font-extrabold text-slate-900 text-sm md:text-base">
                                <span>{{ $pemesanan->jadwal->asal ?? '-' }}</span>
                                <i class="fa-solid fa-arrow-right text-xs text-amber-500"></i>
                                <span>{{ $pemesanan->jadwal->tujuan ?? '-' }}</span>
                            </div>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold block text-[10px] mb-0.5">Tanggal & Jam Keberangkatan</span>
                            <span class="font-semibold text-slate-800">{{ $pemesanan->jadwal->tanggal ?? '-' }} &bull; Jam {{ $pemesanan->jadwal->jam ?? '-' }} WIB</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold block text-[10px] mb-0.5">Nomor Kursi</span>
                            <span class="inline-block px-3 py-1 rounded-lg bg-amber-100 text-amber-950 border border-amber-200 font-bold text-xs">
                                Kursi {{ $pemesanan->kursi->nomor_kursi ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Details: Transportasi & Pengemudi -->
            <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3.5">
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider border-b border-slate-200 pb-2.5 flex items-center gap-2">
                    <i class="fa-solid fa-van-shuttle text-amber-500 text-xs"></i>
                    <span>Detail Transportasi & Pengemudi</span>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs md:text-sm">
                    <div>
                        <span class="text-slate-400 font-bold block text-[10px] mb-0.5">Armada Travel</span>
                        <span class="font-extrabold text-slate-900">{{ $pemesanan->jadwal->armada->merk ?? '-' }}</span>
                        @if(isset($pemesanan->jadwal->armada->warna))
                            <span class="text-slate-500 font-medium">({{ $pemesanan->jadwal->armada->warna }})</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold block text-[10px] mb-0.5">Sopir / Pengemudi Ditugaskan</span>
                        <span class="font-extrabold text-slate-900">{{ $pemesanan->jadwal->sopir->nama ?? '-' }}</span>
                        @if(isset($pemesanan->jadwal->sopir->no_hp))
                            <span class="text-slate-500 font-medium">(HP: {{ $pemesanan->jadwal->sopir->no_hp }})</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Total Price Summary -->
            <div class="p-6 rounded-2xl bg-slate-900 text-white flex items-center justify-between shadow-xs">
                <div>
                    <span class="text-xs font-extrabold text-amber-400 uppercase tracking-wider block">Total Tagihan Tiket</span>
                    <span class="text-xs text-slate-300 font-medium">1 Penumpang, 1 Kursi Travel Reguler</span>
                </div>
                <div class="text-right">
                    <span class="text-xl md:text-2xl font-black text-amber-400">
                        Rp {{ number_format($pemesanan->jadwal->harga ?? 0, 0, ',', '.') }}
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection