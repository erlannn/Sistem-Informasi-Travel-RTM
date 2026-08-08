@extends('layouts.sopir')

@section('title', 'Informasi Gaji Sopir - CV RTM Travel')
@section('page_title', 'Rincian Slip Gaji')

@section('content')
<div class="space-y-4 no-print">
    <!-- Header -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-md">
        <h1 class="text-lg font-black text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-wallet text-amber-500"></i> Informasi Gaji
        </h1>
        <p class="text-[11px] text-slate-500 mt-0.5 font-semibold">Pantau rincian gaji bulanan, komisi manifest, dan total pendapatan Anda.</p>
    </div>

    <!-- Period Selection Form -->
    <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-md">
        <form action="{{ route('sopir.gaji') }}" method="GET" class="space-y-2">
            <label for="period" class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">PILIH PERIODE GAJI</label>
            <div class="flex gap-2">
                <select name="period" id="period" onchange="this.form.submit()" 
                    class="flex-grow bg-slate-50 border border-slate-200 text-xs rounded-xl p-2.5 outline-none font-bold text-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @foreach($periods as $val => $label)
                        <option value="{{ $val }}" {{ $selectedPeriod == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                
                <button type="button" onclick="window.print()" class="bg-slate-900 hover:bg-slate-950 text-white font-extrabold text-xs px-4 rounded-xl transition-colors shrink-0 flex items-center gap-1.5 shadow-sm cursor-pointer">
                    <i class="fa-solid fa-print"></i> Cetak
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Pay Slip Content Container (Wrapped in printable-slip for custom print layout) -->
<div id="printable-slip" class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden relative mt-4">
    <!-- Watermark / Background Texture -->
    <div class="absolute inset-0 opacity-[0.02] bg-[radial-gradient(#000000_1px,transparent_1px)] [background-size:12px_12px] pointer-events-none"></div>

    <!-- Header Slip -->
    <div class="bg-slate-950 text-white p-5 border-b border-slate-900 relative">
        <div class="flex justify-between items-center">
            <div>
                <span class="text-[9px] text-amber-500 font-extrabold uppercase tracking-widest leading-none block">SLIP GAJI RESMI</span>
                <h2 class="text-base font-black mt-1 leading-none">CV RTM Travel Family</h2>
            </div>
            <div class="text-right shrink-0">
                <span class="text-[10px] text-slate-400 font-bold block">Periode</span>
                <span class="text-xs font-extrabold text-white block">{{ $periods[$selectedPeriod] ?? $selectedPeriod }}</span>
            </div>
        </div>
    </div>

    <!-- Slip Details Body -->
    <div class="p-5 space-y-5">
        
        <!-- Driver Profile Info -->
        <div class="bg-slate-50 border border-slate-200/60 p-4 rounded-2xl space-y-2.5">
            <div class="flex justify-between text-xs font-semibold">
                <span class="text-slate-400">Nama Sopir</span>
                <span class="text-slate-800 font-black">{{ $sopir->nama }}</span>
            </div>
            <div class="flex justify-between text-xs font-semibold">
                <span class="text-slate-400">No. HP / WA</span>
                <span class="text-slate-800 font-bold">{{ $sopir->no_hp }}</span>
            </div>
            <div class="flex justify-between text-xs font-semibold">
                <span class="text-slate-400">Status Portal</span>
                <span class="text-emerald-600 font-extrabold flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Terverifikasi</span>
            </div>
        </div>

        <!-- Salary Breakdown -->
        <div class="space-y-3">
            <h3 class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">RINCIAN PENDAPATAN & GAJI</h3>
            
            <div class="space-y-2.5 text-xs">
                <!-- Gaji Pokok -->
                <div class="flex justify-between items-center py-1 border-b border-slate-100 font-semibold">
                    <span class="text-slate-500">Gaji Pokok Bulanan</span>
                    <span class="text-slate-800">Rp {{ number_format($baseSalary, 0, ',', '.') }}</span>
                </div>

                <!-- Total Penumpang -->
                <div class="flex justify-between items-center py-1 border-b border-slate-100 font-semibold">
                    <span class="text-slate-500">Total Penumpang Selesai</span>
                    <span class="text-slate-800">{{ $totalPenumpang }} Orang</span>
                </div>

                <!-- Tarif per penumpang / Komisi -->
                <div class="flex justify-between items-center py-1 border-b border-slate-100 font-semibold">
                    <span class="text-slate-500">Tarif per penumpang (Komisi)</span>
                    <span class="text-slate-800">Rp {{ number_format($tarifPerPenumpang, 0, ',', '.') }}</span>
                </div>

                <!-- Total Komisi -->
                <div class="flex justify-between items-center py-1 border-b border-slate-100 font-semibold">
                    <span class="text-slate-500">Akumulasi Komisi</span>
                    <span class="text-slate-800">Rp {{ number_format($totalKomisi, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Total Gaji Netto -->
        <div class="bg-amber-500/10 border border-amber-500/20 p-4 rounded-2xl flex justify-between items-center">
            <div>
                <span class="text-[9px] text-amber-700 font-extrabold uppercase tracking-wider block">Total Gaji Dibukukan</span>
                <span class="text-[10px] text-slate-500 font-medium block mt-0.5">(Gaji Pokok + Komisi)</span>
            </div>
            <div class="text-right">
                <span class="text-lg font-black text-amber-700">Rp {{ number_format($totalGaji, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Cash Collected from Passenger (COD) Info -->
        <div class="border-t border-dashed border-slate-200 pt-4 space-y-3">
            <h3 class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">PEMBAYARAN LANGSUNG DARI PENUMPANG (COD)</h3>
            
            <div class="bg-emerald-50 border border-emerald-200/80 p-4 rounded-2xl space-y-2 text-xs">
                <div class="flex justify-between items-center font-semibold">
                    <span class="text-slate-600">Total Pembayaran Tiket Diterima</span>
                    <span class="text-emerald-700 font-black">Rp {{ number_format($totalTunaiDiterima, 0, ',', '.') }}</span>
                </div>
                <p class="text-[10px] text-slate-500 leading-relaxed font-medium mt-1">
                    *Uang ini dibayarkan tunai oleh penumpang langsung kepada Anda setelah perjalanan selesai dan tidak termasuk dalam potongan gaji bulanan dari perusahaan.
                </p>
            </div>
        </div>

        <!-- Footer Signatures (Aesthetic for printing) -->
        <div class="hidden print:block pt-8 mt-12 grid grid-cols-2 text-center text-xs">
            <div>
                <p class="font-medium text-slate-400">Driver Penerima</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-800 border-t border-slate-200 pt-1 w-36 mx-auto">{{ $sopir->nama }}</p>
            </div>
            <div>
                <p class="font-medium text-slate-400">Keuangan CV RTM</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-800 border-t border-slate-200 pt-1 w-36 mx-auto">Admin RTM Travel</p>
            </div>
        </div>
    </div>
</div>

<div class="pt-2 no-print">
    <a href="{{ route('sopir.dashboard') }}" class="w-full inline-block text-center bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 font-bold py-3 rounded-2xl text-xs transition-colors">
        Kembali ke Dashboard
    </a>
</div>
@endsection
