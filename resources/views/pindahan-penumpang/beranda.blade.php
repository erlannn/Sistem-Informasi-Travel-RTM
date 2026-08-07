@extends('layout.app')

@section('title', 'Beranda - Pemesanan Tiket Travel RTM Family')

@section('content')
<div class="py-8 bg-slate-50 md:py-12">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Welcome Hero Section (Minimalist & Clean) -->
        <div class="relative mb-8 text-center md:text-left pt-4">
            <!-- Brand Badge -->
            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[11px] font-bold text-brand-600 bg-brand-50 border border-brand-100 rounded-full mb-4 uppercase tracking-wider select-none">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                Layanan Travel Premium
            </span>
            
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight uppercase">
                Selamat Datang di Travel RTM
            </h1>
            <p class="mt-3 text-sm md:text-base text-slate-500 max-w-3xl leading-relaxed font-light">
                Pesan tiket travel dengan mudah, cepat, dan dapatkan rekomendasi jadwal terbaik untuk perjalanan Anda secara real-time.
            </p>
            <div class="w-12 h-[3px] bg-brand-500 rounded-full mt-4 mx-auto md:mx-0"></div>
        </div>

        <!-- Main Workspace Grid (Search & Recommendations) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Side: Cari Tiket Form (5 Cols on Large Screens) -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl shadow-card border border-slate-100 p-6 md:p-8 transition-all hover:shadow-card-hover">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 rounded-lg bg-brand-50 text-brand-500">
                            <!-- Icon Bus/Travel -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Cari Tiket Perjalanan</h2>
                            <p class="text-xs text-slate-500">Isi rute dan tanggal keberangkatan Anda</p>
                        </div>
                    </div>

                    <form action="/booking/jadwal" method="GET" id="ticket-search-form" class="space-y-5">
                        <!-- Input: Kota Asal -->
                        <div>
                            <label for="asal" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Kota Asal</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                    <!-- Map Pin Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25g-3.75 3.75 0 117.5 0z"></path></svg>
                                </span>
                                <select id="asal" name="asal" class="block w-full pl-10 pr-10 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Kota Asal...</option>
                                    <option value="Sijunjung">Sijunjung</option>
                                    <option value="Padang">Padang</option>
                                    <option value="Solok">Solok</option>
                                    <option value="Bukittinggi">Bukittinggi</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                </span>
                            </div>
                        </div>

                        <!-- Input: Kota Tujuan -->
                        <div>
                            <label for="tujuan" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Kota Tujuan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25C4.5 3.358 12-.625 12 .053"></path></svg>
                                </span>
                                <select id="tujuan" name="tujuan" class="block w-full pl-10 pr-10 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Kota Tujuan...</option>
                                    <option value="Padang">Padang</option>
                                    <option value="Sijunjung">Sijunjung</option>
                                    <option value="Solok">Solok</option>
                                    <option value="Bukittinggi">Bukittinggi</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                </span>
                            </div>
                        </div>

                        <!-- Input: Tanggal Keberangkatan -->
                        <div>
                            <label for="tanggal" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Tanggal Perjalanan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                    <!-- Calendar Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path></svg>
                                </span>
                                <input type="date" id="tanggal" name="tanggal" min="{{ date('Y-m-d') }}" class="block w-full pl-10 pr-4 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all cursor-pointer">
                            </div>
                        </div>

                        <!-- Submit Button (Primary Action: Deep Slate with Gold Border) -->
                        <button type="submit" class="w-full py-3.5 px-4 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-950 border border-gold-500/30 hover:border-gold-500/60 active:bg-slate-950 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 group cursor-pointer focus:ring-2 focus:ring-gold-500/30">
                            <!-- Search Glass SVG -->
                            <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z"></path></svg>
                            Cari Jadwal Perjalanan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side: Rekomendasi Jadwal (7 Cols on Large Screens) -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl shadow-card border border-slate-100 p-6 md:p-8 transition-all">
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-lg bg-gold-50 text-gold-500">
                                <!-- Star Icon -->
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">Rekomendasi Jadwal</h2>
                                <p class="text-xs text-slate-500">Pilihan rute terpopuler penumpang RTM Family</p>
                            </div>
                        </div>
                        
                        <!-- Mini filter/status indicator -->
                        <span class="text-xs font-medium text-brand-500 bg-brand-50 px-2.5 py-1 rounded-full">
                            Terupdate Hari Ini
                        </span>
                    </div>

                    <!-- Recommended Schedule Cards list -->
                    <div class="space-y-4">
                        
                        <!-- Card 1: Sijunjung -> Padang -->
                        <div class="group relative bg-slate-50 hover:bg-white rounded-2xl border border-slate-200/60 p-5 transition-all duration-300 hover:shadow-card hover:border-gold-500/30 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <!-- Popularity Ribbon Accent -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gold-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <div class="flex items-start gap-4">
                                <!-- Star Icon -->
                                <div class="mt-1 flex items-center justify-center w-8 h-8 rounded-lg bg-gold-100 text-gold-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                </div>
                                <div class="space-y-2">
                                    <!-- Route Details -->
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900 text-sm md:text-base">Sijunjung</span>
                                        <!-- Right Arrow Icon -->
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path></svg>
                                        <span class="font-bold text-slate-900 text-sm md:text-base">Padang</span>
                                    </div>
                                    <!-- Meta Badges -->
                                    <div class="flex flex-wrap items-center gap-2.5 text-xs text-slate-500">
                                        <!-- Time Badge -->
                                        <span class="flex items-center gap-1 font-semibold text-slate-800 bg-slate-200/60 px-2 py-0.5 rounded">
                                            05.00 WIB
                                        </span>
                                        <span class="text-slate-300">|</span>
                                        <!-- Fleet Class -->
                                        <span class="flex items-center gap-1">
                                            Super Executive (HiAce)
                                        </span>
                                        <span class="text-slate-300">|</span>
                                        <!-- Status Badge -->
                                        <span class="text-status-success font-medium flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-status-success inline-block"></span>
                                            Ada Kursi
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA & Price -->
                            <div class="flex items-center md:flex-col md:items-end justify-between md:justify-center border-t md:border-t-0 border-slate-200/60 pt-3 md:pt-0 gap-2">
                                <div class="text-left md:text-right">
                                    <span class="text-xs text-slate-400 block">Mulai dari</span>
                                    <span class="text-base font-extrabold text-brand-600">Rp 150.000</span>
                                </div>
                                <a href="#" class="px-4 py-2 text-xs font-semibold text-slate-900 bg-gold-50/80 hover:bg-gold-100/80 border border-gold-200/60 rounded-lg shadow-xs transition-colors flex items-center gap-1">
                                    Lihat Jadwal
                                </a>
                            </div>
                        </div>

                        <!-- Card 2: Padang -> Sijunjung -->
                        <div class="group relative bg-slate-50 hover:bg-white rounded-2xl border border-slate-200/60 p-5 transition-all duration-300 hover:shadow-card hover:border-gold-500/30 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gold-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <div class="flex items-start gap-4">
                                <div class="mt-1 flex items-center justify-center w-8 h-8 rounded-lg bg-gold-100 text-gold-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900 text-sm md:text-base">Padang</span>
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path></svg>
                                        <span class="font-bold text-slate-900 text-sm md:text-base">Sijunjung</span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2.5 text-xs text-slate-500">
                                        <span class="flex items-center gap-1 font-semibold text-slate-800 bg-slate-200/60 px-2 py-0.5 rounded">
                                            17.00 WIB
                                        </span>
                                        <span class="text-slate-300">|</span>
                                        <span>
                                            Super Executive (HiAce)
                                        </span>
                                        <span class="text-slate-300">|</span>
                                        <span class="text-status-success font-medium flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-status-success inline-block"></span>
                                            Ada Kursi
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center md:flex-col md:items-end justify-between md:justify-center border-t md:border-t-0 border-slate-200/60 pt-3 md:pt-0 gap-2">
                                <div class="text-left md:text-right">
                                    <span class="text-xs text-slate-400 block">Mulai dari</span>
                                    <span class="text-base font-extrabold text-brand-600">Rp 150.000</span>
                                </div>
                                <a href="#" class="px-4 py-2 text-xs font-semibold text-slate-900 bg-gold-50/80 hover:bg-gold-100/80 border border-gold-200/60 rounded-lg shadow-xs transition-colors flex items-center gap-1">
                                    Lihat Jadwal
                                </a>
                            </div>
                        </div>

                        <!-- Card 3: Bukittinggi -> Padang -->
                        <div class="group relative bg-slate-50 hover:bg-white rounded-2xl border border-slate-200/60 p-5 transition-all duration-300 hover:shadow-card hover:border-gold-500/30 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gold-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <div class="flex items-start gap-4">
                                <div class="mt-1 flex items-center justify-center w-8 h-8 rounded-lg bg-gold-100 text-gold-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900 text-sm md:text-base">Bukittinggi</span>
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path></svg>
                                        <span class="font-bold text-slate-900 text-sm md:text-base">Padang</span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2.5 text-xs text-slate-500">
                                        <span class="flex items-center gap-1 font-semibold text-slate-800 bg-slate-200/60 px-2 py-0.5 rounded">
                                            09.00 WIB
                                        </span>
                                        <span class="text-slate-300">|</span>
                                        <span>
                                            Standard Class (Luxio)
                                        </span>
                                        <span class="text-slate-300">|</span>
                                        <span class="text-status-pending font-medium flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-status-pending inline-block animate-pulse"></span>
                                            Hampir Penuh
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center md:flex-col md:items-end justify-between md:justify-center border-t md:border-t-0 border-slate-200/60 pt-3 md:pt-0 gap-2">
                                <div class="text-left md:text-right">
                                    <span class="text-xs text-slate-400 block">Mulai dari</span>
                                    <span class="text-base font-extrabold text-brand-600">Rp 120.000</span>
                                </div>
                                <a href="#" class="px-4 py-2 text-xs font-semibold text-slate-900 bg-gold-50/80 hover:bg-gold-100/80 border border-gold-200/60 rounded-lg shadow-xs transition-colors flex items-center gap-1">
                                    Lihat Jadwal
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Extra Premium Value Propositions section below -->
        <div class="mt-16 border-t border-slate-200 pt-12">
            <h3 class="text-lg font-bold text-slate-900 text-center mb-8">Kenapa Memilih Layanan RTM Family?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Point 1 -->
                <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm flex items-start gap-4">
                    <div class="p-3 rounded-xl bg-brand-50 text-brand-500 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">Armada Bersih & Nyaman</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Kendaraan model terbaru dengan AC dingin, kursi ergonomis, dan sanitasi terjaga di setiap rute.</p>
                    </div>
                </div>

                <!-- Point 2 -->
                <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm flex items-start gap-4">
                    <div class="p-3 rounded-xl bg-gold-50 text-gold-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">Jadwal Tepat Waktu</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Berangkat sesuai jadwal yang telah ditentukan. Menjamin Anda sampai tujuan tepat pada waktunya.</p>
                    </div>
                </div>

                <!-- Point 3 -->
                <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm flex items-start gap-4">
                    <div class="p-3 rounded-xl bg-emerald-50 text-status-success shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">Sopir Profesional</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Sopir berpengalaman, ramah, dan bersertifikasi untuk memastikan kenyamanan & keamanan berkendara.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Client-side Validation and Notification Toast Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('ticket-search-form');
        const asal = document.getElementById('asal');
        const tujuan = document.getElementById('tujuan');
        const tanggal = document.getElementById('tanggal');

        // Function to create and show premium toast using top transition offset
        function showToast(message) {
            let toast = document.getElementById('search-validation-toast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'search-validation-toast';
                toast.className = 'fixed top-[-80px] left-1/2 -translate-x-1/2 z-50 flex items-center gap-2 px-5 py-3.5 bg-slate-900 border border-gold-500/40 text-white text-xs font-bold rounded-2xl shadow-xl transition-all duration-500 opacity-0';
                toast.innerHTML = `
                    <span class="text-gold-400 text-sm">⚠️</span>
                    <span id="toast-text"></span>
                `;
                document.body.appendChild(toast);
            }
            document.getElementById('toast-text').textContent = message;

            // Slide down from -80px to 20px (top-5) and Fade in
            setTimeout(() => {
                toast.classList.remove('top-[-80px]', 'opacity-0');
                toast.classList.add('top-5', 'opacity-100');
            }, 50);

            // Slide back up and Fade out after 3.5s
            setTimeout(() => {
                toast.classList.remove('top-5', 'opacity-100');
                toast.classList.add('top-[-80px]', 'opacity-0');
            }, 3500);
        }

        // Add helper function to clear error borders on input/change
        [asal, tujuan, tanggal].forEach(input => {
            input.addEventListener('change', function () {
                this.classList.remove('border-status-danger', 'ring-2', 'ring-status-danger/10');
                this.classList.add('border-slate-200');
            });
            input.addEventListener('input', function () {
                this.classList.remove('border-status-danger', 'ring-2', 'ring-status-danger/10');
                this.classList.add('border-slate-200');
            });
        });

        form.addEventListener('submit', function (e) {
            let errors = [];
            
            if (!asal.value) {
                asal.classList.remove('border-slate-200');
                asal.classList.add('border-status-danger', 'ring-2', 'ring-status-danger/10');
                errors.push('Kota Asal');
            }
            if (!tujuan.value) {
                tujuan.classList.remove('border-slate-200');
                tujuan.classList.add('border-status-danger', 'ring-2', 'ring-status-danger/10');
                errors.push('Kota Tujuan');
            }
            if (!tanggal.value) {
                tanggal.classList.remove('border-slate-200');
                tanggal.classList.add('border-status-danger', 'ring-2', 'ring-status-danger/10');
                errors.push('Tanggal Perjalanan');
            }

            if (errors.length > 0) {
                e.preventDefault(); // Stop form submission
                
                let message = 'Lengkapi ' + errors.join(', ') + ' Anda untuk mencari jadwal!';
                showToast(message);
            }
        });
    });
</script>
@endsection
