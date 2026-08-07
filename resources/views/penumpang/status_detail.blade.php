@extends('layouts.penumpang')

@section('title', 'Detail Pemesanan Tiket - RTM Family')

@section('content')
<style>
    /* Print Layout Configuration */
    @media print {
        header, footer, .no-print {
            display: none !important;
        }
        body {
            background-color: white !important;
            color: black !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .print-container {
            max-width: 100% !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }
        .ticket-voucher {
            border: 2px dashed #000 !important;
            box-shadow: none !important;
            margin: 0 !important;
            background: white !important;
        }
    }
</style>

@php
    $kode = 'RTM' . sprintf('%04d', $pemesanan->id_pemesanan);
@endphp

<div class="py-8 bg-slate-50 md:py-12 print-container">
    <div class="px-4 mx-auto max-w-3xl sm:px-6 lg:px-8">

        <!-- Header Title (no-print) -->
        <div class="text-center mb-8 no-print">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Detail Status Pemesanan</h1>
            <p class="mt-1 text-sm text-slate-500">Gunakan tiket ini sebagai tanda bukti pemesanan saat keberangkatan</p>
        </div>

        <!-- Ticket Voucher Card (Boarding Pass aesthetic) -->
        <div class="ticket-voucher bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden relative mb-8 transition-all hover:shadow-lg">
            
            <!-- Side Cutout Circles -->
            <div class="hidden md:block absolute top-[52%] -left-4 w-8 h-8 rounded-full bg-slate-50 border-r border-slate-200/80 z-20"></div>
            <div class="hidden md:block absolute top-[52%] -right-4 w-8 h-8 rounded-full bg-slate-50 border-l border-slate-200/80 z-20"></div>

            <!-- Top Header Segment: Brand & Status -->
            <div class="bg-slate-950 text-white px-6 py-5 md:px-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-900">
                <div class="flex items-center gap-2">
                    <!-- Mini Logo Emblem -->
                    <div class="flex items-center bg-slate-900 border border-slate-800 px-3 py-1.5 rounded-lg">
                        <span class="text-sm font-black tracking-tighter italic text-white">
                            R<span class="text-gold-500">T</span>M
                        </span>
                        <span class="text-[10px] font-bold italic tracking-wide text-white ml-1">Family</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-2.5">
                    <span class="text-xs text-slate-400 font-semibold">Status:</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-gold-400 bg-slate-900 border border-gold-500/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-gold-400 animate-pulse"></span>
                        {{ $pemesanan->status }}
                    </span>
                </div>
            </div>

            <!-- Upper Ticket Body: Primary Info -->
            <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-dashed border-slate-200 relative">
                
                <!-- Col 1: Journey Summary -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Rincian Perjalanan</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-400">Dari</span>
                                <span class="text-base font-extrabold text-slate-900">{{ $pemesanan->jadwal->asal ?? 'Sijunjung' }}</span>
                            </div>
                            <div class="text-gold-500 font-bold text-lg">&rarr;</div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-400">Ke</span>
                                <span class="text-base font-extrabold text-slate-900">{{ $pemesanan->jadwal->tujuan ?? 'Padang' }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div>
                                <span class="text-xs text-slate-400 block">Tanggal</span>
                                <span class="text-sm font-bold text-slate-800">{{ $pemesanan->jadwal->tanggal ?? date('Y-m-d') }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-slate-400 block">Jam Berangkat</span>
                                <span class="text-sm font-bold text-slate-800">{{ $pemesanan->jadwal->jam ? \Carbon\Carbon::parse($pemesanan->jadwal->jam)->format('H.i') . ' WIB' : '05.00 WIB' }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-xs text-slate-400 block">Armada</span>
                                <span class="text-sm font-bold text-slate-800">{{ $pemesanan->jadwal->armada->merk ?? 'Toyota Avanza' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-slate-400 block">No. Kursi</span>
                                <span class="text-sm font-bold text-gold-600">Kursi {{ $pemesanan->kursi->nomor_kursi ?? '1' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Passenger Details -->
                <div class="space-y-4 md:border-l md:border-slate-100 md:pl-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Rincian Penumpang</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-xs text-slate-400 block">Nama Penumpang</span>
                            <span class="text-sm font-bold text-slate-800">{{ $pemesanan->penumpang->nama ?? Auth::user()->name }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Alamat Email</span>
                            <span class="text-sm font-semibold text-slate-600">{{ $pemesanan->penumpang->email ?? Auth::user()->email }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Nomor Telepon</span>
                            <span class="text-sm font-semibold text-slate-600">{{ $pemesanan->penumpang->no_hp ?? '-' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Lower Ticket Body: Financial details and Barcode -->
            <div class="p-6 md:p-8 bg-slate-50/50 grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                
                <!-- Price info (7 Cols) -->
                <div class="md:col-span-7 space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Detail Harga & Pembayaran</h3>
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center text-xs text-slate-500">
                            <span>Harga Tiket (1 Penumpang)</span>
                            <span>Rp {{ number_format($pemesanan->jadwal->harga ?? 70000, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm font-bold text-slate-900 border-t border-dashed border-slate-200 pt-2">
                            <span>Total Pembayaran</span>
                            <span class="text-base text-gold-600">Rp {{ number_format($pemesanan->jadwal->harga ?? 70000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <!-- Small note -->
                    <p class="text-[10px] text-slate-400 italic">Pembayaran dilakukan secara tunai di lokasi keberangkatan saat menaiki armada travel RTM.</p>
                </div>

                <!-- Digital Ticket Barcode concept -->
                <div class="md:col-span-5 flex flex-col items-center justify-center border-t md:border-t-0 md:border-l border-slate-200/80 pt-6 md:pt-0 md:pl-6">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60 shadow-xs flex flex-col items-center gap-1.5">
                        <!-- Barcode Lines -->
                        <div class="flex items-center gap-[2.5px] h-9 w-[150px] overflow-hidden select-none">
                            <span class="block bg-slate-950 w-[2px] h-full"></span>
                            <span class="block bg-slate-950 w-[4px] h-full"></span>
                            <span class="block bg-white w-[2px] h-full"></span>
                            <span class="block bg-slate-950 w-[1px] h-full"></span>
                            <span class="block bg-slate-950 w-[3px] h-full"></span>
                            <span class="block bg-white w-[3px] h-full"></span>
                            <span class="block bg-slate-950 w-[5px] h-full"></span>
                            <span class="block bg-slate-950 w-[1px] h-full"></span>
                            <span class="block bg-white w-[2px] h-full"></span>
                            <span class="block bg-slate-950 w-[2px] h-full"></span>
                            <span class="block bg-white w-[4px] h-full"></span>
                            <span class="block bg-slate-950 w-[4px] h-full"></span>
                            <span class="block bg-slate-950 w-[1px] h-full"></span>
                            <span class="block bg-white w-[2px] h-full"></span>
                            <span class="block bg-slate-950 w-[3px] h-full"></span>
                            <span class="block bg-slate-950 w-[2px] h-full"></span>
                            <span class="block bg-white w-[1px] h-full"></span>
                            <span class="block bg-slate-950 w-[4px] h-full"></span>
                            <span class="block bg-slate-950 w-[2px] h-full"></span>
                            <span class="block bg-white w-[2px] h-full"></span>
                            <span class="block bg-slate-950 w-[1px] h-full"></span>
                            <span class="block bg-slate-950 w-[3px] h-full"></span>
                        </div>
                        <span class="text-[9px] font-mono tracking-[0.25em] text-slate-500 font-bold">{{ $kode }}</span>
                    </div>
                    <span class="text-[9px] text-slate-400 font-medium mt-1 uppercase tracking-wider text-center">Tunjukkan QR/Barcode Ke Sopir</span>
                </div>

            </div>

        </div>

        <!-- Action Buttons (no-print) -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 no-print">
            <a href="{{ route('penumpang.status') }}" class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors text-center cursor-pointer">
                Kembali
            </a>
            
            <!-- Cetak Status Pembayaran (Spatie PDF) -->
            <a href="{{ route('penumpang.status.pdf', $pemesanan->id_pemesanan) }}" target="_blank" class="w-full sm:w-auto px-8 py-3 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-950 border border-gold-500/20 hover:border-gold-500/45 rounded-xl shadow-md transition-colors cursor-pointer flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.434a2.25 2.25 0 002.25-2.25v-3a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v3a2.25 2.25 0 002.25 2.25h1.434M9 9h6v3.75H9V9z" /></svg>
                Cetak Status Pembayaran (PDF)
            </a>
        </div>

    </div>
</div>
@endsection
