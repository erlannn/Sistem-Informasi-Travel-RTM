@extends('layouts.sopir')

@section('title', 'Informasi Gaji & Bagi Hasil - CV RTM Travel')
@section('page_title', 'Informasi Gaji & Setoran')

@section('content')
<div class="space-y-5 no-print">
    <!-- Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-xs font-bold uppercase tracking-wider">
                    Informasi Pendapatan
                </span>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 mt-1">
                    Gaji & Pembagian Hasil
                </h1>
                <p class="text-xs text-slate-500 font-medium">Rincian gaji Anda dan uang yang harus disetorkan ke kantor per bulan.</p>
            </div>

            <!-- Periode Form & Cetak -->
            <form action="{{ route('sopir.gaji') }}" method="GET" class="flex items-center gap-2">
                <select name="period" id="period" onchange="this.form.submit()" 
                    class="bg-slate-100 border border-slate-200 text-xs font-extrabold text-slate-800 rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-amber-500 cursor-pointer">
                    @foreach($periods as $val => $label)
                        <option value="{{ $val }}" {{ $selectedPeriod == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <button type="button" onclick="window.print()" class="bg-slate-900 hover:bg-slate-950 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-print"></i> Cetak
                </button>
            </form>
        </div>
    </div>
</div>

<!-- 3 Ringkasan Utama (Tampilan Besar & Sederhana untuk Usia 30+) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
    <!-- Kartu 1: Total Uang Diterima dari Penumpang -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl font-bold shrink-0">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <span class="text-xs text-slate-500 font-bold block">Uang Diterima dari Penumpang</span>
                <span class="text-xl font-black text-slate-900 mt-0.5 block">Rp {{ number_format($totalTunaiDiterima, 0, ',', '.') }}</span>
            </div>
        </div>
        <p class="text-[11px] text-slate-400 font-medium mt-3 border-t border-slate-100 pt-2">
            Total uang tunai yang terkumpul dari seluruh penumpang.
        </p>
    </div>

    <!-- Kartu 2: Gaji / Bagian Anda -->
    <div class="bg-white p-5 rounded-3xl border-2 border-emerald-500/30 shadow-sm bg-emerald-50/20">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl font-bold shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <span class="text-xs text-emerald-800 font-extrabold block">Gaji / Hak Anda (Sopir)</span>
                <span class="text-2xl font-black text-emerald-600 mt-0.5 block">Rp {{ number_format($totalGaji, 0, ',', '.') }}</span>
            </div>
        </div>
        <p class="text-[11px] text-emerald-700 font-semibold mt-3 border-t border-emerald-100 pt-2">
            ✅ Uang bersih hak Anda dari {{ $totalPenumpang }} penumpang selesai.
        </p>
    </div>

    <!-- Kartu 3: Wajib Disetor ke Perusahaan -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl font-bold shrink-0">
                <i class="fa-solid fa-building"></i>
            </div>
            <div>
                <span class="text-xs text-slate-500 font-bold block">Wajib Disetor ke Admin Kantor</span>
                <span class="text-xl font-black text-blue-700 mt-0.5 block">Rp {{ number_format($totalSetoranPerusahaan, 0, ',', '.') }}</span>
            </div>
        </div>
        <p class="text-[11px] text-slate-400 font-medium mt-3 border-t border-slate-100 pt-2">
            Sisa uang fisik yang diserahkan ke kasir kantor.
        </p>
    </div>
</div>

<!-- Printable Container for Slip -->
<div id="printable-slip" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden mt-5">
    <!-- Header Slip Print -->
    <div class="bg-slate-900 text-white p-5 flex justify-between items-center">
        <div>
            <span class="text-[10px] text-amber-400 font-extrabold uppercase tracking-wider block">SLIP GAJI & BAGI HASIL SOPIR</span>
            <h2 class="text-base font-black text-white mt-0.5">CV. TRAVEL RTM</h2>
        </div>
        <div class="text-right">
            <span class="text-xs text-slate-400 font-bold block">Periode Perjalanan</span>
            <span class="text-xs font-black text-amber-400 block">{{ $periods[$selectedPeriod] ?? $selectedPeriod }}</span>
        </div>
    </div>

    <div class="p-6 space-y-6">
        <!-- Informasi Sopir -->
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
            <div>
                <span class="text-slate-400 font-medium block">Nama Sopir:</span>
                <span class="font-extrabold text-slate-900 text-sm">{{ $sopir->nama }}</span>
            </div>
            <div>
                <span class="text-slate-400 font-medium block">No. HP / WA:</span>
                <span class="font-bold text-slate-800 text-sm">{{ $sopir->no_hp }}</span>
            </div>
        </div>

        <!-- Tabel Rincian Per Rute -->
        <div class="space-y-3">
            <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                Rincian Gaji Per Rute Perjalanan
            </h3>

            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-100 text-slate-700 uppercase text-[11px] font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="p-3.5">Rute Perjalanan</th>
                            <th class="p-3.5 text-center">Jumlah Penumpang</th>
                            <th class="p-3.5 text-right">Gaji Per Penumpang</th>
                            <th class="p-3.5 text-right">Total Gaji Anda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($ruteBreakdown as $rb)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 font-bold text-slate-900 text-xs sm:text-sm">{{ $rb['rute'] }}</td>
                                <td class="p-3.5 text-center font-bold text-slate-800 text-xs sm:text-sm">{{ $rb['total_penumpang'] }} Orang</td>
                                <td class="p-3.5 text-right font-semibold text-slate-600 text-xs sm:text-sm">Rp {{ number_format($rb['bagi_hasil_per_pax'], 0, ',', '.') }}</td>
                                <td class="p-3.5 text-right font-black text-emerald-600 text-xs sm:text-sm">Rp {{ number_format($rb['total_bagi_hasil'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-400 font-medium">
                                    Belum ada data perjalanan yang selesai pada bulan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if(count($ruteBreakdown) > 0)
                    <tfoot class="bg-slate-50 font-bold border-t border-slate-200">
                        <tr>
                            <td colspan="2" class="p-3.5 text-slate-800 text-xs sm:text-sm font-extrabold">TOTAL KESELURUHAN:</td>
                            <td class="p-3.5 text-center text-slate-600 text-xs font-bold">{{ $totalPenumpang }} Penumpang</td>
                            <td class="p-3.5 text-right text-emerald-600 text-sm sm:text-base font-black">Rp {{ number_format($totalGaji, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <!-- Perhitungan Setoran Sederhana -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-3">
            <h4 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                Ringkasan Penyetoran Uang ke Admin Kantor
            </h4>
            <div class="space-y-2 text-xs font-semibold">
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                    <span class="text-slate-600">Total Uang Diterima dari Penumpang:</span>
                    <span class="text-slate-900 font-bold">Rp {{ number_format($totalTunaiDiterima, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                    <span class="text-slate-600">Diambil untuk Gaji Anda (Sopir):</span>
                    <span class="text-emerald-600 font-bold">- Rp {{ number_format($totalGaji, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center pt-1 text-sm font-black">
                    <span class="text-slate-900">Uang yang Diserahkan ke Admin:</span>
                    <span class="text-blue-700 font-black">Rp {{ number_format($totalSetoranPerusahaan, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Tanda Tangan Cetak -->
        <div class="hidden print:grid grid-cols-2 text-center text-xs pt-10 mt-8 border-t border-slate-200">
            <div>
                <p class="font-medium text-slate-500">Sopir / Pengemudi</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-900 border-t border-slate-300 pt-1 w-40 mx-auto">{{ $sopir->nama }}</p>
            </div>
            <div>
                <p class="font-medium text-slate-500">Kasir / Admin CV. Travel RTM</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-900 border-t border-slate-300 pt-1 w-40 mx-auto">Admin RTM</p>
            </div>
        </div>
    </div>
</div>

<div class="pt-4 no-print">
    <a href="{{ route('sopir.dashboard') }}" class="w-full inline-block text-center bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 font-bold py-3 rounded-2xl text-xs transition-colors">
        &larr; Kembali ke Dashboard Sopir
    </a>
</div>
@endsection
