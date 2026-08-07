@extends('layouts.admin')

@section('title', 'Jadwal Perjalanan - CV Travel RTM')
@section('page_title', 'Kelola Jadwal Perjalanan')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <span class="px-3 py-1 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[11px] font-extrabold uppercase tracking-wider">
                Jadwal Perjalanan
            </span>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Kelola Jadwal Keberangkatan
            </h1>
            <p class="text-xs text-slate-500 font-medium">Pengaturan rute, tanggal, waktu keberangkatan, armada, sopir, dan harga tiket travel.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3">
            <!-- Search Form -->
            <form action="{{ route('admin.jadwal.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari asal, tujuan, tanggal..."
                    class="px-4 py-2.5 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition w-full sm:w-64">
                <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs rounded-xl shadow-xs transition">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.jadwal.index') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs rounded-xl transition">
                        Reset
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.jadwal.create') }}"
                class="px-4 py-2.5 bg-brand-500 hover:bg-brand-600 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition flex items-center justify-center cursor-pointer shrink-0 w-full sm:w-auto">
                + Buat Jadwal Baru
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-100 text-slate-600 uppercase text-[10px] font-extrabold border-b border-slate-200">
                    <tr>
                        <th class="p-3.5 rounded-l-xl">ID</th>
                        <th class="p-3.5">Rute (Asal &rarr; Tujuan)</th>
                        <th class="p-3.5">Tanggal & Jam</th>
                        <th class="p-3.5">Armada / Mobil</th>
                        <th class="p-3.5">Sopir / Driver</th>
                        <th class="p-3.5">Harga Tiket</th>
                        <th class="p-3.5 text-center">Pemesanan</th>
                        <th class="p-3.5 rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($jadwals as $j)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5 font-bold text-slate-400">#{{ $j->id_jadwal }}</td>
                            <td class="p-3.5 font-bold text-slate-900">
                                <span class="text-brand-700 font-extrabold">{{ $j->asal }}</span>
                                &rarr;
                                <span class="text-slate-800 font-extrabold">{{ $j->tujuan }}</span>
                            </td>
                            <td class="p-3.5 font-semibold text-slate-700">
                                <div>{{ $j->tanggal }}</div>
                                <div class="text-[10px] text-slate-500 font-normal">Jam {{ $j->jam }} WIB</div>
                            </td>
                            <td class="p-3.5 font-semibold text-slate-800">
                                {{ $j->armada->merk ?? 'N/A' }}
                            </td>
                            <td class="p-3.5 font-semibold text-slate-800">
                                {{ $j->sopir->nama ?? 'N/A' }}
                            </td>
                            <td class="p-3.5 font-extrabold text-slate-900">
                                Rp {{ number_format($j->harga, 0, ',', '.') }}
                            </td>
                            <td class="p-3.5 text-center font-bold text-slate-800">
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-700">
                                    {{ $j->pemesanans_count }} Pesanan
                                </span>
                            </td>
                            <td class="p-3.5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.jadwal.show', $j->id_jadwal) }}"
                                        class="px-2.5 py-1.5 rounded-lg text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.jadwal.edit', $j->id_jadwal) }}"
                                        class="px-2.5 py-1.5 rounded-lg text-xs font-bold text-brand-700 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.jadwal.destroy', $j->id_jadwal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini beserta data kursinya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-bold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400 font-medium">
                                Belum ada jadwal keberangkatan. Klik "+ Buat Jadwal Baru" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
