@extends('layouts.admin')

@section('title', 'Jadwal Perjalanan - CV Travel RTM')
@section('page_title', 'Kelola Jadwal Perjalanan')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
<<<<<<< HEAD
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Kelola Jadwal 
            </h1>
=======
            <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                Jadwal Perjalanan
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-black tracking-tight mt-2">
                Kelola Jadwal Keberangkatan
            </h1>
            <p class="text-xs sm:text-sm text-black font-medium mt-1 leading-relaxed">Pengaturan rute, tanggal, waktu keberangkatan, armada, sopir, dan harga tiket travel.</p>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Search Form -->
            <form action="{{ route('admin.jadwal.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari asal, tujuan, tanggal..."
                    class="px-4 py-3 text-sm text-black font-semibold bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition w-full sm:w-64 outline-none">
                <button type="submit" class="px-5 py-3 bg-slate-950 hover:bg-slate-900 active:scale-95 text-white font-black text-xs sm:text-sm rounded-xl shadow-xs transition cursor-pointer">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.jadwal.index') }}" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 active:scale-95 text-black font-bold text-xs sm:text-sm rounded-xl transition cursor-pointer">
                        Reset
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.jadwal.create') }}"
<<<<<<< HEAD
                class="px-4 py-2.5 bg-brand-500 hover:bg-brand-600 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition flex items-center justify-center cursor-pointer shrink-0 w-full sm:w-auto">
                Tambah Jadwal
=======
                class="px-5 py-3 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-95 text-slate-950 font-black text-xs sm:text-sm rounded-xl shadow-sm transition flex items-center justify-center cursor-pointer shrink-0">
                + Buat Jadwal Baru
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-black">
                <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                    <tr>
<<<<<<< HEAD
                        <th class="p-3.5 rounded-l-xl">NO</th>
                        <th class="p-3.5">Rute (Asal &rarr; Tujuan)</th>
                        <th class="p-3.5">Tanggal & Jam</th>
                        <th class="p-3.5">Armada</th>
                        <th class="p-3.5">Sopir</th>
                        {{-- <th class="p-3.5">Harga Tiket</th>
                        <th class="p-3.5 text-center">Pemesanan</th> --}}
                        <th class="p-3.5 rounded-r-xl text-center">Aksi</th>
=======
                        <th class="py-4 px-4 sm:px-5 rounded-l-xl">ID</th>
                        <th class="py-4 px-4 sm:px-5">Rute (Asal &rarr; Tujuan)</th>
                        <th class="py-4 px-4 sm:px-5">Tanggal & Jam</th>
                        <th class="py-4 px-4 sm:px-5">Armada / Mobil</th>
                        <th class="py-4 px-4 sm:px-5">Sopir / Driver</th>
                        <th class="py-4 px-4 sm:px-5">Harga Tiket</th>
                        <th class="py-4 px-4 sm:px-5 text-center">Pemesanan</th>
                        <th class="py-4 px-4 sm:px-5 rounded-r-xl text-center">Aksi</th>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($jadwals as $j)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-4 sm:px-5 font-black text-black">#{{ $j->id_jadwal }}</td>
                            <td class="py-4 px-4 sm:px-5 font-black text-black">
                                <span>{{ $j->asal }}</span>
                                &rarr;
                                <span>{{ $j->tujuan }}</span>
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-semibold text-black">
                                <div>{{ $j->tanggal }}</div>
                                <div class="text-xs text-black font-medium mt-0.5">Jam {{ $j->jam }} WIB</div>
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-bold text-black">
                                {{ $j->armada->merk ?? 'N/A' }}
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-bold text-black">
                                {{ $j->sopir->nama ?? 'N/A' }}
                            </td>
<<<<<<< HEAD
                            {{-- <td class="p-3.5 font-extrabold text-slate-900">
=======
                            <td class="py-4 px-4 sm:px-5 font-black text-amber-700">
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                                Rp {{ number_format($j->harga, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4 sm:px-5 text-center font-black text-black">
                                <span class="px-3 py-1 rounded-full bg-slate-100 border border-slate-300 text-xs font-black">
                                    {{ $j->pemesanans_count }} Pesanan
                                </span>
<<<<<<< HEAD
                            </td> --}}
                            <td class="p-3.5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
=======
                            </td>
                            <td class="py-4 px-4 sm:px-5 text-center">
                                <div class="flex items-center justify-center gap-2">
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
                                    <a href="{{ route('admin.jadwal.show', $j->id_jadwal) }}"
                                        class="px-3 py-1.5 rounded-lg text-xs font-black text-black bg-slate-100 hover:bg-slate-200 border border-slate-300 active:scale-95 transition cursor-pointer">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.jadwal.edit', $j->id_jadwal) }}"
                                        class="px-3 py-1.5 rounded-lg text-xs font-black text-amber-950 bg-amber-100 hover:bg-amber-200 border border-amber-300 active:scale-95 transition cursor-pointer">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.jadwal.destroy', $j->id_jadwal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini beserta data kursinya?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-black text-rose-900 bg-rose-100 hover:bg-rose-200 border border-rose-300 active:scale-95 transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-black font-semibold text-sm">
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
