@extends('layouts.sopir')

@section('title', 'Dashboard Sopir - CV RTM Travel')
@section('page_title', 'Dashboard Pengemudi')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header & Stats -->
    <div class="bg-white p-6 rounded-3xl text-slate-800 shadow-md border border-slate-200/80">
        <div class="space-y-4">
            <div>
                <span class="px-2.5 py-1 rounded-lg bg-amber-50 text-amber-600 border border-amber-200 text-[10px] font-bold tracking-wider uppercase">Portal Pengemudi</span>
                <h1 class="text-xl font-black mt-1 text-slate-900">Halo, {{ $sopir->nama ?? Auth::user()->name }}!</h1>
                <p class="text-slate-500 text-xs mt-0.5 font-medium">Berikut adalah rangkuman tugas perjalanan dan gaji Anda bulan ini.</p>
            </div>

            @if($sopir)
            <!-- Quick Stats Row -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 pt-2">
                <div class="bg-slate-50 border border-slate-200/60 p-3.5 rounded-2xl">
                    <span class="text-[9px] text-slate-500 font-bold block uppercase tracking-wider">Jadwal Ditugaskan</span>
                    <span class="text-lg font-black text-amber-600 mt-0.5 block">{{ $jumlahJadwal }} <span class="text-xs text-slate-500 font-medium">Tugas</span></span>
                </div>
                <div class="bg-slate-50 border border-slate-200/60 p-3.5 rounded-2xl">
                    <span class="text-[9px] text-slate-500 font-bold block uppercase tracking-wider">Penumpang Akan Dilayani</span>
                    <span class="text-lg font-black text-sky-600 mt-0.5 block">{{ $jumlahPenumpangAkanDilayani }} <span class="text-xs text-slate-500 font-medium">Orang</span></span>
                </div>
                <div class="bg-slate-50 border border-slate-200/60 p-3.5 rounded-2xl">
                    <span class="text-[9px] text-slate-500 font-bold block uppercase tracking-wider">Penumpang Selesai</span>
                    <span class="text-lg font-black text-emerald-600 mt-0.5 block">{{ $completedBookingsCount }} <span class="text-xs text-slate-500 font-medium">Orang</span></span>
                </div>
                <div class="bg-slate-50 border border-slate-200/60 p-3.5 rounded-2xl col-span-2 lg:col-span-1">
                    <span class="text-[9px] text-slate-500 font-bold block uppercase tracking-wider">Akumulasi Gaji</span>
                    <span class="text-lg font-black text-emerald-600 mt-0.5 block">Rp {{ number_format($totalGaji, 0, ',', '.') }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if(!$sopir)
    <div class="bg-red-500/10 border border-red-500/20 p-5 rounded-3xl text-red-700 text-xs font-semibold">
        <i class="fa-solid fa-circle-exclamation text-red-500 mr-2 text-base"></i>
        <span>Profil sopir Anda belum terdaftar di sistem. Hubungi Admin untuk mengaitkan nama pengguna Anda dengan data Sopir.</span>
    </div>
    @else
    <!-- Next Scheduled Departure Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-md">
        <h2 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-3.5 flex items-center gap-1.5">
            <i class="fa-solid fa-clock text-amber-500"></i> Keberangkatan Terdekat
        </h2>
        @if($nextJadwal)
            <div class="bg-slate-50 border border-slate-200/60 p-4 rounded-2xl space-y-3.5">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-bold">Ditugaskan</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-bold text-slate-700">{{ \Carbon\Carbon::parse($nextJadwal->tanggal)->translatedFormat('d M Y') }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-500/10 flex items-center justify-center text-amber-600 text-sm shadow-inner shrink-0">
                        <i class="fa-solid fa-route"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="text-xs font-bold text-slate-400 uppercase leading-none">Rute</div>
                        <div class="text-sm font-black text-slate-900 mt-1 leading-snug">
                            {{ $nextJadwal->asal }} <span class="text-amber-500 font-bold mx-1">&rarr;</span> {{ $nextJadwal->tujuan }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-200/60 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium block">Jam Keberangkatan</span>
                        <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($nextJadwal->jam)->format('H:i') }} WIB</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Armada Mobil</span>
                        <span class="font-bold text-slate-800">{{ $nextJadwal->armada->merk ?? '-' }} ({{ $nextJadwal->armada->plat_nomor ?? '-' }})</span>
                    </div>
                </div>

                <div class="pt-1 flex gap-2">
                    <a href="{{ route('sopir.jadwal.detail', $nextJadwal->id_jadwal) }}" class="flex-grow text-center bg-slate-900 hover:bg-slate-950 text-white font-bold py-2 rounded-xl text-xs transition-colors shadow-sm">
                        <i class="fa-solid fa-circle-info mr-1"></i> Detail Tugas
                    </a>
                    <a href="{{ route('sopir.jadwal.penumpang', $nextJadwal->id_jadwal) }}" class="text-slate-700 bg-slate-100 hover:bg-slate-200 font-bold px-4 py-2 rounded-xl text-xs transition-colors border border-slate-200">
                        <i class="fa-solid fa-users"></i> Manifes
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-6 bg-slate-50 border border-dashed border-slate-200 rounded-2xl">
                <p class="text-xs text-slate-500 font-medium italic">Tidak ada tugas keberangkatan dalam waktu dekat.</p>
            </div>
        @endif
    </div>

    <!-- Quick Driver Profile Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-md">
        <h2 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-3.5 flex items-center gap-1.5">
            <i class="fa-solid fa-user-gear text-amber-500"></i> Profil Driver Anda
        </h2>
        <div class="space-y-2.5 text-xs text-slate-700">
            <div class="flex justify-between py-1.5 border-b border-slate-100 font-medium">
                <span class="text-slate-400">Nama Lengkap</span>
                <span class="font-bold text-slate-800 text-right">{{ $sopir->nama }}</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-slate-100 font-medium">
                <span class="text-slate-400">No. WhatsApp</span>
                <span class="font-bold text-slate-800 text-right">{{ $sopir->no_hp }}</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-slate-100 font-medium">
                <span class="text-slate-400">Alamat Tugas</span>
                <span class="font-bold text-slate-800 text-right max-w-[200px] truncate" title="{{ $sopir->alamat }}">{{ $sopir->alamat }}</span>
            </div>
            <div class="flex justify-between py-1.5 font-medium">
                <span class="text-slate-400">Gaji Pokok Bulanan</span>
                <span class="font-bold text-emerald-600 text-right">Rp {{ number_format($sopir->gaji, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Assigned Schedules Overview -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                <i class="fa-solid fa-route text-amber-500"></i> Jadwal Perjalanan Anda
            </h2>
            <a href="{{ route('sopir.jadwal') }}" class="text-[10px] font-bold text-brand-600 hover:underline">Lihat Semua</a>
        </div>

        <div class="space-y-3">
            @forelse($assignedJadwals->take(3) as $j)
                <div class="p-3.5 bg-slate-50 border border-slate-200/60 rounded-2xl flex items-center justify-between gap-2 hover:bg-slate-100/50 transition-colors">
                    <div class="space-y-1">
                        <div class="text-xs font-bold text-slate-800">
                            {{ $j->asal }} &rarr; {{ $j->tujuan }}
                        </div>
                        <div class="text-[10px] text-slate-500 font-medium flex items-center gap-1.5">
                            <span>{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}</span>
                            <span>&bull;</span>
                            <span>{{ \Carbon\Carbon::parse($j->jam)->format('H:i') }}</span>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('sopir.jadwal.detail', $j->id_jadwal) }}" class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-xs">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-slate-500 font-medium italic text-xs">
                    Belum ada tugas jadwal keberangkatan saat ini.
                </div>
            @endforelse
        </div>
    </div>
    @endif
</div>
@endsection