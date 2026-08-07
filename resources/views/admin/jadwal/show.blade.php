@extends('layouts.admin')

@section('title', 'Detail Jadwal Perjalanan - CV Travel RTM')
@section('page_title', 'Detail & Inspektor Kursi Jadwal')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.jadwal.index') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition inline-flex items-center gap-2">
            &larr; Kembali ke Jadwal Perjalanan
        </a>
    </div>

    <!-- Main Card Info & Seats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Info & Seats Layout Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="px-2.5 py-0.5 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[10px] font-extrabold uppercase tracking-wider">
                    #JADWAL-{{ $jadwal->id_jadwal }}
                </span>
                <h2 class="text-xl font-black text-slate-900 mt-2">
                    <span class="text-brand-700">{{ $jadwal->asal }}</span> &rarr; {{ $jadwal->tujuan }}
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-1">Tanggal {{ $jadwal->tanggal }} &bull; Jam {{ $jadwal->jam }} WIB</p>
            </div>

            <!-- Details -->
            <div class="space-y-3 text-xs">
                <div class="flex justify-between border-b border-slate-100 pb-2">
                    <span class="text-slate-400 font-bold">Armada</span>
                    <span class="font-bold text-slate-900">{{ $jadwal->armada->merk ?? '-' }} ({{ $jadwal->armada->warna ?? '-' }})</span>
                </div>
                <div class="flex justify-between border-b border-slate-100 pb-2">
                    <span class="text-slate-400 font-bold">Sopir Ditugaskan</span>
                    <span class="font-bold text-slate-900">{{ $jadwal->sopir->nama ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-100 pb-2">
                    <span class="text-slate-400 font-bold">Harga Tiket</span>
                    <span class="font-extrabold text-brand-700">Rp {{ number_format($jadwal->harga, 0, ',', '.') }} / Kursi</span>
                </div>
            </div>

            <!-- Seats Inspector Grid -->
            <div class="space-y-3 pt-2 border-t border-slate-100">
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Denah Status Kursi (6 Kursi)</h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($jadwal->kursis as $k)
                        <div class="p-3 rounded-2xl border text-center font-bold text-xs shadow-2xs {{ $k->status == 'Terisi' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-emerald-50 border-emerald-200 text-emerald-700' }}">
                            <div class="text-base font-black">Kursi {{ $k->nomor_kursi }}</div>
                            <div class="text-[10px] uppercase font-bold mt-0.5">{{ $k->status }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Booked Passengers Table -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Daftar Penumpang Terdaftar pada Jadwal Ini</h3>
                    <p class="text-xs text-slate-500 font-medium">Transaksi pemesanan yang telah memesan pada keberangkatan ini.</p>
                </div>
                <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-extrabold rounded-full">
                    Total: {{ $jadwal->pemesanans->count() }} Pemesanan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-[10px] font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="p-3">ID Pesanan</th>
                            <th class="p-3">Nama Penumpang</th>
                            <th class="p-3">No. HP</th>
                            <th class="p-3">Nomor Kursi</th>
                            <th class="p-3 text-center">Status Transaksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($jadwal->pemesanans as $p)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3 font-extrabold text-slate-900">#{{ $p->id_pemesanan }}</td>
                                <td class="p-3 font-bold text-slate-900">
                                    {{ $p->penumpang->nama ?? '-' }}
                                </td>
                                <td class="p-3 font-semibold text-slate-600">
                                    {{ $p->penumpang->no_hp ?? '-' }}
                                </td>
                                <td class="p-3 font-extrabold text-slate-900">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200">
                                        Kursi {{ $p->kursi->nomor_kursi ?? '-' }}
                                    </span>
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
                                    Belum ada tiket yang dipesan pada jadwal perjalanan ini.
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
