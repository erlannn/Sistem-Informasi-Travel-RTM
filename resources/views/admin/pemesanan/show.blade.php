@extends('layouts.admin')

@section('title', 'Detail Transaksi Pemesanan - CV Travel RTM')
@section('page_title', 'Struk & Detail Transaksi Pemesanan')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">

    <!-- Back Navigation & Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pemesanan.index') }}" class="px-5 py-3 text-xs sm:text-sm font-black text-black bg-white border border-slate-200 rounded-xl hover:bg-slate-50 active:scale-95 shadow-sm transition inline-flex items-center gap-2 cursor-pointer">
            &larr; Kembali ke Daftar Pemesanan
        </a>
    </div>

    <!-- Ticket Invoice Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-md overflow-hidden">
        <!-- Header Strip -->
        <div class="bg-slate-950 text-white p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-400 border border-amber-300 flex items-center justify-center p-2 shadow-inner">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo CV. Travel RTM" class="w-full h-auto object-contain">
                </div>
                <div>
                    <span class="text-xs text-amber-400 font-black uppercase tracking-wider block">CV. TRAVEL RTM</span>
                    <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">E-TIKET & NOTA PEMESANAN</h1>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">ID Transaksi</span>
                <span class="text-xl font-black text-amber-400">#{{ $pemesanan->id_pemesanan }}</span>
            </div>
        </div>

        <!-- Body Details -->
        <div class="p-6 sm:p-8 md:p-10 space-y-8">
            <!-- Status Alert Bar -->
<<<<<<< HEAD
            <div class="flex items-center justify-between p-4 rounded-2xl border {{ $pemesanan->status_perjalanan == 'Selesai' ? 'bg-emerald-50 border-emerald-200 text-emerald-900' : ($pemesanan->status_perjalanan == 'Batal' ? 'bg-red-50 border-red-200 text-red-900' : 'bg-amber-50 border-amber-200 text-amber-900') }}">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider block">Status Perjalanan</span>
                    <span class="text-base font-extrabold">
                        {{ strtoupper($pemesanan->status_perjalanan ?? 'Pending') }}
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider block">Tanggal Transaksi</span>
                    <span class="text-xs font-bold">{{ $pemesanan->tanggal_pesan ? \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->translatedFormat('d M Y') : '-' }}</span>
=======
            <div class="flex items-center justify-between p-5 rounded-2xl border {{ $pemesanan->status == 'Lunas' ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : ($pemesanan->status == 'Pending' ? 'bg-amber-50 border-amber-300 text-amber-950' : 'bg-rose-50 border-rose-300 text-rose-950') }}">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider block text-black">Status Transaksi</span>
                    <span class="text-lg font-black">{{ strtoupper($pemesanan->status) }}</span>
                </div>
                <div class="text-right">
                    <span class="text-xs font-black uppercase tracking-wider block text-black">Tanggal Transaksi</span>
                    <span class="text-sm font-bold text-black">{{ $pemesanan->tanggal_pesan }}</span>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                </div>
            </div>

            <!-- Grid Details: Penumpang & Perjalanan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <!-- Data Penumpang -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4">
                    <h3 class="text-xs font-black text-black uppercase tracking-wider border-b border-slate-200 pb-3">Informasi Penumpang</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-black font-bold block text-xs mb-0.5">Nama Penumpang</span>
                            <span class="font-black text-black text-base">{{ $pemesanan->penumpang->nama ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-black font-bold block text-xs mb-0.5">Email</span>
                            <span class="font-semibold text-black">{{ $pemesanan->penumpang->email ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-black font-bold block text-xs mb-0.5">No. Telepon / WhatsApp</span>
                            <span class="font-semibold text-black">{{ $pemesanan->penumpang->no_hp ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Data Perjalanan -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4">
                    <h3 class="text-xs font-black text-black uppercase tracking-wider border-b border-slate-200 pb-3">Rute & Perjalanan</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-black font-bold block text-xs mb-0.5">Rute Travel</span>
                            <span class="font-black text-black text-base">
                                {{ $pemesanan->jadwal->asal ?? '-' }} &rarr; {{ $pemesanan->jadwal->tujuan ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-black font-bold block text-xs mb-0.5">Tanggal & Jam Keberangkatan</span>
                            <span class="font-semibold text-black">{{ $pemesanan->jadwal->tanggal ?? '-' }} &bull; Jam {{ $pemesanan->jadwal->jam ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-black font-bold block text-xs mb-0.5">Nomor Kursi</span>
                            <span class="inline-block px-3.5 py-1.5 rounded-lg bg-slate-950 text-amber-400 font-black text-xs mt-0.5">
                                Kursi {{ $pemesanan->kursi->nomor_kursi ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Details: Armada & Sopir -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4">
                <h3 class="text-xs font-black text-black uppercase tracking-wider border-b border-slate-200 pb-3">Detail Transportasi & Pengemudi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-black font-bold block text-xs mb-0.5">Armada Travel</span>
                        <span class="font-black text-black">{{ $pemesanan->jadwal->armada->merk ?? '-' }} ({{ $pemesanan->jadwal->armada->warna ?? '-' }})</span>
                    </div>
                    <div>
                        <span class="text-black font-bold block text-xs mb-0.5">Sopir / Driver Ditugaskan</span>
                        <span class="font-black text-black">{{ $pemesanan->jadwal->sopir->nama ?? '-' }} (HP: {{ $pemesanan->jadwal->sopir->no_hp ?? '-' }})</span>
                    </div>
                </div>
            </div>

            <!-- Total Price Summary -->
            <div class="p-6 rounded-2xl bg-amber-50 border border-amber-300 flex items-center justify-between">
                <div>
                    <span class="text-xs font-black text-amber-900 uppercase tracking-wider block">Total Tagihan Tiket</span>
                    <span class="text-xs text-black font-semibold">1 Penumpang, 1 Kursi Travel Reguler</span>
                </div>
                <div class="text-right">
                    <span class="text-2xl font-black text-slate-950">
                        Rp {{ number_format($pemesanan->jadwal->harga ?? 0, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
