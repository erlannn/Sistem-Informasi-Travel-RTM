@extends('layout.app')

@section('title', 'Status Pemesanan - RTM Family')

@section('content')
<div class="py-8 bg-slate-50 md:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">

        <!-- Header Title -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Status Pemesanan</h1>
            <p class="mt-1 text-sm text-slate-500">Lacak status konfirmasi pesanan tiket travel Anda dengan mudah</p>
        </div>

        <!-- Search Booking Form Card -->
        <div class="bg-white rounded-2xl shadow-card border border-slate-100 p-6 md:p-8 mb-8 transition-all">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4">Cari Pemesanan</h2>
            
            <form action="#" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z" /></svg>
                    </span>
                    <input type="text" name="search_kode" placeholder="Masukkan Kode Pemesanan (contoh: RTM0001)..." value="RTM0001" class="block w-full pl-10 pr-4 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500 transition-all">
                </div>
                <button type="submit" class="px-6 py-3 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-950 border border-gold-500/20 hover:border-gold-500/40 rounded-xl shadow-md transition-colors cursor-pointer text-center shrink-0">
                    Cari Tiket
                </button>
            </form>
        </div>

        <!-- Bookings List Table Card -->
        <div class="bg-white rounded-2xl shadow-card border border-slate-100 overflow-hidden transition-all mb-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Kode</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Rute</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Tanggal</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                            <th scope="col" class="px-6 py-4 class-left text-xs font-bold uppercase tracking-wider text-slate-500 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100 text-sm">
                        <!-- Booking Row matching mockup data -->
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5 font-bold text-slate-900 whitespace-nowrap">RTM0001</td>
                            <td class="px-6 py-5 text-slate-600 whitespace-nowrap">Sijunjung &rarr; Padang</td>
                            <td class="px-6 py-5 text-slate-500 whitespace-nowrap">20 Juli 2026</td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-gold-700 bg-gold-50 border border-gold-200/40 select-none shadow-[0_1px_4px_rgba(245,158,11,0.06)]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gold-500 animate-pulse"></span>
                                    Menunggu Konfirmasi
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <a href="/booking/status-detail?kode=RTM0001" class="px-3.5 py-1.5 text-xs font-bold text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Legend section (UX Correction: Sleek legend badge layout) -->
        <div class="bg-white rounded-2xl border border-slate-150 p-6">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Keterangan Status</h3>
            <div class="flex flex-wrap gap-x-6 gap-y-3 text-xs font-semibold text-slate-600">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-gold-400"></span>
                    <span>Menunggu Konfirmasi</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-status-success"></span>
                    <span>Dikonfirmasi (Lunas/Valid)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-status-danger"></span>
                    <span>Dibatalkan</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
