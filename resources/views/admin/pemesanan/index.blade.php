@extends('layouts.admin')

@section('title', 'Pemesanan Tiket - CV Travel RTM')
@section('page_title', 'Kelola Pemesanan Tiket')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Toolbar Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight">
                Kelola Pemesanan Tiket
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Daftar riwayat transaksi pemesanan tiket dari penumpang</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Filter Status Buttons -->
            <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-2xl border border-slate-200 overflow-x-auto">
                <a href="{{ route('admin.pemesanan.index') }}" class="px-3.5 py-1.5 text-xs font-extrabold rounded-xl transition-all {{ !request()->filled('status_perjalanan') && !request()->filled('status') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60' }}">
                    Semua
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status_perjalanan' => 'Pending']) }}" class="px-3.5 py-1.5 text-xs font-extrabold rounded-xl transition-all {{ request('status_perjalanan') == 'Pending' || request('status') == 'Pending' ? 'bg-amber-400 text-slate-950 shadow-xs' : 'text-amber-800 hover:bg-amber-100/70' }}">
                    Pending
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status_perjalanan' => 'Selesai']) }}" class="px-3.5 py-1.5 text-xs font-extrabold rounded-xl transition-all {{ request('status_perjalanan') == 'Selesai' || request('status') == 'Selesai' ? 'bg-emerald-500 text-white shadow-xs' : 'text-emerald-800 hover:bg-emerald-100/70' }}">
                    Selesai
                </a>
                <a href="{{ route('admin.pemesanan.index', ['status_perjalanan' => 'Batal']) }}" class="px-3.5 py-1.5 text-xs font-extrabold rounded-xl transition-all {{ request('status_perjalanan') == 'Batal' || request('status') == 'Batal' ? 'bg-red-600 text-white shadow-xs' : 'text-red-800 hover:bg-red-100/70' }}">
                    Batal
                </a>
            </div>
        </div>
    </div>

    <!-- Table Data Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/80 text-slate-700 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-4 rounded-l-xl">ID Pesanan</th>
                        <th class="py-3.5 px-4">Penumpang</th>
                        <th class="py-3.5 px-4">Rute Perjalanan</th>
                        <th class="py-3.5 px-4">Kursi</th>
                        <th class="py-3.5 px-4">Armada & Sopir</th>
                        <th class="py-3.5 px-4 text-center">Status Perjalanan</th>
                        <th class="py-3.5 px-4 rounded-r-xl text-center">Aksi & Update Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs md:text-sm">
                    @forelse($pemesanans as $p)
                        @php
                            $currStatus = $p->status_perjalanan ?? 'Pending';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Kode Pemesanan -->
                            <td class="py-4 px-4 font-extrabold text-slate-900">
                                RTM-{{ sprintf('%04d', $p->id_pemesanan) }}
                            </td>

                            <!-- Penumpang -->
                            <td class="py-4 px-4 font-bold text-slate-900">
                                <div>{{ $p->penumpang->nama ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-500 font-semibold mt-0.5 flex items-center gap-1">
                                    <i class="fa-brands fa-whatsapp text-emerald-500 text-xs"></i>
                                    <span>{{ $p->penumpang->no_hp ?? '-' }}</span>
                                </div>
                            </td>

                            <!-- Rute Perjalanan -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-1.5 font-bold text-slate-900">
                                    <span>{{ $p->jadwal->asal ?? '-' }}</span>
                                    <i class="fa-solid fa-arrow-right text-[11px] text-amber-500"></i>
                                    <span>{{ $p->jadwal->tujuan ?? '-' }}</span>
                                </div>
                                <div class="flex items-center gap-1 text-slate-500 font-medium text-xs mt-0.5">
                                    <span>{{ $p->jadwal->tanggal ?? '' }}</span>
                                    @if(isset($p->jadwal->jam))
                                        <span>•</span>
                                        <span class="font-bold text-slate-800">{{ $p->jadwal->jam }} WIB</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Kursi -->
                            <td class="py-4 px-4">
                                <span class="inline-block px-2.5 py-1 rounded-lg bg-amber-100 text-amber-950 font-bold border border-amber-200 text-xs">
                                    Kursi {{ $p->kursi->nomor_kursi ?? '-' }}
                                </span>
                            </td>

                            <!-- Armada & Sopir -->
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                <div class="font-bold text-slate-900">{{ $p->jadwal->armada->merk ?? '-' }}</div>
                                <div class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                                    <i class="fa-solid fa-user-driver text-[10px] text-slate-400"></i>
                                    <span>Sopir: {{ $p->jadwal->sopir->nama ?? '-' }}</span>
                                </div>
                            </td>

                            <!-- Status Perjalanan Indicator (Tampilan Teks Indikator, Bukan Tombol) -->
                            <td class="py-4 px-4 text-center select-none">
                                @if($p->status_perjalanan == 'Selesai')
                                    <span class="inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span>Selesai</span>
                                    </span>
                                @elseif($p->status_perjalanan == 'Batal')
                                    <span class="inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-red-700 bg-red-50 border border-red-200">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                        <span>Batal</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Pending</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi & Update Status Dropdown -->
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Status Form Dropdown -->
                                    <form action="{{ route('admin.pemesanan.update_status', $p->id_pemesanan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status_perjalanan" onchange="this.form.submit()" class="px-2.5 py-1.5 text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl text-slate-800 focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all cursor-pointer outline-none">
                                            <option value="Pending" {{ $currStatus == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Selesai" {{ $currStatus == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Batal" {{ $currStatus == 'Batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>

                                    <!-- Detail Action -->
                                    <a href="{{ route('admin.pemesanan.show', $p->id_pemesanan) }}" 
                                       class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 active:scale-95 transition-all cursor-pointer flex items-center gap-1.5"
                                       title="Lihat Detail Transaksi">
                                        <i class="fa-solid fa-eye text-[11px]"></i>
                                        <span>Detail</span>
                                    </a>

                                    <!-- Delete Action -->
                                    <form action="{{ route('admin.pemesanan.destroy', $p->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini? Kursi terkait akan direset menjadi tersedia.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1.5 rounded-xl text-xs font-bold text-white bg-red-600 hover:bg-red-700 active:scale-95 transition-all cursor-pointer flex items-center gap-1.5"
                                                title="Hapus Transaksi">
                                            <i class="fa-solid fa-trash-can text-[11px]"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500 font-medium text-xs sm:text-sm">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-ticket-simple text-3xl text-slate-300"></i>
                                    <p class="font-bold text-slate-700">Belum ada transaksi pemesanan tiket.</p>
                                    <p class="text-xs text-slate-400">Data pemesanan penumpang akan ditampilkan di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pemesanans->hasPages())
            <div class="mt-6 pt-4 border-t border-slate-100">
                {{ $pemesanans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection