@extends('layouts.sopir')

@section('title', 'Dashboard Sopir - CV RTM Travel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="glass-card p-6 rounded-3xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 flex items-center gap-3">
                <i class="fa-solid fa-id-card text-amber-600"></i>
                Dashboard Pengemudi / Sopir
            </h1>
            <p class="text-xs text-slate-600 font-semibold mt-1">Selamat bertugas, <strong>{{ Auth::user()->name }}</strong>. Pantau tugas keberangkatan dan daftar penumpang Anda.</p>
        </div>
        <div>
            <span class="px-3.5 py-1.5 rounded-xl bg-amber-100 text-amber-800 border border-amber-300 text-xs font-bold shadow-sm inline-block">
                Role: Sopir
            </span>
        </div>
    </div>

    <!-- Informasi Gaji & Profil -->
    @if($sopir)
    <div class="glass-card p-5 rounded-3xl grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
            <span class="text-xs text-slate-600 uppercase font-bold">Nama Driver</span>
            <div class="text-base font-extrabold text-slate-900 mt-0.5">{{ $sopir->nama }}</div>
        </div>
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
            <span class="text-xs text-slate-600 uppercase font-bold">Nomor WhatsApp</span>
            <div class="text-base font-extrabold text-slate-900 mt-0.5">{{ $sopir->no_hp }}</div>
        </div>
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
            <span class="text-xs text-slate-600 uppercase font-bold">Gaji Per Bulan</span>
            <div class="text-base font-extrabold text-emerald-700 mt-0.5">Rp {{ number_format($sopir->gaji, 0, ',', '.') }}</div>
        </div>
    </div>
    @endif

    <!-- Jadwal Ditugaskan -->
    <div class="glass-card p-6 rounded-3xl">
        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-route text-amber-600"></i>
            Jadwal Keberangkatan Ditugaskan
        </h2>

        <div class="space-y-4">
            @forelse($assignedJadwals as $j)
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-3 pb-3 border-b border-slate-200">
                        <div>
                            <span class="text-xs text-amber-700 font-bold uppercase">Jadwal #{{ $j->id_jadwal }}</span>
                            <div class="text-lg font-extrabold text-slate-900">{{ $j->asal }} &rarr; {{ $j->tujuan }}</div>
                        </div>
                        <div class="sm:text-right">
                            <span class="block text-xs font-bold text-slate-600">{{ $j->tanggal }}</span>
                            <span class="text-xs font-extrabold text-sky-700"><i class="fa-regular fa-clock mr-1"></i> Jam {{ $j->jam }}</span>
                        </div>
                    </div>

                    <div class="text-xs text-slate-800 font-semibold mb-3">
                        <strong class="text-slate-900">Armada:</strong> {{ $j->armada->merk ?? '-' }} ({{ $j->armada->warna ?? '-' }})
                    </div>

                    <!-- Passenger Manifest -->
                    <div class="mt-3">
                        <span class="text-xs font-bold text-slate-700 uppercase block mb-2">Daftar Penumpang (Manifes):</span>
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200">
                            @if($j->pemesanans->count() > 0)
                                <ul class="divide-y divide-slate-200 text-xs text-slate-800 font-semibold">
                                    @foreach($j->pemesanans as $p)
                                        <li class="py-2 flex justify-between items-center">
                                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-user-check text-emerald-600"></i> {{ $p->penumpang->nama ?? 'Penumpang' }}</span>
                                            <span class="text-slate-600 font-bold">{{ $p->penumpang->no_hp ?? '-' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-xs text-slate-600 font-medium italic">Belum ada penumpang terdaftar pada rute ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-slate-600 font-semibold text-sm">
                    Belum ada tugas jadwal keberangkatan saat ini.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
