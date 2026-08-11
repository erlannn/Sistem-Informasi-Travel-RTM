@extends('layouts.admin')

@section('title', 'Laporan Pembagian Hasil - CV Travel RTM')
@section('page_title', 'Laporan Pembagian Hasil Supir & Admin')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-extrabold uppercase tracking-wider">
                Laporan Keuangan
            </span>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Laporan Pembagian Hasil Supir & Admin
            </h1>
            <p class="text-xs text-slate-500 font-medium">Rincian pembagian pendapatan tiket antara hak supir dan bagian kas admin/perusahaan.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('admin.setoran.index') }}" method="GET" class="flex items-center gap-2">
                <select name="period" onchange="this.form.submit()" class="px-3 py-2 text-xs font-bold bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:ring-1 focus:ring-brand-500 cursor-pointer">
                    <option value="">Semua Periode</option>
                    @foreach($periods as $val => $label)
                        <option value="{{ $val }}" {{ $selectedPeriod == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
            <button onclick="window.print()" class="px-4 py-2 bg-slate-900 hover:bg-slate-950 text-white font-extrabold text-xs rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-print"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Summary Metrics Cards (3 Main Split Cards) -->
    @php
        $totalPendapatanKotorSemua = $rekapJadwal->sum('total_pendapatan_kotor');
        $totalHakSupirSemua = $rekapJadwal->sum('total_hak_supir');
        $totalSetoranWajibSemua = $rekapJadwal->sum('total_setoran_wajib');
        $totalSudahSetorSemua = $rekapJadwal->sum('total_sudah_setor');
        $totalBelumSetorSemua = $rekapJadwal->sum('total_belum_setor');
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card 1: Total Pendapatan Kotor -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4 border-l-4 border-l-amber-500">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 text-2xl font-bold shrink-0">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">TOTAL PENDAPATAN TIKET</span>
                <span class="text-2xl font-black text-slate-900">Rp {{ number_format($totalPendapatanKotorSemua, 0, ',', '.') }}</span>
                <span class="text-[11px] text-slate-500 font-medium block mt-0.5">Pendapatan Kotor Keseluruhan</span>
            </div>
        </div>

        <!-- Card 2: Bagian Supir -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4 border-l-4 border-l-blue-500">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-200 flex items-center justify-center text-blue-600 text-2xl font-bold shrink-0">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">BAGIAN SUPIR (HAK SUPIR)</span>
                <span class="text-2xl font-black text-blue-600">Rp {{ number_format($totalHakSupirSemua, 0, ',', '.') }}</span>
                <span class="text-[11px] text-blue-700/80 font-semibold block mt-0.5">Total Bagi Hasil Semua Supir</span>
            </div>
        </div>

        <!-- Card 3: Bagian Admin / Perusahaan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4 border-l-4 border-l-emerald-500">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 text-2xl font-bold shrink-0">
                <i class="fa-solid fa-building-columns"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">BAGIAN ADMIN / PERUSAHAAN</span>
                <span class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalSetoranWajibSemua, 0, ',', '.') }}</span>
                <span class="text-[11px] text-emerald-700/80 font-semibold block mt-0.5">Setoran Bersih Masuk Kas</span>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-extrabold text-slate-900">
                Rincian Pembagian Per Jadwal Perjalanan
            </h2>
            <span class="text-xs font-semibold text-slate-500">Total: {{ $rekapJadwal->count() }} Jadwal</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-100 text-slate-600 uppercase text-[10px] font-extrabold border-b border-slate-200">
                    <tr>
                        <th class="p-3.5 rounded-l-xl">Rute & Tanggal</th>
                        <th class="p-3.5">Supir & Armada</th>
                        <th class="p-3.5 text-center">Penumpang</th>
                        <th class="p-3.5 text-right">Total Tiket</th>
                        <th class="p-3.5 text-right">Bagian Supir</th>
                        <th class="p-3.5 text-right">Bagian Admin</th>
                        <th class="p-3.5 text-center">Status Setor</th>
                        <th class="p-3.5 rounded-r-xl text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rekapJadwal as $r)
                        @php
                            $j = $r['jadwal'];
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5">
                                <div class="font-extrabold text-slate-900">{{ $j->asal }} &rarr; {{ $j->tujuan }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">
                                    {{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }} &bull; {{ \Carbon\Carbon::parse($j->jam)->format('H:i') }} WIB
                                </div>
                            </td>
                            <td class="p-3.5 font-medium text-slate-600">
                                <div class="font-bold text-slate-800">{{ $j->sopir->nama ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400">{{ $j->armada->merk ?? '-' }} ({{ $j->armada->plat_nomor ?? '-' }})</div>
                            </td>
                            <td class="p-3.5 text-center font-extrabold text-slate-900">
                                {{ $r['total_penumpang_lunas'] }} Orang
                            </td>
                            <td class="p-3.5 text-right font-bold text-slate-800">
                                Rp {{ number_format($r['total_pendapatan_kotor'], 0, ',', '.') }}
                            </td>
                            <td class="p-3.5 text-right font-extrabold text-blue-600">
                                Rp {{ number_format($r['total_hak_supir'], 0, ',', '.') }}
                            </td>
                            <td class="p-3.5 text-right font-extrabold text-emerald-600">
                                Rp {{ number_format($r['total_setoran_wajib'], 0, ',', '.') }}
                            </td>
                            <td class="p-3.5 text-center">
                                @if($r['is_fully_setor'])
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Sudah Disetor
                                    </span>
                                @elseif($r['total_setoran_wajib'] == 0)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        Tidak Ada Setoran
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        Belum Disetor
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 text-center">
                                @if($r['total_belum_setor'] > 0)
                                    <form action="{{ route('admin.setoran.verifikasi', $j->id_jadwal) }}" method="POST" onsubmit="return confirm('Verifikasi penerimaan setoran bagian admin sebesar Rp {{ number_format($r['total_belum_setor'], 0, ',', '.') }} dari supir {{ $j->sopir->nama ?? '' }}?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-[11px] rounded-xl shadow-xs transition flex items-center justify-center gap-1 cursor-pointer mx-auto">
                                            <i class="fa-solid fa-square-check"></i> Verifikasi
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[11px] font-bold text-slate-400 flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-check-double text-emerald-500"></i> Terverifikasi
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400 font-medium">
                                Belum ada data perjalanan untuk laporan pembagian hasil.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($rekapJadwal->count() > 0)
                <tfoot class="bg-slate-900 text-white text-xs font-bold">
                    <tr>
                        <td colspan="3" class="p-3.5 text-right font-black uppercase text-[10px] tracking-wider text-slate-300">TOTAL KESELURUHAN:</td>
                        <td class="p-3.5 text-right font-black text-amber-400">Rp {{ number_format($totalPendapatanKotorSemua, 0, ',', '.') }}</td>
                        <td class="p-3.5 text-right font-black text-blue-400">Rp {{ number_format($totalHakSupirSemua, 0, ',', '.') }}</td>
                        <td class="p-3.5 text-right font-black text-emerald-400">Rp {{ number_format($totalSetoranWajibSemua, 0, ',', '.') }}</td>
                        <td colspan="2" class="p-3.5 text-center text-[10px] text-slate-400">Belum Disetor: Rp {{ number_format($totalBelumSetorSemua, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
