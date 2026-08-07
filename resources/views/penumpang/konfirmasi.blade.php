@extends('layouts.penumpang')

@section('title', 'Konfirmasi Pemesanan - RTM Family')

@section('content')
<div class="py-8 bg-slate-50 md:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">

        <!-- Header Workflow Stepper -->
        <div class="max-w-xl mx-auto mb-10">
            <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                <div class="flex flex-col items-center gap-1.5 text-slate-900">
                    <span class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold">1</span>
                    <span>Pilih Jadwal</span>
                </div>
                <div class="h-0.5 flex-1 bg-gold-400 mx-2 -mt-4"></div>
                <div class="flex flex-col items-center gap-1.5 text-slate-900">
                    <span class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold">2</span>
                    <span>Pilih Kursi</span>
                </div>
                <div class="h-0.5 flex-1 bg-gold-400 mx-2 -mt-4"></div>
                <div class="flex flex-col items-center gap-1.5 text-slate-900">
                    <span class="w-7 h-7 rounded-full bg-gold-400 text-slate-950 flex items-center justify-center font-bold ring-4 ring-gold-100">3</span>
                    <span class="font-bold">Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Main Title -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Detail Pemesanan</h1>
            <p class="mt-1 text-sm text-slate-500">Silakan tinjau kembali data diri dan detail perjalanan Anda sebelum melakukan konfirmasi</p>
        </div>

        <!-- Form wrapping the invoice summary -->
        <form action="{{ route('penumpang.konfirmasi.store') }}" method="POST" id="booking-confirmation-form">
            @csrf
            <!-- Hidden inputs -->
            <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal ?? '' }}">
            <input type="hidden" name="id_kursi" value="{{ $kursi->id_kursi ?? '' }}">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Data Pemesan Form -->
                <div class="md:col-span-6">
                    <div class="bg-white rounded-2xl shadow-card border border-slate-100 p-6 md:p-8 transition-all">
                        <h2 class="text-base font-bold text-slate-900 pb-4 mb-6 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span>
                            Data Pemesan
                        </h2>

                        <div class="space-y-5">
                            <!-- Input: Nama -->
                            <div>
                                <label for="nama" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" readonly required value="{{ $penumpang->nama ?? Auth::user()->name }}" class="block w-full px-4 py-3 text-sm text-slate-800 bg-slate-100 border border-slate-200 rounded-xl cursor-not-allowed">
                            </div>

                            <!-- Input: Email -->
                            <div>
                                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Alamat Email</label>
                                <input type="email" id="email" name="email" readonly required value="{{ $penumpang->email ?? Auth::user()->email }}" class="block w-full px-4 py-3 text-sm text-slate-800 bg-slate-100 border border-slate-200 rounded-xl cursor-not-allowed">
                            </div>

                            <!-- Input: No Telpon -->
                            <div>
                                <label for="telepon" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Nomor Telepon / WhatsApp</label>
                                <input type="tel" id="telepon" name="telepon" readonly required value="{{ $penumpang->no_hp ?? '081234567890' }}" class="block w-full px-4 py-3 text-sm text-slate-800 bg-slate-100 border border-slate-200 rounded-xl cursor-not-allowed">
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right: Ringkasan Perjalanan card -->
                <div class="md:col-span-6">
                    <div class="bg-white rounded-2xl shadow-card border border-slate-100 p-6 md:p-8 transition-all">
                        <h2 class="text-base font-bold text-slate-900 pb-4 mb-6 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-gold-500"></span>
                            Ringkasan Perjalanan
                        </h2>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Kota Asal</span>
                                <span class="font-bold text-slate-800">{{ $jadwal->asal ?? 'Sijunjung' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Kota Tujuan</span>
                                <span class="font-bold text-slate-800">{{ $jadwal->tujuan ?? 'Padang' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Tanggal Perjalanan</span>
                                <span class="font-bold text-slate-800">{{ $jadwal->tanggal ?? date('Y-m-d') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Jam Keberangkatan</span>
                                <span class="font-bold text-slate-800">{{ $jadwal->jam ? \Carbon\Carbon::parse($jadwal->jam)->format('H.i') . ' WIB' : '05.00 WIB' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Armada</span>
                                <span class="font-bold text-slate-800">{{ $jadwal->armada->merk ?? 'Toyota Avanza' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Kursi Dipilih</span>
                                <span class="font-extrabold text-gold-600 bg-gold-50 border border-gold-200/50 px-2.5 py-0.5 rounded-md">
                                    Kursi {{ $kursi->nomor_kursi ?? '1' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Jumlah Penumpang</span>
                                <span class="font-bold text-slate-800">1 orang</span>
                            </div>

                            <!-- Pricing Dividers -->
                            <div class="pt-4 border-t border-slate-100 mt-4 space-y-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-400 font-medium">Harga Tiket</span>
                                    <span class="font-semibold text-slate-800">Rp {{ number_format($jadwal->harga ?? 70000, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-dashed border-slate-100">
                                    <span class="text-sm font-bold text-slate-900">Total Harga</span>
                                    <span class="text-lg font-black text-gold-600">Rp {{ number_format($jadwal->harga ?? 70000, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Payment Notice Info Box -->
                            <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-slate-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 11.518 1.3L11.25 12.75v3.25m0 3v.75m0-10.5h.008v.008h-.008V7.5zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <div class="space-y-0.5">
                                    <h4 class="text-xs font-bold text-slate-800">Informasi Pembayaran</h4>
                                    <p class="text-[11px] text-slate-500 leading-normal">Pembayaran dilakukan secara tunai langsung kepada sopir di lokasi keberangkatan saat menaiki armada travel.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Form Submit Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('penumpang.pilih_kursi', $jadwal->id_jadwal ?? 1) }}" class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors text-center cursor-pointer">
                    Kembali
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-950 border border-gold-500/20 hover:border-gold-500/40 rounded-xl shadow-md transition-colors cursor-pointer flex items-center justify-center gap-1.5">
                    Konfirmasi Pemesanan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
