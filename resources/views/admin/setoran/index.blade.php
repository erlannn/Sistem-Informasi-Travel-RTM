@extends('layouts.admin')

@section('title', 'Laporan Pembagian Hasil - CV Travel RTM')
@section('page_title', 'Laporan Pembagian Hasil Supir & Admin')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight">
                Laporan Pembagian Hasil Supir & Admin
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Rincian pembagian pendapatan tiket antara hak supir dan bagian kas admin/perusahaan</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('admin.setoran.index') }}" method="GET" id="filter-form" class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <select name="filter_type" id="filter_type" onchange="toggleFilterInputs()" class="px-3.5 py-2 text-xs font-extrabold bg-slate-50 border border-slate-300 rounded-xl text-slate-800 focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all cursor-pointer outline-none">
                        <option value="semua" {{ ($filterType ?? 'semua') == 'semua' ? 'selected' : '' }}>Semua Periode</option>
                        <option value="harian" {{ ($filterType ?? '') == 'harian' ? 'selected' : '' }}>Per Hari (Harian)</option>
                        <option value="mingguan" {{ ($filterType ?? '') == 'mingguan' ? 'selected' : '' }}>Per Minggu (Mingguan)</option>
                        <option value="bulanan" {{ ($filterType ?? '') == 'bulanan' ? 'selected' : '' }}>Per Bulan (Bulanan)</option>
                    </select>
                </div>

                <!-- Input Tanggal untuk Harian & Mingguan -->
                <div id="input-date-container" class="{{ in_array($filterType ?? '', ['harian', 'mingguan']) ? '' : 'hidden' }}">
                    <input type="date" name="tanggal" value="{{ $selectedDate ?? date('Y-m-d') }}" onchange="this.form.submit()" class="px-3 py-2 text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl text-slate-800 focus:bg-white focus:ring-2 focus:ring-amber-400 transition-all cursor-pointer outline-none">
                </div>

                <!-- Select Bulan untuk Bulanan -->
                <div id="input-month-container" class="{{ ($filterType ?? '') == 'bulanan' ? '' : 'hidden' }}">
                    <select name="period" onchange="this.form.submit()" class="px-3.5 py-2 text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl text-slate-800 focus:bg-white focus:ring-2 focus:ring-amber-400 transition-all cursor-pointer outline-none">
                        @foreach($periods as $val => $label)
                            <option value="{{ $val }}" {{ ($selectedPeriod ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                @if(($filterType ?? 'semua') !== 'semua' && !in_array($filterType ?? '', ['harian', 'mingguan', 'bulanan']))
                    <button type="submit" class="px-3 py-2 text-xs font-bold bg-amber-400 text-slate-950 rounded-xl hover:bg-amber-500 transition">Filter</button>
                @endif
            </form>

            <a href="{{ route('admin.setoran.pdf', request()->query()) }}" target="_blank" class="px-4 py-2 bg-slate-900 hover:bg-slate-950 text-white font-bold text-xs rounded-xl shadow-xs transition-all flex items-center gap-1.5 cursor-pointer active:scale-95">
                <i class="fa-solid fa-file-pdf text-xs text-rose-400"></i>
                <span>Cetak Laporan PDF</span>
            </a>
        </div>
    </div>

    <script>
    function toggleFilterInputs() {
        const type = document.getElementById('filter_type').value;
        const dateContainer = document.getElementById('input-date-container');
        const monthContainer = document.getElementById('input-month-container');

        dateContainer.classList.add('hidden');
        monthContainer.classList.add('hidden');

        if (type === 'harian' || type === 'mingguan') {
            dateContainer.classList.remove('hidden');
        } else if (type === 'bulanan') {
            monthContainer.classList.remove('hidden');
        }

        document.getElementById('filter-form').submit();
    }
    </script>

    <!-- Summary Metrics Cards (3 Main Split Cards dengan Ikon & Warna Presisi) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card 1: Total Pendapatan Kotor (Brand Amber) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-2xl bg-amber-400 text-slate-950 shadow-xs flex items-center justify-center shrink-0">
                <i class="fa-solid fa-ticket text-lg"></i>
            </div>
            <div>
                <span class="text-[11px] text-slate-500 font-extrabold uppercase tracking-wider block">Total Pendapatan Tiket</span>
                <span class="text-xl lg:text-2xl font-black text-slate-900 leading-tight">Rp {{ number_format($totalPendapatanKotorSemua, 0, ',', '.') }}</span>
                <span class="text-[11px] text-slate-400 font-semibold block mt-0.5">Pendapatan Kotor Keseluruhan</span>
            </div>
        </div>

        <!-- Card 2: Bagian Supir (Indigo Accent) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-2xl bg-indigo-600 text-white shadow-xs flex items-center justify-center shrink-0">
                <i class="fa-solid fa-id-card text-lg"></i>
            </div>
            <div>
                <span class="text-[11px] text-indigo-900 font-extrabold uppercase tracking-wider block">Bagian Supir (Hak Supir)</span>
                <span class="text-xl lg:text-2xl font-black text-indigo-600 leading-tight">Rp {{ number_format($totalHakSupirSemua, 0, ',', '.') }}</span>
                <span class="text-[11px] text-slate-400 font-semibold block mt-0.5">Total Bagi Hasil Semua Supir</span>
            </div>
        </div>

        <!-- Card 3: Bagian Admin / Perusahaan (Emerald Green Accent) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-2xl bg-emerald-500 text-white shadow-xs flex items-center justify-center shrink-0">
                <i class="fa-solid fa-wallet text-lg"></i>
            </div>
            <div>
                <span class="text-[11px] text-emerald-900 font-extrabold uppercase tracking-wider block">Bagian Admin / Perusahaan</span>
                <span class="text-xl lg:text-2xl font-black text-emerald-600 leading-tight">Rp {{ number_format($totalSetoranWajibSemua, 0, ',', '.') }}</span>
                <span class="text-[11px] text-slate-400 font-semibold block mt-0.5">Setoran Bersih Masuk Kas</span>
            </div>
        </div>
    </div>

    <!-- Table Data Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <h2 class="text-base font-extrabold text-slate-900">
                Rincian Pembagian Per Jadwal Perjalanan
            </h2>
            <span class="text-xs font-bold text-slate-600 bg-slate-100 border border-slate-200 px-3 py-1 rounded-lg">
                Total: {{ $rekapJadwal->total() }} Jadwal
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/80 text-slate-700 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-4 rounded-l-xl">Rute & Tanggal</th>
                        <th class="py-3.5 px-4">Supir & Armada</th>
                        <th class="py-3.5 px-4 text-center">Penumpang</th>
                        <th class="py-3.5 px-4 text-right">Total Tiket</th>
                        <th class="py-3.5 px-4 text-right">Bagian Supir</th>
                        <th class="py-3.5 px-4 text-right">Bagian Admin</th>
                        <th class="py-3.5 px-4 text-center">Status Setor</th>
                        <th class="py-3.5 px-4 rounded-r-xl text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs md:text-sm">
                    @forelse($rekapJadwal as $r)
                        @php
                            $j = $r['jadwal'];
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Rute & Tanggal -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-1.5 font-bold text-slate-900">
                                    <span>{{ $j->asal }}</span>
                                    <i class="fa-solid fa-arrow-right text-[11px] text-amber-500"></i>
                                    <span>{{ $j->tujuan }}</span>
                                </div>
                                <div class="text-xs text-slate-500 font-medium mt-0.5">
                                    {{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }} &bull; {{ \Carbon\Carbon::parse($j->jam)->format('H:i') }} WIB
                                </div>
                            </td>

                            <!-- Supir & Armada -->
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                <div class="font-bold text-slate-900">{{ $j->sopir->nama ?? '-' }}</div>
                                <div class="text-xs text-slate-500 font-medium mt-0.5">
                                    {{ $j->armada->merk ?? '-' }} @if(isset($j->armada->plat_nomor))({{ $j->armada->plat_nomor }})@endif
                                </div>
                            </td>

                            <!-- Penumpang -->
                            <td class="py-4 px-4 text-center font-extrabold text-slate-900">
                                {{ $r['total_penumpang_lunas'] }} Orang
                            </td>

                            <!-- Total Tiket -->
                            <td class="py-4 px-4 text-right font-bold text-slate-800">
                                Rp {{ number_format($r['total_pendapatan_kotor'], 0, ',', '.') }}
                            </td>

                            <!-- Bagian Supir -->
                            <td class="py-4 px-4 text-right font-extrabold text-indigo-600">
                                Rp {{ number_format($r['total_hak_supir'], 0, ',', '.') }}
                            </td>

                            <!-- Bagian Admin -->
                            <td class="py-4 px-4 text-right font-extrabold text-emerald-600">
                                Rp {{ number_format($r['total_setoran_wajib'], 0, ',', '.') }}
                            </td>

                            <!-- Status Setor Indicator -->
                            <td class="py-4 px-4 text-center select-none">
                                @if($r['is_fully_setor'])
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Sudah Disetor</span>
                                    </span>
                                @elseif($r['total_setoran_wajib'] == 0)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold text-slate-500 bg-slate-100 border border-slate-200">
                                        <span>Tidak Ada Setoran</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Belum Disetor</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi Verifikasi -->
                            <td class="py-4 px-4 text-center">
                                @if($r['total_belum_setor'] > 0)
                                    <form action="{{ route('admin.setoran.verifikasi', $j->id_jadwal) }}" method="POST" onsubmit="return confirm('Verifikasi penerimaan setoran bagian admin sebesar Rp {{ number_format($r['total_belum_setor'], 0, ',', '.') }} dari supir {{ $j->sopir->nama ?? '' }}?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer mx-auto active:scale-95">
                                            <i class="fa-solid fa-circle-check text-[11px]"></i>
                                            <span>Verifikasi</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs font-bold text-slate-400 flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-check-double text-emerald-500 text-xs"></i>
                                        <span>Terverifikasi</span>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-500 font-medium text-xs sm:text-sm">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-file-invoice-dollar text-3xl text-slate-300"></i>
                                    <p class="font-bold text-slate-700">Belum ada data perjalanan untuk laporan pembagian hasil.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($rekapJadwal->count() > 0)
                <tfoot class="bg-slate-900 text-white text-xs md:text-sm font-bold">
                    <tr>
                        <td colspan="3" class="p-4 text-right font-extrabold uppercase text-[11px] tracking-wider text-slate-300">Total Keseluruhan:</td>
                        <td class="p-4 text-right font-black text-amber-400">Rp {{ number_format($totalPendapatanKotorSemua, 0, ',', '.') }}</td>
                        <td class="p-4 text-right font-black text-indigo-300">Rp {{ number_format($totalHakSupirSemua, 0, ',', '.') }}</td>
                        <td class="p-4 text-right font-black text-emerald-400">Rp {{ number_format($totalSetoranWajibSemua, 0, ',', '.') }}</td>
                        <td colspan="2" class="p-4 text-center text-xs text-slate-300 font-semibold">Belum Disetor: <span class="font-black text-amber-400">Rp {{ number_format($totalBelumSetorSemua, 0, ',', '.') }}</span></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        @if($rekapJadwal->hasPages())
            <div class="mt-5 pt-4 border-t border-slate-100">
                {{ $rekapJadwal->links() }}
            </div>
        @endif
    </div>
</div>
@endsection