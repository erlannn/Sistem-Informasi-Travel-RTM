@extends('layouts.penumpang')

@section('title', 'Status Pemesanan - RTM Family')

@section('content')
<div class="py-8 bg-slate-50 md:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">

        <!-- Header Title -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Status Pemesanan</h1>
            <p class="mt-1 text-sm text-slate-500">Lacak status perjalanan dan pembayaran tiket travel Anda dengan mudah</p>
        </div>

        <!-- Search Booking Form Card -->
        <div class="bg-white rounded-2xl shadow-card border border-slate-100 p-6 md:p-8 mb-8 transition-all">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4">Cari Pemesanan</h2>
            
            <form action="{{ route('penumpang.status') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z" /></svg>
                    </span>
                    <input type="text" name="search" placeholder="Masukkan ID atau Kode Pemesanan..." value="{{ $search ?? '' }}" class="block w-full pl-10 pr-4 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500 transition-all">
                </div>
                <button type="submit" class="px-6 py-3 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-950 border border-gold-500/20 hover:border-gold-500/40 rounded-xl shadow-md transition-colors cursor-pointer text-center shrink-0">
                    Cari Tiket
                </button>
            </form>
        </div>

        <!-- Bookings List Table Card -->
        <div class="bg-white rounded-2xl shadow-card border border-slate-100 overflow-hidden transition-all mb-8">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-[640px]">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th scope="col" class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 whitespace-nowrap">Kode</th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 whitespace-nowrap">Rute</th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 whitespace-nowrap">Tanggal & Jam</th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 whitespace-nowrap">Kursi</th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 whitespace-nowrap">Status</th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 whitespace-nowrap">Pembayaran</th>
                            <th scope="col" class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($pemesanans as $p)
                            @php
                                $tglFormat = $p->jadwal->tanggal ? \Carbon\Carbon::parse($p->jadwal->tanggal)->format('d-m-Y') : ($p->tanggal_pesan ? \Carbon\Carbon::parse($p->tanggal_pesan)->format('d-m-Y') : date('d-m-Y'));
                                $jamFormat = $p->jadwal->jam ? \Carbon\Carbon::parse($p->jadwal->jam)->format('H.i') . ' WIB' : '-';
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-5 py-4 font-bold text-slate-900 whitespace-nowrap">
                                    RTM{{ sprintf('%04d', $p->id_pemesanan) }}
                                </td>
                                <td class="px-5 py-4 text-slate-700 whitespace-nowrap font-medium">
                                    {{ $p->jadwal->asal ?? '-' }} &rarr; {{ $p->jadwal->tujuan ?? '-' }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 text-xs sm:text-sm">{{ $tglFormat }}</span>
                                        <span class="text-xs text-gold-600 font-semibold flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3 text-gold-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ $jamFormat }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-extrabold text-slate-800 bg-slate-100 border border-slate-200">
                                        Kursi {{ $p->kursi->nomor_kursi ?? '1' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($p->status_perjalanan === 'Selesai')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 select-none">
                                            <span class="w-1.5 h-1.5 rounded-full bg-status-success"></span>
                                            Selesai
                                        </span>
                                    @elseif($p->status_perjalanan === 'Naik')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-blue-800 bg-blue-50 border border-blue-200 select-none">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                            Naik Armada
                                        </span>
                                    @elseif($p->status_perjalanan === 'Pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-gold-700 bg-gold-50 border border-gold-200/40 select-none">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gold-500"></span>
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-red-800 bg-red-50 border border-red-200 select-none">
                                            <span class="w-1.5 h-1.5 rounded-full bg-status-danger"></span>
                                            Batal
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($p->status_pembayaran === 'Lunas')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200">
                                            Lunas (Cash)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold text-amber-700 bg-amber-50 border border-amber-200">
                                            Belum Bayar (Cash)
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    <a href="{{ route('penumpang.status.detail', $p->id_pemesanan) }}" class="px-3.5 py-1.5 text-xs font-bold text-white bg-slate-900 hover:bg-slate-950 border border-gold-500/30 rounded-xl transition-all inline-flex items-center gap-1 shadow-sm">
                                        <svg class="w-3.5 h-3.5 text-gold-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-500 font-semibold">
                                    Belum ada data pemesanan tiket.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Legend section -->
        <div class="bg-white rounded-2xl border border-slate-150 p-6">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Keterangan Status</h3>
            <div class="flex flex-wrap gap-x-6 gap-y-3 text-xs font-semibold text-slate-600">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-gold-400"></span>
                    <span>Pending: Menunggu Penjemputan</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span>Naik: Penumpang Naik Mobil</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-status-success"></span>
                    <span>Selesai: Tiba & Pembayaran Cash Lunas</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-status-danger"></span>
                    <span>Batal: Pesanan Dibatalkan</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
