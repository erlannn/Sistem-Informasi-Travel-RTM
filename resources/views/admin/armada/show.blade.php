@extends('layouts.admin')

@section('title', 'Detail Armada - CV Travel RTM')
@section('page_title', 'Detail Data Armada')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation & Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.armada.index') }}" class="px-4 py-2.5 text-xs sm:text-sm font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 active:scale-95 shadow-xs transition-all inline-flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Data Armada</span>
        </a>
    </div>

    <!-- Main Card Profile & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Profile Card -->
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">
            <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
                <div class="w-14 h-14 rounded-2xl bg-slate-950 text-amber-400 font-extrabold flex items-center justify-center shadow-md shrink-0">
                    <i class="fa-solid fa-van-shuttle text-2xl"></i>
                </div>
                <div>
                    <span class="inline-block px-2.5 py-0.5 rounded-md bg-amber-100 border border-amber-300 text-amber-900 text-[11px] font-black uppercase tracking-wider">
                        #ARMADA-{{ $armada->id_armada }}
                    </span>
                    <h2 class="text-lg font-extrabold text-slate-900 mt-1.5 leading-tight">{{ $armada->merk }}</h2>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">Warna: <span class="text-slate-800">{{ $armada->warna }}</span></p>
                </div>
            </div>

            <div class="space-y-4 text-xs md:text-sm">
                <!-- Status Operasional -->
                <div>
                    <span class="text-slate-500 font-bold uppercase tracking-wider block text-[11px] mb-1.5">Status Operasional</span>
                    @if($armada->status == 'Aktif')
                        <span class="inline-block px-3 py-1 rounded-lg text-xs font-black bg-emerald-500 text-white shadow-xs">
                            Aktif
                        </span>
                    @elseif($armada->status == 'Perbaikan')
                        <span class="inline-block px-3 py-1 rounded-lg text-xs font-black bg-amber-400 text-slate-950 shadow-xs">
                            Perbaikan / Servis
                        </span>
                    @else
                        <span class="inline-block px-3 py-1 rounded-lg text-xs font-black bg-red-600 text-white shadow-xs">
                            Nonaktif
                        </span>
                    @endif
                </div>

                <!-- Kapasitas Kursi -->
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Kapasitas Kursi</span>
                    <span class="font-extrabold text-amber-600 text-sm md:text-base">{{ $armada->kursi ?? 5 }} Kursi Penumpang</span>
                </div>

                <!-- Total Jadwal -->
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Total Jadwal Ditugaskan</span>
                    <span class="font-extrabold text-slate-900 text-sm md:text-base">{{ $armada->jadwals_count }} Perjalanan</span>
                </div>
            </div>
        </div>

        <!-- Right Linked Schedules Table -->
        <div class="lg:col-span-2 bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Daftar Perjalanan Armada Ini</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Jadwal travel yang ditugaskan menggunakan kendaraan ini</p>
                </div>
                <span class="px-3 py-1 bg-slate-100 border border-slate-200 text-slate-800 text-xs font-bold rounded-lg shrink-0">
                    Total: {{ $armada->jadwals->count() }} Jadwal
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100/80 text-slate-700 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200">
                            <th class="py-3 px-3.5 rounded-l-xl">ID Jadwal</th>
                            <th class="py-3 px-3.5">Rute Perjalanan</th>
                            <th class="py-3 px-3.5">Tanggal & Waktu</th>
                            <th class="py-3 px-3.5">Sopir</th>
                            <th class="py-3 px-3.5 rounded-r-xl text-right">Harga Tiket</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs md:text-sm">
                        @forelse($armada->jadwals as $j)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- ID Jadwal -->
                                <td class="py-3.5 px-3.5 font-extrabold text-slate-900">
                                    #{{ $j->id_jadwal }}
                                </td>

                                <!-- Rute -->
                                <td class="py-3.5 px-3.5">
                                    <div class="flex items-center gap-1.5 font-bold text-slate-900">
                                        <span>{{ $j->asal }}</span>
                                        <i class="fa-solid fa-arrow-right text-[11px] text-amber-500"></i>
                                        <span>{{ $j->tujuan }}</span>
                                    </div>
                                </td>

                                <!-- Tanggal & Waktu -->
                                <td class="py-3.5 px-3.5">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 text-slate-700">
                                        <span class="font-semibold">{{ $j->tanggal }}</span>
                                        <span class="hidden sm:inline text-slate-300">•</span>
                                        <span class="inline-block px-2 py-0.5 rounded-md bg-slate-100 font-bold text-slate-800 text-[11px] w-fit">
                                            {{ $j->jam }} WIB
                                        </span>
                                    </div>
                                </td>

                                <!-- Sopir -->
                                <td class="py-3.5 px-3.5 font-semibold text-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-user-driver text-xs text-slate-400"></i>
                                        <span>{{ $j->sopir->nama ?? 'N/A' }}</span>
                                    </div>
                                </td>

                                <!-- Harga -->
                                <td class="py-3.5 px-3.5 text-right font-extrabold text-amber-600">
                                    Rp {{ number_format($j->harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-slate-500 font-medium text-xs sm:text-sm">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fa-solid fa-calendar-xmark text-3xl text-slate-300"></i>
                                        <p class="font-bold text-slate-700">Belum ada riwayat jadwal perjalanan yang ditugaskan ke armada ini.</p>
                                    </div>
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