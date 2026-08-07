@extends('layouts.admin')

@section('title', 'Detail Penumpang - CV Travel RTM')
@section('page_title', 'Detail Data Penumpang')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation & Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.penumpang.index') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition inline-flex items-center gap-2">
            &larr; Kembali ke Data Penumpang
        </a>
    </div>

    <!-- Main Card Profile & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Profile Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">
            <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
                <div class="w-16 h-16 rounded-2xl bg-brand-500 text-slate-950 font-black text-2xl flex items-center justify-center shadow-md">
                    {{ strtoupper(substr($penumpang->nama, 0, 2)) }}
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[10px] font-extrabold uppercase tracking-wider">
                        #ID-{{ $penumpang->id_penumpang }}
                    </span>
                    <h2 class="text-lg font-extrabold text-slate-900 mt-1">{{ $penumpang->nama }}</h2>
                    <p class="text-xs text-slate-500 font-medium">{{ $penumpang->email }}</p>
                </div>
            </div>

            <div class="space-y-4 text-xs">
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Nomor Handphone / WA</span>
                    <span class="font-bold text-slate-800">{{ $penumpang->no_hp ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Alamat Lengkap</span>
                    <span class="font-medium text-slate-700 leading-relaxed">{{ $penumpang->alamat ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Tanggal Pendaftaran</span>
                    <span class="font-semibold text-slate-600">{{ $penumpang->created_at ? $penumpang->created_at->format('d M Y H:i') : '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Right Transaction History Table -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Riwayat Pemesanan Tiket</h3>
                    <p class="text-xs text-slate-500 font-medium">Daftar seluruh tiket travel yang telah dipesan oleh penumpang ini.</p>
                </div>
                <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-extrabold rounded-full">
                    Total: {{ $penumpang->pemesanans->count() }} Pemesanan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-[10px] font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="p-3">ID Pesanan</th>
                            <th class="p-3">Rute & Tanggal</th>
                            <th class="p-3">Kursi</th>
                            <th class="p-3">Armada / Sopir</th>
                            <th class="p-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($penumpang->pemesanans as $p)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3 font-extrabold text-slate-900">#{{ $p->id_pemesanan }}</td>
                                <td class="p-3 font-semibold text-slate-800">
                                    <div>
                                        <span class="text-brand-700 font-bold">{{ $p->jadwal->asal ?? '-' }}</span> &rarr; <span class="text-slate-800 font-bold">{{ $p->jadwal->tujuan ?? '-' }}</span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-normal">
                                        {{ $p->jadwal->tanggal ?? '-' }} &bull; Jam {{ $p->jadwal->jam ?? '-' }}
                                    </div>
                                </td>
                                <td class="p-3 font-extrabold text-slate-900">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200">
                                        {{ $p->kursi->nomor_kursi ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-3 font-medium text-slate-600">
                                    <div>{{ $p->jadwal->armada->merk ?? '-' }}</div>
                                    <div class="text-[10px] text-slate-400">Sopir: {{ $p->jadwal->sopir->nama ?? '-' }}</div>
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
                                            Batal
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400 font-medium">
                                    Penumpang ini belum melakukan pemesanan tiket.
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
