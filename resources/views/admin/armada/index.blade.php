@extends('layouts.admin')

@section('title', 'Kelola Armada - CV Travel RTM')
@section('page_title', 'Kelola Armada Travel')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <span class="px-3 py-1 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-[11px] font-extrabold uppercase tracking-wider">
                Data Armada
            </span>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Kelola Armada Bus & Mobil Travel
            </h1>
            <p class="text-xs text-slate-500 font-medium">Daftar seluruh kendaraan travel yang terhubung ke sistem operasional database.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3">
            <!-- Search Form -->
            <form action="{{ route('admin.armada.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari merk, warna, status..."
                    class="px-4 py-2.5 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition w-full sm:w-64">
                <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs rounded-xl shadow-xs transition">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.armada.index') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs rounded-xl transition">
                        Reset
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.armada.create') }}"
                class="px-4 py-2.5 bg-brand-500 hover:bg-brand-600 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition flex items-center justify-center cursor-pointer shrink-0 w-full sm:w-auto">
                + Tambah Armada Baru
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
                        <th class="p-3.5">Merk / Tipe Kendaraan</th>
                        <th class="p-3.5">Warna</th>
                        <th class="p-3.5">Total Perjalanan</th>
                        <th class="p-3.5 text-center">Status Operasional</th>
                        <th class="p-3.5 rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($armadas as $a)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5 font-bold text-slate-400">#{{ $a->id_armada }}</td>
                            <td class="p-3.5 font-bold text-slate-900">
                                {{ $a->merk }}
                            </td>
                            <td class="p-3.5 font-medium text-slate-600">
                                {{ $a->warna }}
                            </td>
                            <td class="p-3.5 font-bold text-slate-800">
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200">
                                    {{ $a->jadwals_count }} Jadwal
                                </span>
                            </td>
                            <td class="p-3.5 text-center">
                                @if($a->status == 'Aktif')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                @elseif($a->status == 'Perbaikan')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        Perbaikan
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.armada.show', $a->id_armada) }}"
                                        class="px-2.5 py-1.5 rounded-lg text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.armada.edit', $a->id_armada) }}"
                                        class="px-2.5 py-1.5 rounded-lg text-xs font-bold text-brand-700 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.armada.destroy', $a->id_armada) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus armada ini dari database?');">
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
                            <td colspan="6" class="p-8 text-center text-slate-400 font-medium">
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
