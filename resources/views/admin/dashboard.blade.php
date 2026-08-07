@extends('layouts.admin')

@section('title', 'Admin Dashboard - CV RTM Travel')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 glass-card p-6 rounded-3xl">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 flex items-center gap-3">
                <i class="fa-solid fa-shield-halved text-purple-600"></i>
                Dashboard Control Center Admin
            </h1>
            <p class="text-xs text-slate-600 font-semibold mt-1">Akses penuh pengelolaan seluruh tabel data sistem informasi travel</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3.5 py-2 rounded-xl bg-purple-100 text-purple-800 border border-purple-300 text-xs font-bold flex items-center gap-2 shadow-sm">
                <span class="w-2.5 h-2.5 rounded-full bg-purple-600 animate-pulse"></span>
                Role: Admin (Full Access)
            </span>
        </div>
    </div>

    <!-- Stats Grid (7 Tables Overview) -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
        <div class="glass-card p-4 rounded-2xl border-l-4 border-l-purple-600">
            <span class="text-xs font-bold text-slate-700 uppercase">Admins</span>
            <div class="text-2xl font-extrabold text-purple-700 mt-1">{{ $stats['total_admin'] }}</div>
        </div>

        <div class="glass-card p-4 rounded-2xl border-l-4 border-l-sky-600">
            <span class="text-xs font-bold text-slate-700 uppercase">Penumpangs</span>
            <div class="text-2xl font-extrabold text-sky-700 mt-1">{{ $stats['total_penumpang'] }}</div>
        </div>

        <div class="glass-card p-4 rounded-2xl border-l-4 border-l-amber-600">
            <span class="text-xs font-bold text-slate-700 uppercase">Sopirs</span>
            <div class="text-2xl font-extrabold text-amber-700 mt-1">{{ $stats['total_sopir'] }}</div>
        </div>

        <div class="glass-card p-4 rounded-2xl border-l-4 border-l-emerald-600">
            <span class="text-xs font-bold text-slate-700 uppercase">Armadas</span>
            <div class="text-2xl font-extrabold text-emerald-700 mt-1">{{ $stats['total_armada'] }}</div>
        </div>

        <div class="glass-card p-4 rounded-2xl border-l-4 border-l-indigo-600">
            <span class="text-xs font-bold text-slate-700 uppercase">Jadwals</span>
            <div class="text-2xl font-extrabold text-indigo-700 mt-1">{{ $stats['total_jadwal'] }}</div>
        </div>

        <div class="glass-card p-4 rounded-2xl border-l-4 border-l-pink-600">
            <span class="text-xs font-bold text-slate-700 uppercase">Kursis</span>
            <div class="text-2xl font-extrabold text-pink-700 mt-1">{{ $stats['total_kursi'] }}</div>
        </div>

        <div class="glass-card p-4 rounded-2xl border-l-4 border-l-cyan-600">
            <span class="text-xs font-bold text-slate-700 uppercase">Pemesanans</span>
            <div class="text-2xl font-extrabold text-cyan-700 mt-1">{{ $stats['total_pemesanan'] }}</div>
        </div>
    </div>

    <!-- Recent Tables Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Pemesanan -->
        <div class="glass-card p-6 rounded-3xl">
            <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center justify-between">
                <span><i class="fa-solid fa-ticket text-sky-600 mr-2"></i> Transaksi Pemesanan Terbaru</span>
                <span class="text-xs text-slate-600 font-semibold">Tabel: pemesanans</span>
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-100 text-slate-700 uppercase text-[11px] font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="p-3">ID</th>
                            <th class="p-3">Penumpang</th>
                            <th class="p-3">Rute</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($recentPemesanans as $p)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3 font-bold text-slate-900">#{{ $p->id_pemesanan }}</td>
                                <td class="p-3 font-semibold text-slate-800">{{ $p->penumpang->nama ?? 'N/A' }}</td>
                                <td class="p-3 font-semibold text-sky-700">{{ $p->jadwal->asal ?? '-' }} &rarr; {{ $p->jadwal->tujuan ?? '-' }}</td>
                                <td class="p-3">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        {{ $p->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-4 text-center text-slate-600 font-semibold">Belum ada data pemesanan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Jadwal -->
        <div class="glass-card p-6 rounded-3xl">
            <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center justify-between">
                <span><i class="fa-regular fa-calendar-days text-indigo-600 mr-2"></i> Jadwal Perjalanan Terbaru</span>
                <span class="text-xs text-slate-600 font-semibold">Tabel: jadwals</span>
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-100 text-slate-700 uppercase text-[11px] font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="p-3">ID</th>
                            <th class="p-3">Rute</th>
                            <th class="p-3">Armada & Sopir</th>
                            <th class="p-3">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($recentJadwals as $j)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3 font-bold text-slate-900">#{{ $j->id_jadwal }}</td>
                                <td class="p-3 font-bold text-sky-700">{{ $j->asal }} &rarr; {{ $j->tujuan }}</td>
                                <td class="p-3 font-semibold text-slate-800">{{ $j->armada->merk ?? 'N/A' }} (Sopir: {{ $j->sopir->nama ?? 'N/A' }})</td>
                                <td class="p-3 font-extrabold text-emerald-700">Rp {{ number_format($j->harga, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-4 text-center text-slate-600 font-semibold">Belum ada data jadwal</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
