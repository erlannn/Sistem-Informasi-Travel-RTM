@extends('layouts.admin')

@section('title', 'Transaksi Pemesanan - CV Travel RTM')
@section('page_title', 'Transaksi Pemesanan Tiket')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <span class="px-3 py-1 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[11px] font-extrabold uppercase tracking-wider">
                Data Transaksi
            </span>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Kelola Transaksi Pemesanan
            </h1>
            <p class="text-xs text-slate-500 font-medium">Verifikasi, update status pembayaran, atau buat pemesanan tiket manual oleh admin.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Filter Status Buttons -->
            <div class="flex items-center gap-1.5 bg-slate-50 p-1 rounded-2xl border border-slate-200">
                <a href="{{ route('admin.pemesanan.index') }}" class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ !request()->filled('status') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-200' }}">
                    Semua
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status' => 'Pending']) }}" class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ request('status') == 'Pending' ? 'bg-amber-500 text-white shadow-xs' : 'text-amber-700 hover:bg-amber-100' }}">
                    Pending
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status' => 'Lunas']) }}" class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ request('status') == 'Lunas' ? 'bg-emerald-600 text-white shadow-xs' : 'text-emerald-700 hover:bg-emerald-100' }}">
                    Lunas
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status' => 'Batal']) }}" class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ request('status') == 'Batal' ? 'bg-red-600 text-white shadow-xs' : 'text-red-700 hover:bg-red-100' }}">
                    Batal
                </a>
            </div>

            <a href="{{ route('admin.pemesanan.create') }}"
                class="px-4 py-2.5 bg-brand-500 hover:bg-brand-600 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition flex items-center justify-center cursor-pointer shrink-0">
                + Tambah Pemesanan Manual
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-100 text-slate-600 uppercase text-[10px] font-extrabold border-b border-slate-200">
                    <tr>
                        <th class="p-3.5 rounded-l-xl">ID Pesanan</th>
                        <th class="p-3.5">Tanggal Pesan</th>
                        <th class="p-3.5">Penumpang</th>
                        <th class="p-3.5">Rute Perjalanan</th>
                        <th class="p-3.5">Kursi</th>
                        <th class="p-3.5">Armada & Sopir</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5 rounded-r-xl text-center">Aksi & Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pemesanans as $p)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5 font-extrabold text-slate-900">#{{ $p->id_pemesanan }}</td>
                            <td class="p-3.5 font-medium text-slate-600">
                                {{ $p->tanggal_pesan }}
                            </td>
                            <td class="p-3.5 font-bold text-slate-900">
                                <div>{{ $p->penumpang->nama ?? 'N/A' }}</div>
                                <div class="text-[10px] text-slate-400 font-normal">{{ $p->penumpang->no_hp ?? '-' }}</div>
                            </td>
                            <td class="p-3.5 font-semibold text-slate-800">
                                <span class="text-brand-700 font-bold">{{ $p->jadwal->asal ?? '-' }}</span> &rarr; <span class="text-slate-800 font-bold">{{ $p->jadwal->tujuan ?? '-' }}</span>
                                <div class="text-[10px] text-slate-400 font-normal">{{ $p->jadwal->tanggal ?? '' }} &bull; Jam {{ $p->jadwal->jam ?? '' }}</div>
                            </td>
                            <td class="p-3.5 font-extrabold text-slate-900">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200">
                                    {{ $p->kursi->nomor_kursi ?? '-' }}
                                </span>
                            </td>
                            <td class="p-3.5 font-medium text-slate-600">
                                <div>{{ $p->jadwal->armada->merk ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400">Sopir: {{ $p->jadwal->sopir->nama ?? '-' }}</div>
                            </td>
                            <td class="p-3.5 text-center">
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
                            <td class="p-3.5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Status Form Dropdown -->
                                    <form action="{{ route('admin.pemesanan.update_status', $p->id_pemesanan) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="px-2.5 py-1 text-[11px] font-bold bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:ring-1 focus:ring-brand-500 cursor-pointer">
                                            <option value="Pending" {{ $p->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Lunas" {{ $p->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="Batal" {{ $p->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>

                                    <!-- Detail Action -->
                                    <a href="{{ route('admin.pemesanan.show', $p->id_pemesanan) }}" class="px-2.5 py-1 text-[11px] font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                        Struk
                                    </a>

                                    <!-- Edit Action -->
                                    <a href="{{ route('admin.pemesanan.edit', $p->id_pemesanan) }}" class="px-2.5 py-1 text-[11px] font-bold text-brand-700 bg-brand-50 hover:bg-brand-100 border border-brand-200 rounded-lg transition">
                                        Edit
                                    </a>

                                    <!-- Delete Action -->
                                    <form action="{{ route('admin.pemesanan.destroy', $p->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi pemesanan #{{ $p->id_pemesanan }}? Status kursi terkait akan dikembalikan ke Tersedia.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 text-[11px] font-bold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400 font-medium">
                                Belum ada transaksi pemesanan tiket. Klik "+ Tambah Pemesanan Manual" untuk membuat pesanan baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
