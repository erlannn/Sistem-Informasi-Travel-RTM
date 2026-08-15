@extends('layouts.admin')

@section('title', 'Kelola Sopir - CV Travel RTM')
@section('page_title', 'Kelola Data Sopir')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Toolbar Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight">
                Kelola Sopir Travel
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Manajemen pengemudi, kontak WhatsApp, alamat, dan jadwal penugasan</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Search Form -->
            <form action="{{ route('admin.sopir.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, no hp, alamat..."
                        class="w-full pl-9 pr-4 py-2.5 text-xs md:text-sm text-slate-800 font-semibold bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all outline-none">
                </div>
                <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-950 active:scale-95 text-white font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer flex items-center gap-1.5 shrink-0">
                    <span>Cari</span>
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.sopir.index') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold text-xs rounded-xl transition-all cursor-pointer shrink-0">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Tambah Sopir Button -->
            <a href="{{ route('admin.sopir.create') }}"
                class="px-4 py-2.5 bg-amber-400 hover:bg-amber-300 active:scale-95 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0 w-full sm:w-auto">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Sopir</span>
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
                        <th class="py-3.5 px-4">Nama Sopir</th>
                        <th class="py-3.5 px-4">No. Telepon / WA</th>
                        <th class="py-3.5 px-4">Alamat</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Jadwal Tugas</th>
                        <th class="py-3.5 px-4 rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs md:text-sm">
                    @forelse($sopirs as $s)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- No. -->
                            <td class="py-4 px-4 font-extrabold text-slate-900">
                                {{ $sopirs->firstItem() + $loop->index }}
                            </td>

                            <!-- Nama Sopir -->
                            <td class="py-4 px-4 font-bold text-slate-900">
                                {{ $s->nama }}
                            </td>

                            <!-- No HP / WA (Tanpa Background) -->
                            <td class="py-4 px-4 font-semibold">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $s->no_hp) }}" target="_blank" class="inline-flex items-center gap-1.5 text-slate-800 hover:text-emerald-600 transition-colors font-bold">
                                    <i class="fa-brands fa-whatsapp text-emerald-500 text-base"></i>
                                    <span>{{ $s->no_hp }}</span>
                                </a>
                            </td>

                            <!-- Alamat -->
                            <td class="py-4 px-4 font-semibold text-slate-600 max-w-xs truncate">
                                {{ $s->alamat ?? '-' }}
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-4 text-center">
                                @if(($s->status ?? 'Aktif') === 'Aktif')
                                    <span class="inline-block px-3 py-1 rounded-lg text-xs font-black bg-emerald-500 text-white shadow-xs">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-lg text-xs font-black bg-red-600 text-white shadow-xs">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>

                            <!-- Jadwal Tugas -->
                            <td class="py-4 px-4 text-center font-bold text-slate-800">
                                {{ $s->jadwals_count }} Tugas
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Detail Button -->
                                    <a href="{{ route('admin.sopir.show', $s->id_sopir) }}"
                                        class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 active:scale-95 transition-all cursor-pointer flex items-center gap-1.5"
                                        title="Lihat Detail Sopir">
                                        <i class="fa-solid fa-eye text-[11px]"></i>
                                        <span>Detail</span>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.sopir.edit', $s->id_sopir) }}"
                                        class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 active:scale-95 transition-all cursor-pointer flex items-center gap-1.5"
                                        title="Edit Informasi Sopir">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        <span>Edit</span>
                                    </a>

                                    <!-- Non-Aktifkan Button -->
                                    @if(($s->status ?? 'Aktif') === 'Aktif')
                                        <form action="{{ route('admin.sopir.destroy', $s->id_sopir) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menon-aktifkan sopir ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="px-3 py-1.5 rounded-xl text-xs font-bold text-white bg-red-600 hover:bg-red-700 active:scale-95 transition-all cursor-pointer flex items-center gap-1.5"
                                                title="Non-Aktifkan Sopir">
                                                <i class="fa-solid fa-user-slash text-[11px]"></i>
                                                <span>Non-Aktifkan</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500 font-medium text-xs sm:text-sm">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-user-xmark text-3xl text-slate-300"></i>
                                    <p class="font-bold text-slate-700">Belum ada data sopir di database.</p>
                                    <p class="text-xs text-slate-400">Klik tombol "+ Tambah Sopir" di atas untuk menambahkan pengemudi baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sopirs->hasPages())
            <div class="mt-6 pt-4 border-t border-slate-100">
                {{ $sopirs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection