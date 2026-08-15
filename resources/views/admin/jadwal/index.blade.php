@extends('layouts.admin')

@section('title', 'Jadwal Perjalanan - CV Travel RTM')
@section('page_title', 'Kelola Jadwal Perjalanan')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Toolbar Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight">
                Kelola Jadwal Perjalanan
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Atur rute, jam keberangkatan, armada, dan penetapan sopir</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Search Form -->
            <form action="{{ route('admin.jadwal.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari asal, tujuan, tanggal..."
                        class="w-full pl-9 pr-4 py-2.5 text-xs md:text-sm text-slate-800 font-semibold bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all outline-none">
                </div>
                <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-950 active:scale-95 text-white font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer flex items-center gap-1.5 shrink-0">
                    <span>Cari</span>
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.jadwal.index') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold text-xs rounded-xl transition-all cursor-pointer shrink-0">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Tambah Jadwal Button -->
            <a href="{{ route('admin.jadwal.create') }}"
                class="px-4 py-2.5 bg-amber-400 hover:bg-amber-300 active:scale-95 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0 w-full sm:w-auto">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Jadwal</span>
            </a>
        </div>
    </div>

    <!-- Table Data Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/80 text-slate-700 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-4 rounded-l-xl">No.</th>
                        <th class="py-3.5 px-4">Rute Perjalanan</th>
                        <th class="py-3.5 px-4">Waktu Keberangkatan</th>
                        <th class="py-3.5 px-4">Armada</th>
                        <th class="py-3.5 px-4">Sopir</th>
                        <th class="py-3.5 px-4 rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs md:text-sm">
                    @forelse($jadwals as $j)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- No. -->
                            <td class="py-4 px-4 font-extrabold text-slate-900">
                                {{ $jadwals->firstItem() + $loop->index }}
                            </td>

                            <!-- Rute -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2 font-bold text-slate-900">
                                    <span>{{ $j->asal }}</span>
                                    <i class="fa-solid fa-arrow-right text-xs text-amber-500"></i>
                                    <span>{{ $j->tujuan }}</span>
                                </div>
                            </td>

                            <!-- Tanggal & Jam -->
                            <td class="py-4 px-4">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-1.5 text-slate-700">
                                    <span class="font-semibold">{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}</span>
                                    <span class="hidden sm:inline text-slate-300">•</span>
                                    <span class="inline-block px-2 py-0.5 rounded-md bg-slate-100 font-bold text-slate-800 text-[11px] w-fit">
                                        {{ $j->jam }} WIB
                                    </span>
                                </div>
                            </td>

                            <!-- Armada (Tanpa Ikon Mobil) -->
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                <span>{{ $j->armada->merk ?? '-' }}</span>
                                @if(isset($j->armada->warna))
                                    <span class="text-slate-400 font-normal">({{ $j->armada->warna }})</span>
                                @endif
                            </td>

                            <!-- Sopir -->
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-user-driver text-xs text-slate-400"></i>
                                    <span>{{ $j->sopir->nama ?? '-' }}</span>
                                </div>
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Detail Button -->
                                    <a href="{{ route('admin.jadwal.show', $j->id_jadwal) }}"
                                        class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 active:scale-95 transition-all cursor-pointer flex items-center gap-1.5"
                                        title="Lihat Detail Kursi & Penumpang">
                                        <i class="fa-solid fa-eye text-[11px]"></i>
                                        <span>Detail</span>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.jadwal.edit', $j->id_jadwal) }}"
                                        class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 active:scale-95 transition-all cursor-pointer flex items-center gap-1.5"
                                        title="Edit Informasi Jadwal">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        <span>Edit</span>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.jadwal.destroy', $j->id_jadwal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini beserta data kursinya?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="px-3 py-1.5 rounded-xl text-xs font-bold text-white bg-red-600 hover:bg-red-700 active:scale-95 transition-all cursor-pointer flex items-center gap-1.5"
                                            title="Hapus Jadwal">
                                            <i class="fa-solid fa-trash-can text-[11px]"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500 font-medium text-xs sm:text-sm">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-calendar-xmark text-3xl text-slate-300"></i>
                                    <p class="font-bold text-slate-700">Belum ada jadwal keberangkatan.</p>
                                    <p class="text-xs text-slate-400">Klik tombol "+ Tambah Jadwal" di atas untuk menambahkan data baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jadwals->hasPages())
            <div class="mt-6 pt-4 border-t border-slate-100">
                {{ $jadwals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection