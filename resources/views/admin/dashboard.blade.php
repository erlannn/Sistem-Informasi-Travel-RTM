@extends('layouts.admin')

@section('title', 'Admin Dashboard - CV Travel RTM')
@section('page_title', 'Dashboard Control Center')

@section('content')
<div class="space-y-8 sm:space-y-10">
    <!-- Welcome Header Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-7 sm:p-8 md:p-10 relative overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Selamat Datang, Admin RTM Travel
                </h1>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid (4 Key Metrics) -->
    <div>
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg sm:text-xl font-black text-black tracking-tight">
                Ringkasan Data Utama
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            <!-- Stat: Jadwal -->
            <a href="{{ route('admin.jadwal.index') }}" class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:border-amber-400/80 transition-all border-l-4 border-l-amber-500 block group">
                <span class="text-xs font-black uppercase tracking-wider text-black block mb-2">Total Jadwal</span>
                <div class="text-3xl sm:text-4xl font-black text-black tracking-tight">{{ $stats['total_jadwal'] }}</div>
                <span class="text-xs sm:text-sm text-amber-600 font-extrabold block mt-3 group-hover:translate-x-1 transition-transform">Lihat Jadwal &rarr;</span>
            </a>

            <!-- Stat: Pemesanan -->
            <a href="{{ route('admin.pemesanan.index') }}" class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:border-amber-400/80 transition-all border-l-4 border-l-amber-500 block group">
                <span class="text-xs font-black uppercase tracking-wider text-black block mb-2">Total Pemesanan</span>
                <div class="text-3xl sm:text-4xl font-black text-black tracking-tight">{{ $stats['total_pemesanan'] }}</div>
                <span class="text-xs sm:text-sm text-amber-600 font-extrabold block mt-3 group-hover:translate-x-1 transition-transform">Lihat Pemesanan &rarr;</span>
            </a>

            <!-- Stat: Armada -->
            <a href="{{ route('admin.armada.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-sm transition border-l-4 border-l-brand-500 block">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">Total Armada</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_armada'] }}</div>
                <span class="text-[11px] text-brand-600 font-bold block mt-2">Lihat Selengkapnya &rarr;</span>
            </a>

            <!-- Stat: Sopir -->
            <a href="{{ route('admin.sopir.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-sm transition border-l-4 border-l-brand-500 block">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">Total Sopir</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_sopir'] }}</div>
                <span class="text-[11px] text-brand-600 font-bold block mt-2">Lihat Selengkapnya &rarr;</span>
            </a>
        </div>
    </div>
</div>
@endsection
