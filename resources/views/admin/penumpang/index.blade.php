@extends('layouts.admin')

@section('title', 'Data Penumpang - CV Travel RTM')
@section('page_title', 'Data Penumpang Terdaftar')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Toolbar Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight">
                Data Penumpang Terdaftar
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Manajemen akun pengguna, informasi kontak, dan riwayat pesanan tiket</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Search Bar -->
            <form action="{{ route('admin.penumpang.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, no hp..."
                        class="w-full pl-9 pr-4 py-2.5 text-xs md:text-sm text-slate-800 font-semibold bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all outline-none">
                </div>
                <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-950 active:scale-95 text-white font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer flex items-center gap-1.5 shrink-0">
                    <span>Cari</span>
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.penumpang.index') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold text-xs rounded-xl transition-all cursor-pointer shrink-0">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Tambah Penumpang Button -->
            <a href="{{ route('admin.penumpang.create') }}"
                class="px-4 py-2.5 bg-amber-400 hover:bg-amber-300 active:scale-95 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0 w-full sm:w-auto">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Penumpang</span>
            </a>
        </div>
    </div>

    <!-- Table Data Card -->
    <div class="bg-white rounded-3xl p-4 sm:p-6 border border-slate-200/80 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-100/80 text-slate-700 uppercase text-[10px] sm:text-[11px] font-extrabold tracking-wider border-b border-slate-200">
                        <th class="py-3 px-2 sm:px-3 rounded-l-xl text-center w-10">No.</th>
                        <th class="py-3 px-2 sm:px-3">Nama Penumpang</th>
                        <th class="py-3 px-2 sm:px-3">Email</th>
                        <th class="py-3 px-2 sm:px-3">No. Telepon / WA</th>
                        <th class="py-3 px-2 sm:px-3">Alamat</th>
                        <th class="py-3 px-2 sm:px-3 text-center">Total Pesanan</th>
                        <th class="py-3 px-2 sm:px-3 rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[11px] sm:text-xs">
                    @forelse($penumpangs as $p)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- No. -->
                            <td class="py-3 px-2 sm:px-3 font-extrabold text-slate-900 text-center">
                                {{ $penumpangs->firstItem() + $loop->index }}
                            </td>

                            <!-- Nama Penumpang -->
                            <td class="py-3 px-2 sm:px-3 font-bold text-slate-900">
                                {{ $p->nama }}
                            </td>

                            <!-- Email -->
                            <td class="py-3 px-2 sm:px-3 font-semibold text-slate-700 max-w-[160px] truncate" title="{{ $p->email }}">
                                {{ $p->email }}
                            </td>

                            <!-- No HP / WA -->
                            <td class="py-3 px-2 sm:px-3 font-semibold text-slate-800 whitespace-nowrap">
                                {{ $p->no_hp ?? '-' }}
                            </td>

                            <!-- Alamat -->
                            <td class="py-3 px-2 sm:px-3 font-semibold text-slate-600 max-w-[150px] truncate" title="{{ $p->alamat }}">
                                {{ $p->alamat ?? '-' }}
                            </td>

                            <!-- Total Pesanan -->
                            <td class="py-3 px-2 sm:px-3 text-center whitespace-nowrap">
                                <span class="inline-block px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-200">
                                    {{ $p->pemesanans_count }} Tiket
                                </span>
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-3 px-2 sm:px-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- Detail Button -->
                                    <a href="{{ route('admin.penumpang.show', $p->id_penumpang) }}"
                                        class="px-2 py-1 rounded-lg text-[11px] font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 active:scale-95 transition-all cursor-pointer flex items-center gap-1"
                                        title="Lihat Detail Penumpang">
                                        <i class="fa-solid fa-eye text-[10px]"></i>
                                        <span>Detail</span>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.penumpang.edit', $p->id_penumpang) }}"
                                        class="px-2 py-1 rounded-lg text-[11px] font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 active:scale-95 transition-all cursor-pointer flex items-center gap-1"
                                        title="Edit Informasi Penumpang">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                        <span>Edit</span>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.penumpang.destroy', $p->id_penumpang) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penumpang {{ addslashes($p->nama) }}? Akun terkait juga akan dihapus.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="px-2 py-1 rounded-lg text-[11px] font-bold text-white bg-red-600 hover:bg-red-700 active:scale-95 transition-all cursor-pointer flex items-center gap-1"
                                            title="Hapus Penumpang">
                                            <i class="fa-solid fa-trash-can text-[10px]"></i>
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
                                    <i class="fa-solid fa-users-slash text-3xl text-slate-300"></i>
                                    <p class="font-bold text-slate-700">Tidak ada data penumpang yang ditemukan.</p>
                                    <p class="text-xs text-slate-400">Gunakan kolom pencarian di atas atau tambahkan data baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($penumpangs->hasPages())
            <div class="mt-6 pt-4 border-t border-slate-100">
                {{ $penumpangs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection