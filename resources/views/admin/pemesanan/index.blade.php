@extends('layouts.admin')

@section('title', 'Transaksi Pemesanan - CV Travel RTM')
@section('page_title', 'Transaksi Pemesanan Tiket')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                Data Transaksi
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-black tracking-tight mt-2">
                Kelola Transaksi Pemesanan
            </h1>
            <p class="text-xs sm:text-sm text-black font-medium mt-1 leading-relaxed">Verifikasi, update status pembayaran, atau buat pemesanan tiket manual oleh admin.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Filter Status Buttons -->
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
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-black">
                <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-4 sm:px-5 rounded-l-xl">ID Pesanan</th>
                        <th class="py-4 px-4 sm:px-5">Tanggal Pesan</th>
                        <th class="py-4 px-4 sm:px-5">Penumpang</th>
                        <th class="py-4 px-4 sm:px-5">Rute Perjalanan</th>
                        <th class="py-4 px-4 sm:px-5">Kursi</th>
                        <th class="py-4 px-4 sm:px-5">Armada & Sopir</th>
                        <th class="py-4 px-4 sm:px-5 text-center">Status</th>
                        <th class="py-4 px-4 sm:px-5 rounded-r-xl text-center">Aksi & Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pemesanans as $p)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-4 sm:px-5 font-black text-black">#{{ $p->id_pemesanan }}</td>
                            <td class="py-4 px-4 sm:px-5 font-medium text-black">
                                {{ $p->tanggal_pesan }}
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-bold text-black">
                                <div>{{ $p->penumpang->nama ?? 'N/A' }}</div>
                                <div class="text-xs text-black font-medium mt-0.5">{{ $p->penumpang->no_hp ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-bold text-black">
                                <span>{{ $p->jadwal->asal ?? '-' }}</span> &rarr; <span>{{ $p->jadwal->tujuan ?? '-' }}</span>
                                <div class="text-xs text-black font-medium mt-0.5">{{ $p->jadwal->tanggal ?? '' }} &bull; Jam {{ $p->jadwal->jam ?? '' }}</div>
                            </td>
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
                                        Batal
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 sm:px-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Status Form Dropdown -->
                                    <form action="{{ route('admin.pemesanan.update_status', $p->id_pemesanan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="px-3 py-1.5 text-xs font-black bg-slate-50 border border-slate-300 rounded-lg text-black focus:ring-2 focus:ring-amber-400 cursor-pointer outline-none">
                                            <option value="Pending" {{ $p->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Lunas" {{ $p->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="Batal" {{ $p->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>

                                    <!-- Detail Action -->
                                    <a href="{{ route('admin.pemesanan.show', $p->id_pemesanan) }}" class="px-3 py-1.5 text-xs font-black text-black bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-lg active:scale-95 transition cursor-pointer">
                                        Struk
                                    </a>

                                    <!-- Edit Action -->
                                    <a href="{{ route('admin.pemesanan.edit', $p->id_pemesanan) }}" class="px-3 py-1.5 text-xs font-black text-amber-950 bg-amber-100 hover:bg-amber-200 border border-amber-300 rounded-lg active:scale-95 transition cursor-pointer">
                                        Edit
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
                            <td colspan="8" class="py-12 text-center text-black font-semibold text-sm">
                                Belum ada transaksi pemesanan tiket. Klik "+ Tambah Pemesanan Manual" untuk membuat pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
