@extends('layouts.admin')

@section('title', 'Admin Dashboard - CV Travel RTM')
@section('page_title', 'Dashboard Control Center')

@section('content')
<div class="space-y-8 sm:space-y-10">
    <!-- Welcome Header Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-7 sm:p-8 md:p-10 relative overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                        Control Center
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-black tracking-tight">
                    Selamat Datang, Admin CV. Travel RTM
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-black font-medium mt-2 leading-relaxed max-w-3xl">
                    Kelola data armada, sopir, penumpang, jadwal perjalanan, dan seluruh transaksi pemesanan dalam satu sistem terpadu.
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid (4 Key Metrics) -->
    <div>
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg sm:text-xl font-black text-black tracking-tight">
                Ringkasan Data Utama
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            <!-- Stat: Jadwal -->
            <a href="{{ route('admin.jadwal.index') }}" class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:border-amber-400/80 transition-all border-l-4 border-l-amber-500 block group">
                <span class="text-xs font-black uppercase tracking-wider text-black block mb-2">Total Jadwal</span>
                <div class="text-3xl sm:text-4xl font-black text-black tracking-tight">{{ $stats['total_jadwal'] }}</div>
                <span class="text-xs sm:text-sm text-amber-600 font-extrabold block mt-3 group-hover:translate-x-1 transition-transform">Lihat Jadwal &rarr;</span>
            </a>

            <!-- Stat: Pemesanan -->
            <a href="{{ route('admin.pemesanan.index') }}" class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:border-amber-400/80 transition-all border-l-4 border-l-amber-500 block group">
                <span class="text-xs font-black uppercase tracking-wider text-black block mb-2">Total Pemesanan</span>
                <div class="text-3xl sm:text-4xl font-black text-black tracking-tight">{{ $stats['total_pemesanan'] }}</div>
                <span class="text-xs sm:text-sm text-amber-600 font-extrabold block mt-3 group-hover:translate-x-1 transition-transform">Lihat Pemesanan &rarr;</span>
            </a>

            <!-- Stat: Armada -->
            <a href="{{ route('admin.armada.index') }}" class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:border-amber-400/80 transition-all border-l-4 border-l-slate-950 block group">
                <span class="text-xs font-black uppercase tracking-wider text-black block mb-2">Total Armada</span>
                <div class="text-3xl sm:text-4xl font-black text-black tracking-tight">{{ $stats['total_armada'] }}</div>
                <span class="text-xs sm:text-sm text-amber-600 font-extrabold block mt-3 group-hover:translate-x-1 transition-transform">Kelola Armada &rarr;</span>
            </a>

            <!-- Stat: Sopir -->
            <a href="{{ route('admin.sopir.index') }}" class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:border-amber-400/80 transition-all border-l-4 border-l-slate-950 block group">
                <span class="text-xs font-black uppercase tracking-wider text-black block mb-2">Total Sopir</span>
                <div class="text-3xl sm:text-4xl font-black text-black tracking-tight">{{ $stats['total_sopir'] }}</div>
                <span class="text-xs sm:text-sm text-amber-600 font-extrabold block mt-3 group-hover:translate-x-1 transition-transform">Kelola Sopir &rarr;</span>
            </a>
        </div>
    </div>

    <!-- Recent Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        <!-- Recent Pemesanan -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-black text-black">
                    Transaksi Pemesanan Terbaru
                </h2>
                <a href="{{ route('admin.pemesanan.index') }}" class="text-xs sm:text-sm font-black text-amber-600 hover:text-amber-700">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-black">
                    <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4 rounded-l-xl">ID</th>
                            <th class="py-3.5 px-4">Penumpang</th>
                            <th class="py-3.5 px-4">Rute</th>
                            <th class="py-3.5 px-4 rounded-r-xl text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentPemesanans as $p)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-4 font-black text-black">#{{ $p->id_pemesanan }}</td>
                                <td class="py-4 px-4 font-bold text-black">
                                    {{ $p->penumpang->nama ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-4 font-medium text-black">
                                    <span class="font-black text-black">{{ $p->jadwal->asal ?? '-' }}</span> &rarr; <span class="font-black text-black">{{ $p->jadwal->tujuan ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($p->status == 'Lunas')
                                        <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-900 border border-emerald-300">
                                            Lunas
                                        </span>
                                    @elseif($p->status == 'Pending')
                                        <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-900 border border-amber-300">
                                            Pending
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-900 border border-rose-300">
                                            {{ $p->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-black font-semibold">Belum ada transaksi pemesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Jadwal -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-black text-black">
                    Jadwal Travel Terbaru
                </h2>
                <a href="{{ route('admin.jadwal.index') }}" class="text-xs sm:text-sm font-black text-amber-600 hover:text-amber-700">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-black">
                    <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4 rounded-l-xl">Rute</th>
                            <th class="py-3.5 px-4">Tanggal & Jam</th>
                            <th class="py-3.5 px-4">Armada / Sopir</th>
                            <th class="py-3.5 px-4 rounded-r-xl text-right">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentJadwals as $j)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-4 font-black text-black">
                                    {{ $j->asal }} &rarr; {{ $j->tujuan }}
                                </td>
                                <td class="py-4 px-4 font-medium text-black">
                                    {{ $j->tanggal }} &bull; {{ $j->jam }}
                                </td>
                                <td class="py-4 px-4 font-bold text-black">
                                    <div>{{ $j->armada->merk ?? 'N/A' }}</div>
                                    <div class="text-xs text-black font-medium">Sopir: {{ $j->sopir->nama ?? 'N/A' }}</div>
                                </td>
                                <td class="py-4 px-4 text-right font-black text-amber-700">
                                    Rp {{ number_format($j->harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-black font-semibold">Belum ada data jadwal keberangkatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
