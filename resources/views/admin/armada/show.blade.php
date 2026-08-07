@extends('layouts.admin')

@section('title', 'Detail Armada - CV Travel RTM')
@section('page_title', 'Detail Data Armada')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation & Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.armada.index') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition inline-flex items-center gap-2">
            &larr; Kembali ke Data Armada
        </a>
    </div>

    <!-- Main Card Profile & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Profile Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">
            <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
                <div class="w-16 h-16 rounded-2xl bg-slate-900 text-brand-500 font-black text-2xl flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-van-shuttle text-2xl"></i>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[10px] font-extrabold uppercase tracking-wider">
                        #ARMADA-{{ $armada->id_armada }}
                    </span>
                    <h2 class="text-lg font-extrabold text-slate-900 mt-1">{{ $armada->merk }}</h2>
                    <p class="text-xs text-slate-500 font-medium">Warna: {{ $armada->warna }}</p>
                </div>
            </div>

            <div class="space-y-4 text-xs">
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Status Operasional</span>
                    @if($armada->status == 'Aktif')
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-block">
                            Aktif
                        </span>
                    @elseif($armada->status == 'Perbaikan')
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 inline-block">
                            Perbaikan / Servis
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200 inline-block">
                            Nonaktif
                        </span>
                    @endif
                </div>
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Total Jadwal Ditugaskan</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $armada->jadwals_count }} Perjalanan</span>
                </div>
            </div>
        </div>

        <!-- Right Linked Schedules Table -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Daftar Perjalanan Armada Ini</h3>
                    <p class="text-xs text-slate-500 font-medium">Jadwal travel yang menggunakan kendaraan ini.</p>
                </div>
                <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-extrabold rounded-full">
                    Total: {{ $armada->jadwals->count() }} Jadwal
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-[10px] font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="p-3">ID Jadwal</th>
                            <th class="p-3">Rute (Asal &rarr; Tujuan)</th>
                            <th class="p-3">Tanggal & Waktu</th>
                            <th class="p-3">Sopir</th>
                            <th class="p-3 text-right">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($armada->jadwals as $j)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3 font-extrabold text-slate-900">#{{ $j->id_jadwal }}</td>
                                <td class="p-3 font-bold text-slate-900">
                                    <span class="text-brand-700">{{ $j->asal }}</span> &rarr; {{ $j->tujuan }}
                                </td>
                                <td class="p-3 font-medium text-slate-600">
                                    {{ $j->tanggal }} &bull; Jam {{ $j->jam }}
                                </td>
                                <td class="p-3 font-semibold text-slate-800">
                                    {{ $j->sopir->nama ?? 'N/A' }}
                                </td>
                                <td class="p-3 text-right font-extrabold text-slate-900">
                                    Rp {{ number_format($j->harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400 font-medium">
                                    Armada ini belum ditugaskan untuk jadwal perjalanan apapun.
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
