@extends('layouts.admin')

@section('title', 'Admin Dashboard - CV Travel RTM')
@section('page_title', 'Dashboard Control Center')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header Card -->
    <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 md:p-8 relative overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[11px] font-extrabold uppercase tracking-wider">
                        Control Center
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Selamat Datang, Admin RTM Travel
                </h1>
                <p class="text-xs md:text-sm text-slate-500 font-medium mt-1">
                    Kelola data armada, sopir, penumpang, jadwal perjalanan, dan seluruh transaksi pemesanan dalam satu sistem.
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid (4 Key Metrics) -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-extrabold text-slate-800 tracking-tight">
                Ringkasan Data Utama
            </h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Stat: Jadwal -->
            <a href="{{ route('admin.jadwal.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-sm transition border-l-4 border-l-brand-500 block">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">Total Jadwal</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_jadwal'] }}</div>
                <span class="text-[11px] text-brand-600 font-bold block mt-2">Lihat Selengkapnya &rarr;</span>
            </a>

            <!-- Stat: Pemesanan -->
            <a href="{{ route('admin.pemesanan.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-sm transition border-l-4 border-l-brand-500 block">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">Total Pemesanan</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_pemesanan'] }}</div>
                <span class="text-[11px] text-brand-600 font-bold block mt-2">Lihat Selengkapnya &rarr;</span>
            </a>

            <!-- Stat: Armada -->
            <a href="{{ route('admin.armada.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-sm transition border-l-4 border-l-slate-700 block">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">Total Armada</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_armada'] }}</div>
                <span class="text-[11px] text-brand-600 font-bold block mt-2">Lihat Selengkapnya &rarr;</span>
            </a>

            <!-- Stat: Sopir -->
            <a href="{{ route('admin.sopir.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-sm transition border-l-4 border-l-slate-700 block">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">Total Sopir</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_sopir'] }}</div>
                <span class="text-[11px] text-brand-600 font-bold block mt-2">Lihat Selengkapnya &rarr;</span>
            </a>
        </div>
    </div>

    <!-- Recent Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Pemesanan -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-extrabold text-slate-800">
                    Transaksi Pemesanan Terbaru
                </h2>
                <a href="{{ route('admin.pemesanan.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-[10px] font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="p-3 rounded-l-xl">ID</th>
                            <th class="p-3">Penumpang</th>
                            <th class="p-3">Rute</th>
                            <th class="p-3 rounded-r-xl text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentPemesanans as $p)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3 font-bold text-slate-900">#{{ $p->id_pemesanan }}</td>
                                <td class="p-3 font-semibold text-slate-800">
                                    {{ $p->penumpang->nama ?? 'N/A' }}
                                </td>
                                <td class="p-3 font-medium text-slate-600">
                                    <span class="font-bold text-brand-700">{{ $p->jadwal->asal ?? '-' }}</span> &rarr; <span class="font-bold text-slate-800">{{ $p->jadwal->tujuan ?? '-' }}</span>
                                </td>
                                <td class="p-3 text-center">
                                    @if($p->status == 'Lunas')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Lunas
                                        </span>
                                    @elseif($p->status == 'Pending')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            Pending
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200">
                                            {{ $p->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-slate-400 font-medium">Belum ada transaksi pemesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Jadwal -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-extrabold text-slate-800">
                    Jadwal Travel Terbaru
                </h2>
                <a href="{{ route('admin.jadwal.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-[10px] font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="p-3 rounded-l-xl">Rute</th>
                            <th class="p-3">Tanggal & Jam</th>
                            <th class="p-3">Armada / Sopir</th>
                            <th class="p-3 rounded-r-xl text-right">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentJadwals as $j)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3 font-bold text-slate-900">
                                    {{ $j->asal }} &rarr; {{ $j->tujuan }}
                                </td>
                                <td class="p-3 font-medium text-slate-600">
                                    {{ $j->tanggal }} &bull; {{ $j->jam }}
                                </td>
                                <td class="p-3 font-semibold text-slate-800">
                                    <div>{{ $j->armada->merk ?? 'N/A' }}</div>
                                    <div class="text-[10px] text-slate-400 font-normal">Sopir: {{ $j->sopir->nama ?? 'N/A' }}</div>
                                </td>
                                <td class="p-3 text-right font-extrabold text-slate-900">
                                    Rp {{ number_format($j->harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-slate-400 font-medium">Belum ada data jadwal keberangkatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
