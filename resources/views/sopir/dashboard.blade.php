@extends('layouts.sopir')

@section('title', 'Dashboard Sopir - CV RTM Travel')
@section('page_title', 'Dashboard Pengemudi')

@section('content')
<div class="space-y-6">

    <!-- Welcome Header & Quick Stats Card -->
    <div class="bg-white p-6 sm:p-7 rounded-3xl text-slate-800 shadow-xs border border-slate-200/80">
        <div class="space-y-5">
            <!-- Header Title Block -->
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold mt-2 text-slate-900 tracking-tight">
                    Halo, {{ $sopir->nama ?? Auth::user()->name }}!
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1 leading-relaxed">
                    Selamat bertugas! Pantau jadwal perjalanan dan ringkasan pelayanan penumpang Anda di bawah ini.
                </p>
            </div>

            @if($sopir)
            <!-- Quick Stats Grid (Presisi 4 Kolom) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 pt-2">
                <!-- Stat 1: Jadwal Ditugaskan -->
                <div class="bg-slate-50/90 border border-slate-200/80 p-4 rounded-2xl flex flex-col justify-between">
                    <span class="text-[10px] text-slate-500 font-extrabold uppercase tracking-wider block">Jadwal Ditugaskan</span>
                    <div class="mt-2">
                        <span class="text-xl lg:text-2xl font-black text-amber-600 tracking-tight block">
                            {{ $jumlahJadwal }} <span class="text-xs text-slate-500 font-bold">Tugas</span>
                        </span>
                    </div>
                </div>

                <!-- Stat 2: Penumpang Akan Dilayani -->
                <div class="bg-slate-50/90 border border-slate-200/80 p-4 rounded-2xl flex flex-col justify-between">
                    <span class="text-[10px] text-slate-500 font-extrabold uppercase tracking-wider block">Penumpang Dilayani</span>
                    <div class="mt-2">
                        <span class="text-xl lg:text-2xl font-black text-sky-600 tracking-tight block">
                            {{ $jumlahPenumpangAkanDilayani }} <span class="text-xs text-slate-500 font-bold">Orang</span>
                        </span>
                    </div>
                </div>

                <!-- Stat 3: Penumpang Selesai -->
                <div class="bg-slate-50/90 border border-slate-200/80 p-4 rounded-2xl flex flex-col justify-between">
                    <span class="text-[10px] text-slate-500 font-extrabold uppercase tracking-wider block">Penumpang Selesai</span>
                    <div class="mt-2">
                        <span class="text-xl lg:text-2xl font-black text-emerald-600 tracking-tight block">
                            {{ $completedBookingsCount }} <span class="text-xs text-slate-500 font-bold">Orang</span>
                        </span>
                    </div>
                </div>

                <!-- Stat 4: Akumulasi Bagi Hasil -->
                <div class="bg-slate-50/90 border border-slate-200/80 p-4 rounded-2xl col-span-2 lg:col-span-1 flex flex-col justify-between">
                    <span class="text-[10px] text-slate-500 font-extrabold uppercase tracking-wider block">Akumulasi Bagi Hasil</span>
                    <div class="mt-2">
                        <span class="text-xl lg:text-2xl font-black text-emerald-600 tracking-tight block">
                            Rp {{ number_format($totalGaji, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if(!$sopir)
    <!-- Danger Alert jika akun belum dikaitkan dengan data sopir -->
    <div class="bg-red-50 border border-red-200 p-5 rounded-3xl text-red-800 text-xs sm:text-sm font-medium flex items-start gap-3.5 shadow-xs">
        <i class="fa-solid fa-circle-exclamation text-red-600 text-xl shrink-0 mt-0.5"></i>
        <div>
            <h4 class="font-extrabold text-red-900 text-sm mb-0.5">Profil Belum Terdaftar di Sistem</h4>
            <p class="leading-relaxed">Profil sopir Anda belum terdaftar atau terhubung di database. Silakan hubungi Admin untuk mengaitkan akun Anda dengan data Sopir resmi.</p>
        </div>
    </div>
    @else

    <!-- Jadwal Hari ini -->
    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
            <h2 class="text-xs font-extrabold text-slate-500 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-clock text-amber-500 text-sm"></i>
                <span>Jadwal Hari Ini</span>
            </h2>
            @php
                $listJadwalHariIni = $jadwalHariIni ?? $keberangkatanTerdekat ?? collect();
            @endphp
            @if($listJadwalHariIni->count() > 0)
                <span class="text-xs font-bold text-amber-600 bg-amber-50 border border-amber-200/80 px-2.5 py-1 rounded-full">
                    Hari Ini ({{ $listJadwalHariIni->count() }} Jadwal)
                </span>
            @endif
        </div>

        @if($listJadwalHariIni->count() > 0)
            <div class="space-y-4">
                @foreach($listJadwalHariIni as $jadwal)
                    <div class="bg-slate-50/90 border border-slate-200/80 p-4 sm:p-5 rounded-2xl space-y-4">
                        <!-- Status & Tanggal -->
                        <div class="flex items-center justify-between gap-2 flex-wrap">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 text-[11px] font-extrabold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                                    Ditugaskan
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 text-sky-700 border border-sky-200 text-[11px] font-extrabold">
                                    <i class="fa-solid fa-users text-[10px]"></i>
                                    {{ $jadwal->pemesanans->where('status_perjalanan', '!=', 'Batal')->sum('jumlah_penumpang') }} Penumpang
                                </span>
                            </div>
                            <span class="text-xs sm:text-sm font-extrabold text-slate-800">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }}
                            </span>
                        </div>

                        <!-- Detail Rute -->
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center text-base shadow-xs shrink-0 font-black">
                                <i class="fa-solid fa-route"></i>
                            </div>
                            <div class="flex-grow">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">Rute Perjalanan</span>
                                <div class="text-sm sm:text-base font-extrabold text-slate-900 mt-0.5 flex items-center gap-2">
                                    <span>{{ $jadwal->asal }}</span>
                                    <i class="fa-solid fa-arrow-right text-xs text-amber-500"></i>
                                    <span>{{ $jadwal->tujuan }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Metadata Jam & Armada -->
                        <div class="grid grid-cols-2 gap-3 pt-3 border-t border-slate-200/80 text-xs sm:text-sm">
                            <div>
                                <span class="text-slate-400 font-bold block text-[10px] uppercase tracking-wider">Jam Keberangkatan</span>
                                <span class="font-extrabold text-slate-900 mt-0.5 block">{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB</span>
                            </div>
                            <div>
                                <span class="text-slate-400 font-bold block text-[10px] uppercase tracking-wider">Armada Mobil</span>
                                <span class="font-extrabold text-slate-900 mt-0.5 block">
                                    {{ $jadwal->armada->merk ?? '-' }}
                                    @if(isset($jadwal->armada->plat_nomor))
                                        <span class="text-slate-500 font-semibold">({{ $jadwal->armada->plat_nomor }})</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="pt-2 flex flex-col sm:flex-row gap-2.5">
                            <a href="{{ route('sopir.jadwal.detail', $jadwal->id_jadwal) }}" class="flex-1 text-center bg-slate-900 hover:bg-slate-950 active:scale-[0.99] text-white font-bold py-2.5 rounded-xl text-xs sm:text-sm transition-all shadow-xs flex items-center justify-center gap-2">
                                <i class="fa-solid fa-eye text-xs"></i>
                                <span>Detail Tugas</span>
                            </a>
                            <a href="{{ route('sopir.jadwal.penumpang', $jadwal->id_jadwal) }}" class="text-slate-800 bg-white hover:bg-slate-100 active:scale-[0.99] font-bold px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all border border-slate-300 flex items-center justify-center gap-2 shrink-0">
                                <i class="fa-solid fa-users text-slate-500 text-xs"></i>
                                <span>Penumpang</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 bg-slate-50/90 border border-dashed border-slate-200 rounded-2xl text-slate-500">
                <i class="fa-solid fa-ticket text-3xl text-slate-300 mb-2 block"></i>
                <p class="text-xs sm:text-sm font-bold text-slate-700">Belum ada penumpang yang memesan tiket</p>
                <p class="text-[11px] text-slate-400 font-medium mt-0.5">Jadwal keberangkatan hari ini yang memiliki penumpang akan tampil di sini.</p>
            </div>
        @endif
    </div>

    <!-- Quick Driver Profile Card -->
    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <h2 class="text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-3.5 pb-2 border-b border-slate-100 flex items-center gap-2">
            <i class="fa-solid fa-id-card text-amber-500 text-sm"></i>
            <span>Profil Driver Anda</span>
        </h2>
        <div class="space-y-3 text-xs sm:text-sm text-slate-800">
            <div class="flex justify-between items-center py-1 border-b border-slate-100 font-medium">
                <span class="text-slate-500 font-semibold">Nama Lengkap</span>
                <span class="font-extrabold text-slate-900 text-right">{{ $sopir->nama }}</span>
            </div>
            <div class="flex justify-between items-center py-1 border-b border-slate-100 font-medium">
                <span class="text-slate-500 font-semibold">No. WhatsApp</span>
                <span class="font-extrabold text-slate-900 text-right">{{ $sopir->no_hp }}</span>
            </div>
            <div class="flex justify-between items-center py-1 border-b border-slate-100 font-medium">
                <span class="text-slate-500 font-semibold">Alamat Tugas</span>
                <span class="font-extrabold text-slate-900 text-right max-w-[220px] truncate" title="{{ $sopir->alamat }}">{{ $sopir->alamat }}</span>
            </div>
            <div class="flex justify-between items-center py-1 font-medium">
                <span class="text-slate-500 font-semibold">Sistem Pendapatan</span>
                <span class="font-extrabold text-emerald-600 text-right">Bagi Hasil Per-Perjalanan</span>
            </div>
        </div>
    </div>

    <!-- Assigned Schedules Overview -->
    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-100">
            <h2 class="text-xs font-extrabold text-slate-500 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-route text-amber-500 text-sm"></i>
                <span>Jadwal Perjalanan Anda</span>
            </h2>
            <a href="{{ route('sopir.jadwal') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 hover:underline">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="space-y-3">
            @forelse($assignedJadwals->take(3) as $j)
                <div class="p-3.5 bg-slate-50/90 border border-slate-200/80 rounded-2xl flex items-center justify-between gap-3 hover:bg-slate-100/70 transition-colors">
                    <div class="space-y-1">
                        <div class="text-xs sm:text-sm font-extrabold text-slate-900 flex items-center gap-1.5">
                            <span>{{ $j->asal }}</span>
                            <i class="fa-solid fa-arrow-right text-[10px] text-amber-500"></i>
                            <span>{{ $j->tujuan }}</span>
                        </div>
                        <div class="text-[11px] text-slate-500 font-medium flex items-center gap-1.5">
                            <span>{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}</span>
                            <span>&bull;</span>
                            <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($j->jam)->format('H:i') }} WIB</span>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('sopir.jadwal.detail', $j->id_jadwal) }}" class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-700 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-xs" title="Lihat Detail Tugas">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-slate-500 font-medium text-xs sm:text-sm">
                    Belum ada tugas jadwal keberangkatan saat ini.
                </div>
            @endforelse
        </div>
    </div>
    @endif

</div>
@endsection