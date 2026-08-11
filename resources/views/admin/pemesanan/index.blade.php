@extends('layouts.admin')

@section('title', 'Pemesanan Tiket - CV Travel RTM')
@section('page_title', 'Pemesanan Tiket')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Kelola Pemesanan
            </h1>
            <p class="text-xs text-slate-500 font-medium">Daftar transaksi pemesanan tiket dari penumpang.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Filter Status Buttons -->
            <div class="flex items-center gap-1.5 bg-slate-50 p-1 rounded-2xl border border-slate-200 overflow-x-auto">
                <a href="{{ route('admin.pemesanan.index') }}" class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ !request()->filled('status_perjalanan') && !request()->filled('status') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-200' }}">
                    Semua
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status_perjalanan' => 'Pending']) }}" class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ request('status_perjalanan') == 'Pending' || request('status') == 'Pending' ? 'bg-amber-500 text-white shadow-xs' : 'text-amber-700 hover:bg-amber-100' }}">
                    Pending
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status_perjalanan' => 'Selesai']) }}" class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ request('status_perjalanan') == 'Selesai' || request('status') == 'Selesai' ? 'bg-emerald-600 text-white shadow-xs' : 'text-emerald-700 hover:bg-emerald-100' }}">
                    Selesai
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status_perjalanan' => 'Batal']) }}" class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ request('status_perjalanan') == 'Batal' || request('status') == 'Batal' ? 'bg-red-600 text-white shadow-xs' : 'text-red-700 hover:bg-red-100' }}">
                    Batal
                </a>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-black">
                <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                    <tr>
                        <th class="p-3.5 rounded-l-xl">ID Pesanan</th>
                        <th class="p-3.5">Penumpang</th>
                        <th class="p-3.5">Rute Perjalanan</th>
                        <th class="p-3.5">Kursi</th>
                        <th class="p-3.5">Armada & Sopir</th>
                        <th class="p-3.5 text-center">Status Perjalanan</th>
                        <th class="p-3.5 rounded-r-xl text-center">Aksi & Update Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pemesanans as $p)
                        @php
                            $currStatus = $p->status_perjalanan ?? 'Pending';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5 font-extrabold text-slate-900">#{{ $p->id_pemesanan }}</td>
                            <td class="p-3.5 font-bold text-slate-900">
                                <div>{{ $p->penumpang->nama ?? 'N/A' }}</div>
                                <div class="text-xs text-black font-medium mt-0.5">{{ $p->penumpang->no_hp ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-bold text-black">
                                <span>{{ $p->jadwal->asal ?? '-' }}</span> &rarr; <span>{{ $p->jadwal->tujuan ?? '-' }}</span>
                                <div class="text-xs text-black font-medium mt-0.5">{{ $p->jadwal->tanggal ?? '' }} &bull; Jam {{ $p->jadwal->jam ?? '' }}</div>
                            </td>
                            <td class="p-3.5 font-extrabold text-slate-900">
                                <span class="px-2.5 py-1 rounded-lg bg-gold-50 border border-gold-200/60 text-gold-700 font-black">
                                    Kursi {{ $p->kursi->nomor_kursi ?? '-' }}
                                </span>
                            </td>
                            <td class="p-3.5 font-medium text-slate-600">
                                <div class="font-bold text-slate-800">{{ $p->jadwal->armada->merk ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400">Sopir: {{ $p->jadwal->sopir->nama ?? '-' }}</div>
                            </td>
                            <td class="p-3.5 text-center">
                                @if($p->status_perjalanan == 'Selesai')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Selesai
                                    </span>
                                @elseif($p->status_perjalanan == 'Batal')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200">
                                        Batal
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 sm:px-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Status Form Dropdown -->
                                    <form action="{{ route('admin.pemesanan.update_status', $p->id_pemesanan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status_perjalanan" onchange="this.form.submit()" class="px-2.5 py-1 text-[11px] font-bold bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:ring-1 focus:ring-brand-500 cursor-pointer">
                                            <option value="Pending" {{ $currStatus == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Selesai" {{ $currStatus == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Batal" {{ $currStatus == 'Batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>

                                    <!-- Detail Action -->
                                    <a href="{{ route('admin.pemesanan.show', $p->id_pemesanan) }}" class="px-2.5 py-1 text-[11px] font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                        Detail
                                    </a>

                                    <!-- Delete Action -->
                                    <form action="{{ route('admin.pemesanan.destroy', $p->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini? Kursi terkait akan direset menjadi tersedia.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-black text-rose-900 bg-rose-100 hover:bg-rose-200 border border-rose-300 rounded-lg active:scale-95 transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 font-medium">
                                Belum ada transaksi pemesanan tiket.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
