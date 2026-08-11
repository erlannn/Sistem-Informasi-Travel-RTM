@extends('layouts.admin')

@section('title', 'Pemesanan Tiket - CV Travel RTM')
@section('page_title', 'Pemesanan Tiket')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
<<<<<<< HEAD
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Kelola Pemesanan
            </h1>
            <p class="text-xs text-slate-500 font-medium">Daftar transaksi pemesanan tiket dari penumpang.</p>
=======
            <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                Data Transaksi
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-black tracking-tight mt-2">
                Kelola Transaksi Pemesanan
            </h1>
            <p class="text-xs sm:text-sm text-black font-medium mt-1 leading-relaxed">Verifikasi, update status pembayaran, atau buat pemesanan tiket manual oleh admin.</p>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Filter Status Buttons -->
<<<<<<< HEAD
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
=======
            <div class="flex items-center gap-1.5 bg-slate-100 p-1.5 rounded-2xl border border-slate-200">
                <a href="{{ route('admin.pemesanan.index') }}" class="px-3.5 py-2 text-xs font-black rounded-xl transition cursor-pointer {{ !request()->filled('status') ? 'bg-slate-950 text-white shadow-xs' : 'text-black hover:bg-slate-200' }}">
                    Semua
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status' => 'Pending']) }}" class="px-3.5 py-2 text-xs font-black rounded-xl transition cursor-pointer {{ request('status') == 'Pending' ? 'bg-amber-500 text-slate-950 shadow-xs' : 'text-amber-900 hover:bg-amber-200' }}">
                    Pending
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status' => 'Lunas']) }}" class="px-3.5 py-2 text-xs font-black rounded-xl transition cursor-pointer {{ request('status') == 'Lunas' ? 'bg-emerald-600 text-white shadow-xs' : 'text-emerald-900 hover:bg-emerald-200' }}">
                    Lunas
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status' => 'Batal']) }}" class="px-3.5 py-2 text-xs font-black rounded-xl transition cursor-pointer {{ request('status') == 'Batal' ? 'bg-rose-600 text-white shadow-xs' : 'text-rose-900 hover:bg-rose-200' }}">
                    Batal
                </a>
            </div>

            <a href="{{ route('admin.pemesanan.create') }}"
                class="px-5 py-3 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-95 text-slate-950 font-black text-xs sm:text-sm rounded-xl shadow-sm transition flex items-center justify-center cursor-pointer shrink-0">
                + Tambah Pemesanan Manual
            </a>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-black">
                <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                    <tr>
<<<<<<< HEAD
                        <th class="p-3.5 rounded-l-xl">ID Pesanan</th>
                        <th class="p-3.5">Penumpang</th>
                        <th class="p-3.5">Rute Perjalanan</th>
                        <th class="p-3.5">Kursi</th>
                        <th class="p-3.5">Armada & Sopir</th>
                        <th class="p-3.5 text-center">Status Perjalanan</th>
                        <th class="p-3.5 rounded-r-xl text-center">Aksi & Update Status</th>
=======
                        <th class="py-4 px-4 sm:px-5 rounded-l-xl">ID Pesanan</th>
                        <th class="py-4 px-4 sm:px-5">Tanggal Pesan</th>
                        <th class="py-4 px-4 sm:px-5">Penumpang</th>
                        <th class="py-4 px-4 sm:px-5">Rute Perjalanan</th>
                        <th class="py-4 px-4 sm:px-5">Kursi</th>
                        <th class="py-4 px-4 sm:px-5">Armada & Sopir</th>
                        <th class="py-4 px-4 sm:px-5 text-center">Status</th>
                        <th class="py-4 px-4 sm:px-5 rounded-r-xl text-center">Aksi & Status</th>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pemesanans as $p)
<<<<<<< HEAD
                        @php
                            $currStatus = $p->status_perjalanan ?? 'Pending';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5 font-extrabold text-slate-900">#{{ $p->id_pemesanan }}</td>
                            <td class="p-3.5 font-bold text-slate-900">
=======
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-4 sm:px-5 font-black text-black">#{{ $p->id_pemesanan }}</td>
                            <td class="py-4 px-4 sm:px-5 font-medium text-black">
                                {{ $p->tanggal_pesan }}
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-bold text-black">
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                                <div>{{ $p->penumpang->nama ?? 'N/A' }}</div>
                                <div class="text-xs text-black font-medium mt-0.5">{{ $p->penumpang->no_hp ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-bold text-black">
                                <span>{{ $p->jadwal->asal ?? '-' }}</span> &rarr; <span>{{ $p->jadwal->tujuan ?? '-' }}</span>
                                <div class="text-xs text-black font-medium mt-0.5">{{ $p->jadwal->tanggal ?? '' }} &bull; Jam {{ $p->jadwal->jam ?? '' }}</div>
                            </td>
<<<<<<< HEAD
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
=======
                            <td class="py-4 px-4 sm:px-5 font-black text-black">
                                <span class="px-2.5 py-1 rounded-md bg-slate-100 border border-slate-300 text-xs font-black">
                                    Kursi {{ $p->kursi->nomor_kursi ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-semibold text-black">
                                <div>{{ $p->jadwal->armada->merk ?? '-' }}</div>
                                <div class="text-xs text-black font-medium mt-0.5">Sopir: {{ $p->jadwal->sopir->nama ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-4 sm:px-5 text-center">
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
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
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
<<<<<<< HEAD
                                        <select name="status_perjalanan" onchange="this.form.submit()" class="px-2.5 py-1 text-[11px] font-bold bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:ring-1 focus:ring-brand-500 cursor-pointer">
                                            <option value="Pending" {{ $currStatus == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Selesai" {{ $currStatus == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Batal" {{ $currStatus == 'Batal' ? 'selected' : '' }}>Batal</option>
=======
                                        <select name="status" onchange="this.form.submit()" class="px-3 py-1.5 text-xs font-black bg-slate-50 border border-slate-300 rounded-lg text-black focus:ring-2 focus:ring-amber-400 cursor-pointer outline-none">
                                            <option value="Pending" {{ $p->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Lunas" {{ $p->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="Batal" {{ $p->status == 'Batal' ? 'selected' : '' }}>Batal</option>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                                        </select>
                                    </form>

                                    <!-- Detail Action -->
<<<<<<< HEAD
                                    <a href="{{ route('admin.pemesanan.show', $p->id_pemesanan) }}" class="px-2.5 py-1 text-[11px] font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                        Detail
=======
                                    <a href="{{ route('admin.pemesanan.show', $p->id_pemesanan) }}" class="px-3 py-1.5 text-xs font-black text-black bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-lg active:scale-95 transition cursor-pointer">
                                        Struk
                                    </a>

                                    <!-- Edit Action -->
                                    <a href="{{ route('admin.pemesanan.edit', $p->id_pemesanan) }}" class="px-3 py-1.5 text-xs font-black text-amber-950 bg-amber-100 hover:bg-amber-200 border border-amber-300 rounded-lg active:scale-95 transition cursor-pointer">
                                        Edit
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
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
<<<<<<< HEAD
                            <td colspan="7" class="p-8 text-center text-slate-400 font-medium">
                                Belum ada transaksi pemesanan tiket.
=======
                            <td colspan="8" class="py-12 text-center text-black font-semibold text-sm">
                                Belum ada transaksi pemesanan tiket. Klik "+ Tambah Pemesanan Manual" untuk membuat pesanan.
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
