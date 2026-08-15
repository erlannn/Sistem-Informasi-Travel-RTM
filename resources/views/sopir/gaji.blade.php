@extends('layouts.sopir')

@section('title', 'Informasi Gaji & Bagi Hasil - CV RTM Travel')
@section('page_title', 'Informasi Gaji & Setoran')

@section('content')
<div class="space-y-6">

    <!-- Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs no-print">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1.5">
                    Gaji & Pembagian Hasil
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Rincian perolehan gaji Anda dan jumlah setoran wajib ke kasir kantor per bulan</p>
            </div>

            <!-- Periode Form & Cetak -->
            <form action="{{ route('sopir.gaji') }}" method="GET" class="flex items-center gap-2 shrink-0">
                <select name="period" id="period" onchange="this.form.submit()" 
                    class="bg-slate-50 border border-slate-300 text-xs font-bold text-slate-800 rounded-xl px-3.5 py-2.5 outline-none focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all cursor-pointer">
                    @foreach($periods as $val => $label)
                        <option value="{{ $val }}" {{ $selectedPeriod == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <button type="button" onclick="window.print()" class="bg-slate-900 hover:bg-slate-950 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition-all flex items-center gap-1.5 cursor-pointer active:scale-95">
                    <i class="fa-solid fa-print text-xs"></i>
                    <span>Cetak Slip</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 3 Ringkasan Utama Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 no-print">
        <!-- Kartu 1: Total Uang Diterima dari Penumpang -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-amber-400 text-slate-950 shadow-xs flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-money-bill-wave text-lg"></i>
                </div>
                <div>
                    <span class="text-[11px] text-slate-500 font-extrabold uppercase tracking-wider block">Uang Diterima dari Penumpang</span>
                    <span class="text-xl lg:text-2xl font-black text-slate-900 leading-tight block mt-0.5">Rp {{ number_format($totalTunaiDiterima, 0, ',', '.') }}</span>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 font-semibold mt-3 border-t border-slate-100 pt-2.5">
                Total akumulasi uang tunai yang terkumpul dari seluruh penumpang.
            </p>
        </div>

        <!-- Kartu 2: Gaji / Bagian Sopir -->
        <div class="bg-white p-6 rounded-3xl border-2 border-emerald-500/30 shadow-xs bg-emerald-50/20 flex flex-col justify-between">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-emerald-500 text-white shadow-xs flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-wallet text-lg"></i>
                </div>
                <div>
                    <span class="text-[11px] text-emerald-900 font-extrabold uppercase tracking-wider block">Gaji / Hak Anda (Sopir)</span>
                    <span class="text-xl lg:text-2xl font-black text-emerald-600 leading-tight block mt-0.5">Rp {{ number_format($totalGaji, 0, ',', '.') }}</span>
                </div>
            </div>
            <p class="text-[11px] text-emerald-800 font-bold mt-3 border-t border-emerald-100/80 pt-2.5 flex items-center gap-1">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>Uang bersih hak Anda dari total {{ $totalPenumpang }} penumpang selesai.</span>
            </p>
        </div>

        <!-- Kartu 3: Wajib Disetor ke Perusahaan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-indigo-600 text-white shadow-xs flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-building-columns text-lg"></i>
                </div>
                <div>
                    <span class="text-[11px] text-slate-500 font-extrabold uppercase tracking-wider block">Wajib Disetor ke Admin Kantor</span>
                    <span class="text-xl lg:text-2xl font-black text-indigo-600 leading-tight block mt-0.5">Rp {{ number_format($totalSetoranPerusahaan, 0, ',', '.') }}</span>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 font-semibold mt-3 border-t border-slate-100 pt-2.5">
                Sisa fisik uang tunai yang harus diserahkan ke kasir kantor.
            </p>
        </div>
    </div>

    <!-- Printable Container for Slip -->
    <div id="printable-slip" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <!-- Header Slip Print -->
        <div class="bg-slate-950 text-white p-6 flex justify-between items-center border-b border-slate-800">
            <div>
                <span class="text-[10px] text-amber-400 font-extrabold uppercase tracking-widest block">SLIP GAJI & BAGI HASIL SOPIR</span>
                <h2 class="text-lg sm:text-xl font-extrabold text-white mt-0.5">CV. TRAVEL RTM</h2>
            </div>
            <div class="text-right">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Periode Perjalanan</span>
                <span class="text-xs sm:text-sm font-extrabold text-amber-400 block mt-0.5">{{ $periods[$selectedPeriod] ?? $selectedPeriod }}</span>
            </div>
        </div>

        <div class="p-6 sm:p-7 space-y-6">
            <!-- Informasi Sopir -->
            <div class="bg-slate-50/80 p-4 sm:p-5 rounded-2xl border border-slate-200/80 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs md:text-sm">
                <div>
                    <span class="text-slate-400 font-bold block text-[10px] uppercase mb-0.5">Nama Sopir / Pengemudi:</span>
                    <span class="font-extrabold text-slate-900 text-sm md:text-base">{{ $sopir->nama }}</span>
                </div>
                <div>
                    <span class="text-slate-400 font-bold block text-[10px] uppercase mb-0.5">No. Handphone / WhatsApp:</span>
                    <span class="font-bold text-slate-800 text-sm md:text-base">{{ $sopir->no_hp }}</span>
                </div>
            </div>

            <!-- Tabel Rincian Per Rute -->
            <div class="space-y-3">
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">
                    Rincian Gaji Per Rute Perjalanan
                </h3>

                <div class="overflow-x-auto border border-slate-200/80 rounded-2xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100/80 text-slate-700 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200">
                                <th class="py-3 px-4">Rute Perjalanan</th>
                                <th class="py-3 px-4 text-center">Jumlah Penumpang</th>
                                <th class="py-3 px-4 text-right">Gaji Per Penumpang</th>
                                <th class="py-3 px-4 text-right">Total Gaji Anda</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs md:text-sm">
                            @forelse($ruteBreakdown as $rb)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-slate-900">{{ $rb['rute'] }}</td>
                                    <td class="py-3.5 px-4 text-center font-extrabold text-slate-900">{{ $rb['total_penumpang'] }} Orang</td>
                                    <td class="py-3.5 px-4 text-right font-semibold text-slate-700">Rp {{ number_format($rb['bagi_hasil_per_pax'], 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-4 text-right font-extrabold text-emerald-600">Rp {{ number_format($rb['total_bagi_hasil'], 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-slate-500 font-medium text-xs sm:text-sm">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <i class="fa-solid fa-calendar-xmark text-3xl text-slate-300"></i>
                                            <p class="font-bold text-slate-700">Belum ada data perjalanan yang selesai pada periode ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if(count($ruteBreakdown) > 0)
                        <tfoot class="bg-slate-900 text-white text-xs md:text-sm font-bold">
                            <tr>
                                <td colspan="2" class="p-4 text-slate-300 text-xs uppercase tracking-wider font-extrabold">TOTAL KESELURUHAN:</td>
                                <td class="p-4 text-center text-amber-400 font-extrabold">{{ $totalPenumpang }} Penumpang</td>
                                <td class="p-4 text-right text-emerald-400 text-sm md:text-base font-black">Rp {{ number_format($totalGaji, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Perhitungan Setoran Sederhana -->
            <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3">
                <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">
                    Ringkasan Penyetoran Uang ke Admin Kantor
                </h4>
                <div class="space-y-2 text-xs md:text-sm font-semibold">
                    <div class="flex justify-between items-center py-1.5 border-b border-slate-200/60">
                        <span class="text-slate-600">Total Uang Diterima dari Penumpang:</span>
                        <span class="text-slate-900 font-bold">Rp {{ number_format($totalTunaiDiterima, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-slate-200/60">
                        <span class="text-slate-600">Diambil untuk Gaji Anda (Sopir):</span>
                        <span class="text-emerald-600 font-bold">- Rp {{ number_format($totalGaji, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 text-sm md:text-base font-black">
                        <span class="text-slate-900">Uang yang Diserahkan ke Admin Kantor:</span>
                        <span class="text-indigo-600 font-black">Rp {{ number_format($totalSetoranPerusahaan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Tanda Tangan Cetak (Khusus Print) -->
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

    <!-- Navigation Back Button -->
    <div class="pt-2 no-print">
        <a href="{{ route('sopir.dashboard') }}" class="w-full inline-block text-center bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 font-bold py-3 rounded-2xl text-xs sm:text-sm active:scale-[0.99] transition-all">
            &larr; Kembali ke Dashboard Sopir
        </a>
    </div>

</div>
@endsection