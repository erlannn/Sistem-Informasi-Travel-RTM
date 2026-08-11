@extends('layouts.admin')

@section('title', 'Kelola Armada - CV Travel RTM')
@section('page_title', 'Kelola Armada Travel')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3.5 py-1 rounded-full bg-amber-100 border border-amber-300 text-amber-900 text-xs font-black uppercase tracking-wider">
                Data Armada
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-black tracking-tight mt-2">
                Kelola Armada & Mobil Travel
            </h1>
            <p class="text-xs sm:text-sm text-black font-medium mt-1 leading-relaxed">Daftar seluruh kendaraan travel yang terhubung ke sistem operasional database.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Search Form -->
            <form action="{{ route('admin.armada.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari merk, warna, status..."
                    class="px-4 py-3 text-sm text-black font-semibold bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition w-full sm:w-64 outline-none">
                <button type="submit" class="px-5 py-3 bg-slate-950 hover:bg-slate-900 active:scale-95 text-white font-black text-xs sm:text-sm rounded-xl shadow-xs transition cursor-pointer">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.armada.index') }}" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 active:scale-95 text-black font-bold text-xs sm:text-sm rounded-xl transition cursor-pointer">
                        Reset
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.armada.create') }}"
                class="px-5 py-3 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-95 text-slate-950 font-black text-xs sm:text-sm rounded-xl shadow-sm transition flex items-center justify-center cursor-pointer shrink-0">
                + Tambah Armada Baru
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-black">
                <thead class="bg-slate-100 text-black uppercase text-xs font-black border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-4 sm:px-5 rounded-l-xl">ID</th>
                        <th class="py-4 px-4 sm:px-5">Merk / Tipe Kendaraan</th>
                        <th class="py-4 px-4 sm:px-5">Warna</th>
                        <th class="py-4 px-4 sm:px-5">Total Perjalanan</th>
                        <th class="py-4 px-4 sm:px-5 text-center">Status Operasional</th>
                        <th class="py-4 px-4 sm:px-5 rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($armadas as $a)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-4 sm:px-5 font-black text-black">#{{ $a->id_armada }}</td>
                            <td class="py-4 px-4 sm:px-5 font-black text-black">
                                {{ $a->merk }}
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-semibold text-black">
                                {{ $a->warna }}
                            </td>
                            <td class="py-4 px-4 sm:px-5 font-black text-black">
                                <span class="px-3 py-1 rounded-full bg-slate-100 border border-slate-300 text-xs font-black">
                                    {{ $a->jadwals_count }} Jadwal
                                </span>
                            </td>
                            <td class="py-4 px-4 sm:px-5 text-center">
                                @if($a->status == 'Aktif')
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-900 border border-emerald-300">
                                        Aktif
                                    </span>
                                @elseif($a->status == 'Perbaikan')
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-900 border border-amber-300">
                                        Perbaikan
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-900 border border-rose-300">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 sm:px-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.armada.show', $a->id_armada) }}"
                                        class="px-3 py-1.5 rounded-lg text-xs font-black text-black bg-slate-100 hover:bg-slate-200 border border-slate-300 active:scale-95 transition cursor-pointer">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.armada.edit', $a->id_armada) }}"
                                        class="px-3 py-1.5 rounded-lg text-xs font-black text-amber-950 bg-amber-100 hover:bg-amber-200 border border-amber-300 active:scale-95 transition cursor-pointer">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.armada.destroy', $a->id_armada) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus armada ini dari database?');" class="inline">
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
                            <td colspan="6" class="py-12 text-center text-black font-semibold text-sm">
                                Belum ada data armada travel di database. Klik "+ Tambah Armada Baru" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
