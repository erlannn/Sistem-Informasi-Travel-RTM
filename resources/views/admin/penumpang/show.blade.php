@extends('layouts.admin')

@section('title', 'Detail Penumpang - CV Travel RTM')
@section('page_title', 'Detail Data Penumpang')

@section('content')
<div class="space-y-8">

    <!-- Top Navigation & Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.penumpang.index') }}" class="px-5 py-3 text-xs sm:text-sm font-black text-black bg-white border border-slate-200 rounded-xl hover:bg-slate-50 active:scale-95 shadow-sm transition inline-flex items-center gap-2 cursor-pointer">
            &larr; Kembali ke Data Penumpang
        </a>
    </div>

    <!-- Main Card Profile & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        
        <!-- Left Profile Card -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
                <div class="w-16 h-16 rounded-2xl bg-slate-950 text-amber-400 font-black text-2xl flex items-center justify-center shadow-md">
                    {{ strtoupper(substr($penumpang->nama, 0, 2)) }}
                </div>
                <div>
                    <span class="px-3 py-0.5 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                        #ID-{{ $penumpang->id_penumpang }}
                    </span>
                    <h2 class="text-xl font-black text-black mt-2 leading-tight">{{ $penumpang->nama }}</h2>
                    <p class="text-xs sm:text-sm text-black font-medium mt-0.5">{{ $penumpang->email }}</p>
                </div>
            </div>

            <div class="space-y-4 text-sm">
                <div>
                    <span class="text-black font-black uppercase tracking-wider block text-xs mb-1.5">Nomor Handphone / WA</span>
                    <span class="font-bold text-black">{{ $penumpang->no_hp ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-black font-black uppercase tracking-wider block text-xs mb-1.5">Alamat Lengkap</span>
                    <span class="font-medium text-black leading-relaxed">{{ $penumpang->alamat ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-black font-black uppercase tracking-wider block text-xs mb-1.5">Tanggal Pendaftaran</span>
                    <span class="font-semibold text-black">{{ $penumpang->created_at ? $penumpang->created_at->format('d M Y H:i') : '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Right Transaction History Table -->
        <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                <div>
                    <h3 class="text-lg font-black text-black">Riwayat Pemesanan Tiket</h3>
                    <p class="text-xs sm:text-sm text-black font-medium mt-0.5">Daftar seluruh tiket travel yang telah dipesan oleh penumpang ini.</p>
                </div>
                <span class="px-3.5 py-1.5 bg-slate-100 border border-slate-200 text-black text-xs font-black rounded-full">
                    Total: {{ $penumpang->pemesanans->count() }} Pemesanan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-black">
                    <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4 rounded-l-xl">ID Pesanan</th>
                            <th class="py-3.5 px-4">Rute & Tanggal</th>
                            <th class="py-3.5 px-4">Kursi</th>
                            <th class="py-3.5 px-4">Armada / Sopir</th>
                            <th class="py-3.5 px-4 rounded-r-xl text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($penumpang->pemesanans as $p)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-4 font-black text-black">#{{ $p->id_pemesanan }}</td>
                                <td class="py-4 px-4 font-bold text-black">
                                    <div>
                                        <span class="text-black font-black">{{ $p->jadwal->asal ?? '-' }}</span> &rarr; <span class="text-black font-black">{{ $p->jadwal->tujuan ?? '-' }}</span>
                                    </div>
                                    <div class="text-xs text-black font-medium mt-0.5">
                                        {{ $p->jadwal->tanggal ?? '-' }} &bull; Jam {{ $p->jadwal->jam ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-black text-black">
                                    <span class="px-2.5 py-1 rounded-md bg-slate-100 border border-slate-300 text-xs font-black">
                                        {{ $p->kursi->nomor_kursi ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-semibold text-black">
                                    <div>{{ $p->jadwal->armada->merk ?? '-' }}</div>
                                    <div class="text-xs text-black font-medium">Sopir: {{ $p->jadwal->sopir->nama ?? '-' }}</div>
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
                                <td colspan="5" class="py-10 text-center text-black font-semibold text-sm">
                                    Penumpang ini belum pernah melakukan transaksi pemesanan tiket.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
