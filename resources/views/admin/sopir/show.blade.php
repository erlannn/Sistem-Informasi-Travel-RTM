@extends('layouts.admin')

@section('title', 'Detail Sopir - CV Travel RTM')
@section('page_title', 'Detail Data Sopir')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation & Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.sopir.index') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition inline-flex items-center gap-2">
            &larr; Kembali ke Data Sopir
        </a>
    </div>

    <!-- Main Card Profile & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Profile Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">
            <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
                <div class="w-16 h-16 rounded-2xl bg-slate-900 text-brand-500 font-black text-2xl flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-id-card text-2xl"></i>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[10px] font-extrabold uppercase tracking-wider">
                        #SOPIR-{{ $sopir->id_sopir }}
                    </span>
                    <h2 class="text-lg font-extrabold text-slate-900 mt-1">{{ $sopir->nama }}</h2>
                    <p class="text-xs text-slate-500 font-medium">Gaji: Rp {{ number_format($sopir->gaji, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="space-y-4 text-xs">
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">No. Handphone / WhatsApp</span>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sopir->no_hp) }}" target="_blank" class="font-bold text-brand-700 hover:underline">
                        {{ $sopir->no_hp }} &rarr;
                    </a>
                </div>
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Alamat Lengkap</span>
                    <span class="font-medium text-slate-700 leading-relaxed">{{ $sopir->alamat ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px] mb-0.5">Total Tugas Perjalanan</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $sopir->jadwals_count }} Keberangkatan</span>
                </div>
            </div>
        </div>

        <!-- Right Linked Schedules Table -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Jadwal Tugas Pengemudi</h3>
                    <p class="text-xs text-slate-500 font-medium">Daftar rute travel yang ditugaskan kepada sopir ini.</p>
                </div>
                <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-extrabold rounded-full">
                    Total: {{ $sopir->jadwals->count() }} Perjalanan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-[10px] font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="p-3">ID Jadwal</th>
                            <th class="p-3">Rute (Asal &rarr; Tujuan)</th>
                            <th class="p-3">Tanggal & Waktu</th>
                            <th class="p-3">Armada Mobil</th>
                            <th class="p-3 text-right">Harga Tiket</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($sopir->jadwals as $j)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3 font-extrabold text-slate-900">#{{ $j->id_jadwal }}</td>
                                <td class="p-3 font-bold text-slate-900">
                                    <span class="text-brand-700">{{ $j->asal }}</span> &rarr; {{ $j->tujuan }}
                                </td>
                                <td class="p-3 font-medium text-slate-600">
                                    {{ $j->tanggal }} &bull; Jam {{ $j->jam }}
                                </td>
                                <td class="p-3 font-semibold text-slate-800">
                                    {{ $j->armada->merk ?? 'N/A' }}
                                </td>
                                <td class="p-3 text-right font-extrabold text-slate-900">
                                    Rp {{ number_format($j->harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400 font-medium">
                                    Sopir ini belum memiliki jadwal tugas perjalanan.
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
