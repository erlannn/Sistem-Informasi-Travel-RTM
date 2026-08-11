@extends('layouts.admin')

@section('title', 'Detail Sopir - CV Travel RTM')
@section('page_title', 'Detail Data Sopir')

@section('content')
<div class="space-y-8">

    <!-- Top Navigation & Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.sopir.index') }}" class="px-5 py-3 text-xs sm:text-sm font-black text-black bg-white border border-slate-200 rounded-xl hover:bg-slate-50 active:scale-95 shadow-sm transition inline-flex items-center gap-2 cursor-pointer">
            &larr; Kembali ke Data Sopir
        </a>
    </div>

    <!-- Main Card Profile & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        
        <!-- Left Profile Card -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
                <div class="w-16 h-16 rounded-2xl bg-slate-950 text-amber-400 font-black text-2xl flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-id-card text-2xl"></i>
                </div>
                <div>
                    <span class="px-3 py-0.5 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                        #SOPIR-{{ $sopir->id_sopir }}
                    </span>
<<<<<<< HEAD
                    <h2 class="text-lg font-extrabold text-slate-900 mt-1">{{ $sopir->nama }}</h2>
                    <p class="text-xs text-emerald-600 font-bold">Sistem Bagi Hasil Per-Perjalanan</p>
=======
                    <h2 class="text-xl font-black text-black mt-2 leading-tight">{{ $sopir->nama }}</h2>
                    <p class="text-xs sm:text-sm text-black font-semibold mt-0.5">Gaji: Rp {{ number_format($sopir->gaji, 0, ',', '.') }}</p>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                </div>
            </div>

            <div class="space-y-4 text-sm">
                <div>
                    <span class="text-black font-black uppercase tracking-wider block text-xs mb-1.5">No. Handphone / WhatsApp</span>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sopir->no_hp) }}" target="_blank" class="font-black text-emerald-700 hover:underline flex items-center gap-1.5">
                        <i class="fa-brands fa-whatsapp text-emerald-600 text-base"></i>
                        <span>{{ $sopir->no_hp }} &rarr;</span>
                    </a>
                </div>
                <div>
                    <span class="text-black font-black uppercase tracking-wider block text-xs mb-1.5">Alamat Lengkap</span>
                    <span class="font-medium text-black leading-relaxed">{{ $sopir->alamat ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-black font-black uppercase tracking-wider block text-xs mb-1.5">Total Tugas Perjalanan</span>
                    <span class="font-black text-black text-base">{{ $sopir->jadwals_count }} Keberangkatan</span>
                </div>
            </div>
        </div>

        <!-- Right Linked Schedules Table -->
        <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                <div>
                    <h3 class="text-lg font-black text-black">Jadwal Tugas Pengemudi</h3>
                    <p class="text-xs sm:text-sm text-black font-medium mt-0.5">Daftar rute travel yang ditugaskan kepada sopir ini.</p>
                </div>
                <span class="px-3.5 py-1.5 bg-slate-100 border border-slate-200 text-black text-xs font-black rounded-full">
                    Total: {{ $sopir->jadwals->count() }} Perjalanan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-black">
                    <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4 rounded-l-xl">ID Jadwal</th>
                            <th class="py-3.5 px-4">Rute (Asal &rarr; Tujuan)</th>
                            <th class="py-3.5 px-4">Tanggal & Waktu</th>
                            <th class="py-3.5 px-4">Armada Mobil</th>
                            <th class="py-3.5 px-4 rounded-r-xl text-right">Harga Tiket</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($sopir->jadwals as $j)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-4 font-black text-black">#{{ $j->id_jadwal }}</td>
                                <td class="py-4 px-4 font-black text-black">
                                    <span>{{ $j->asal }}</span> &rarr; {{ $j->tujuan }}
                                </td>
                                <td class="py-4 px-4 font-medium text-black">
                                    {{ $j->tanggal }} &bull; Jam {{ $j->jam }}
                                </td>
                                <td class="py-4 px-4 font-bold text-black">
                                    {{ $j->armada->merk ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-4 text-right font-black text-amber-700">
                                    Rp {{ number_format($j->harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-black font-semibold text-sm">
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
