@extends('layouts.admin')

@section('title', 'Detail Armada - CV Travel RTM')
@section('page_title', 'Detail Data Armada')

@section('content')
<div class="space-y-8">

    <!-- Top Navigation & Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.armada.index') }}" class="px-5 py-3 text-xs sm:text-sm font-black text-black bg-white border border-slate-200 rounded-xl hover:bg-slate-50 active:scale-95 shadow-sm transition inline-flex items-center gap-2 cursor-pointer">
            &larr; Kembali ke Data Armada
        </a>
    </div>

    <!-- Main Card Profile & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        
        <!-- Left Profile Card -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
                <div class="w-16 h-16 rounded-2xl bg-slate-950 text-amber-400 font-black text-2xl flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-car text-2xl"></i>
                </div>
                <div>
                    <span class="px-3 py-0.5 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                        #ARMADA-{{ $armada->id_armada }}
                    </span>
                    <h2 class="text-xl font-black text-black mt-2 leading-tight">{{ $armada->merk }}</h2>
                    <p class="text-xs sm:text-sm text-black font-semibold mt-0.5">Warna: {{ $armada->warna }}</p>
                </div>
            </div>

            <div class="space-y-4 text-sm">
                <div>
                    <span class="text-black font-black uppercase tracking-wider block text-xs mb-1.5">Status Operasional</span>
                    @if($armada->status == 'Aktif')
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-900 border border-emerald-300 inline-block">
                            Aktif
                        </span>
                    @elseif($armada->status == 'Perbaikan')
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-900 border border-amber-300 inline-block">
                            Perbaikan / Servis
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-900 border border-rose-300 inline-block">
                            Nonaktif
                        </span>
                    @endif
                </div>
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Kapasitas Kursi</span>
                    <span class="font-extrabold text-brand-700 text-sm">{{ $armada->kursi ?? 5 }} Kursi Penumpang</span>
                </div>
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Total Jadwal Ditugaskan</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $armada->jadwals_count }} Perjalanan</span>
                </div>
            </div>
        </div>

        <!-- Right Linked Schedules Table -->
        <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                <div>
                    <h3 class="text-lg font-black text-black">Daftar Perjalanan Armada Ini</h3>
                    <p class="text-xs sm:text-sm text-black font-medium mt-0.5">Jadwal travel yang menggunakan kendaraan ini.</p>
                </div>
                <span class="px-3.5 py-1.5 bg-slate-100 border border-slate-200 text-black text-xs font-black rounded-full">
                    Total: {{ $armada->jadwals->count() }} Jadwal
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-black">
                    <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4 rounded-l-xl">ID Jadwal</th>
                            <th class="py-3.5 px-4">Rute (Asal &rarr; Tujuan)</th>
                            <th class="py-3.5 px-4">Tanggal & Waktu</th>
                            <th class="py-3.5 px-4">Sopir</th>
                            <th class="py-3.5 px-4 rounded-r-xl text-right">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($armada->jadwals as $j)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-4 font-black text-black">#{{ $j->id_jadwal }}</td>
                                <td class="py-4 px-4 font-black text-black">
                                    <span>{{ $j->asal }}</span> &rarr; {{ $j->tujuan }}
                                </td>
                                <td class="py-4 px-4 font-medium text-black">
                                    {{ $j->tanggal }} &bull; Jam {{ $j->jam }}
                                </td>
                                <td class="py-4 px-4 font-bold text-black">
                                    {{ $j->sopir->nama ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-4 text-right font-black text-amber-700">
                                    Rp {{ number_format($j->harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-black font-semibold text-sm">
                                    Belum ada riwayat jadwal perjalanan yang ditugaskan ke armada ini.
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
