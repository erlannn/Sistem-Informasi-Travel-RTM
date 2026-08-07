@extends('layouts.admin')

@section('title', 'Detail Transaksi Pemesanan - CV Travel RTM')
@section('page_title', 'Struk & Detail Transaksi Pemesanan')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Back Navigation & Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pemesanan.index') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition inline-flex items-center gap-2">
            &larr; Kembali ke Daftar Pemesanan
        </a>
    </div>

    <!-- Ticket Invoice Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden">
        <!-- Header Strip -->
        <div class="bg-slate-900 text-white p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-950 border border-slate-800 flex items-center justify-center p-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo CV. Travel RTM" class="w-full h-auto object-contain">
                </div>
                <div>
                    <span class="text-xs text-brand-500 font-extrabold uppercase tracking-wider block">CV. TRAVEL RTM</span>
                    <h1 class="text-xl font-black text-white tracking-tight">E-TIKET & NOTA PEMESANAN</h1>
                </div>
            </div>
            <div class="text-right">
                <span class="text-xs text-slate-400 font-medium block">ID Transaksi</span>
                <span class="text-lg font-black text-brand-400">#{{ $pemesanan->id_pemesanan }}</span>
            </div>
        </div>

        <!-- Body Details -->
        <div class="p-6 sm:p-8 space-y-8">
            <!-- Status Alert Bar -->
            <div class="flex items-center justify-between p-4 rounded-2xl border {{ $pemesanan->status == 'Lunas' ? 'bg-emerald-50 border-emerald-200 text-emerald-900' : ($pemesanan->status == 'Pending' ? 'bg-amber-50 border-amber-200 text-amber-900' : 'bg-red-50 border-red-200 text-red-900') }}">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider block">Status Transaksi</span>
                    <span class="text-base font-extrabold">{{ strtoupper($pemesanan->status) }}</span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider block">Tanggal Transaksi</span>
                    <span class="text-xs font-bold">{{ $pemesanan->tanggal_pesan }}</span>
                </div>
            </div>

            <!-- Grid Details: Penumpang & Perjalanan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <!-- Data Penumpang -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-3">
                    <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider border-b border-slate-200 pb-2">Informasi Penumpang</h3>
                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-slate-400 font-medium block text-[10px]">Nama Penumpang</span>
                            <span class="font-extrabold text-slate-900 text-sm">{{ $pemesanan->penumpang->nama ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block text-[10px]">Email</span>
                            <span class="font-semibold text-slate-700">{{ $pemesanan->penumpang->email ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block text-[10px]">No. Telepon / WhatsApp</span>
                            <span class="font-semibold text-slate-700">{{ $pemesanan->penumpang->no_hp ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Data Perjalanan -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-3">
                    <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider border-b border-slate-200 pb-2">Rute & Perjalanan</h3>
                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-slate-400 font-medium block text-[10px]">Rute Travel</span>
                            <span class="font-black text-slate-900 text-sm">
                                {{ $pemesanan->jadwal->asal ?? '-' }} &rarr; {{ $pemesanan->jadwal->tujuan ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block text-[10px]">Tanggal & Jam Keberangkatan</span>
                            <span class="font-semibold text-slate-700">{{ $pemesanan->jadwal->tanggal ?? '-' }} &bull; Jam {{ $pemesanan->jadwal->jam ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block text-[10px]">Nomor Kursi</span>
                            <span class="inline-block px-3 py-1 rounded-lg bg-slate-900 text-white font-extrabold text-xs mt-0.5">
                                Kursi {{ $pemesanan->kursi->nomor_kursi ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Details: Armada & Sopir -->
            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-3">
                <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider border-b border-slate-200 pb-2">Detail Transportasi & Pengemudi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium block text-[10px]">Armada Travel</span>
                        <span class="font-extrabold text-slate-800">{{ $pemesanan->jadwal->armada->merk ?? '-' }} ({{ $pemesanan->jadwal->armada->warna ?? '-' }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block text-[10px]">Sopir Tugas</span>
                        <span class="font-extrabold text-slate-800">{{ $pemesanan->jadwal->sopir->nama ?? '-' }} ({{ $pemesanan->jadwal->sopir->no_hp ?? '-' }})</span>
                    </div>
                </div>
            </div>

            <!-- Price Breakdown -->
            <div class="border-t border-slate-200 pt-4 flex justify-between items-center text-sm">
                <span class="font-bold text-slate-600">Total Biaya Tiket Travel</span>
                <span class="text-xl font-black text-brand-700">
                    Rp {{ number_format($pemesanan->jadwal->harga ?? 0, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
