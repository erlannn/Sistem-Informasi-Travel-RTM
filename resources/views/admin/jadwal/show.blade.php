@extends('layouts.admin')

@section('title', 'Detail Jadwal Perjalanan - CV Travel RTM')
@section('page_title', 'Detail & Inspektor Kursi Jadwal')

@section('content')
<div class="space-y-8">

    <!-- Top Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.jadwal.index') }}" class="px-5 py-3 text-xs sm:text-sm font-black text-black bg-white border border-slate-200 rounded-xl hover:bg-slate-50 active:scale-95 shadow-sm transition inline-flex items-center gap-2 cursor-pointer">
            &larr; Kembali ke Jadwal Perjalanan
        </a>
    </div>

    <!-- Main Card Info & Seats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        
        <!-- Left Info & Seats Layout Card -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-5">
                <span class="px-3 py-0.5 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                    #JADWAL-{{ $jadwal->id_jadwal }}
                </span>
                <h2 class="text-xl font-black text-black mt-2 leading-tight">
                    <span>{{ $jadwal->asal }}</span> &rarr; <span>{{ $jadwal->tujuan }}</span>
                </h2>
                <p class="text-xs sm:text-sm text-black font-medium mt-1">Tanggal {{ $jadwal->tanggal }} &bull; Jam {{ $jadwal->jam }} WIB</p>
            </div>

            <!-- Details -->
            <div class="space-y-4 text-sm">
                <div class="flex justify-between border-b border-slate-100 pb-2.5">
                    <span class="text-black font-bold">Armada Mobil</span>
                    <span class="font-black text-black">{{ $jadwal->armada->merk ?? '-' }} ({{ $jadwal->armada->warna ?? '-' }})</span>
                </div>
                <div class="flex justify-between border-b border-slate-100 pb-2.5">
                    <span class="text-black font-bold">Sopir Ditugaskan</span>
                    <span class="font-black text-black">{{ $jadwal->sopir->nama ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-100 pb-2.5">
                    <span class="text-black font-bold">Harga Tiket</span>
                    <span class="font-black text-amber-700">Rp {{ number_format($jadwal->harga, 0, ',', '.') }} / Kursi</span>
                </div>
            </div>

            <!-- Seats Inspector Grid -->
            <div class="space-y-4 pt-3 border-t border-slate-100">
                <h3 class="text-xs font-black text-black uppercase tracking-wider">Denah Status Kursi (6 Kursi)</h3>
                <div class="grid grid-cols-2 gap-3.5">
                    @foreach($jadwal->kursis as $k)
                        <div class="p-3.5 rounded-2xl border text-center font-black text-xs shadow-xs {{ $k->status == 'Terisi' ? 'bg-rose-100 border-rose-300 text-rose-900' : 'bg-emerald-100 border-emerald-300 text-emerald-900' }}">
                            <div class="text-base font-black">Kursi {{ $k->nomor_kursi }}</div>
                            <div class="text-xs uppercase font-extrabold mt-1">{{ $k->status }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Booked Passengers Table -->
        <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                <div>
                    <h3 class="text-lg font-black text-black">Daftar Penumpang Terdaftar pada Jadwal Ini</h3>
                    <p class="text-xs sm:text-sm text-black font-medium mt-0.5">Transaksi pemesanan yang telah memesan pada keberangkatan ini.</p>
                </div>
                <span class="px-3.5 py-1.5 bg-slate-100 border border-slate-200 text-black text-xs font-black rounded-full">
                    Total: {{ $jadwal->pemesanans->count() }} Pemesanan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-black">
                    <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4 rounded-l-xl">ID Pesanan</th>
                            <th class="py-3.5 px-4">Nama Penumpang</th>
                            <th class="py-3.5 px-4">No. HP</th>
                            <th class="py-3.5 px-4">Nomor Kursi</th>
                            <th class="py-3.5 px-4 rounded-r-xl text-center">Status Transaksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($jadwal->pemesanans as $p)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-4 font-black text-black">#{{ $p->id_pemesanan }}</td>
                                <td class="py-4 px-4 font-black text-black">
                                    {{ $p->penumpang->nama ?? '-' }}
                                </td>
                                <td class="py-4 px-4 font-bold text-black">
                                    {{ $p->penumpang->no_hp ?? '-' }}
                                </td>
                                <td class="py-4 px-4 font-black text-black">
                                    <span class="px-2.5 py-1 rounded-md bg-slate-100 border border-slate-300 text-xs font-black">
                                        Kursi {{ $p->kursi->nomor_kursi ?? '-' }}
                                    </span>
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
                                    Belum ada transaksi pemesanan pada jadwal keberangkatan ini.
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
