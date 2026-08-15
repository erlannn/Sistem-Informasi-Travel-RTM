<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Travel RTM Family - Perjalanan Premium & Nyaman</title>

    <!-- Traveloka-Style Modern Web Typography: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-black bg-slate-50 selection:bg-brand-500 selection:text-black">

    <!-- Floating Navbar with Blur Kaca (Frosted Glassmorphism - Compact) -->
    <header class="fixed top-3 sm:top-4 left-0 right-0 z-50 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="w-full bg-slate-950/60 backdrop-blur-2xl backdrop-saturate-150 border-t border-t-white/30 border-b border-b-white/10 border-x border-x-white/20 rounded-2xl shadow-2xl shadow-black/40 transition-all duration-300">
            <div class="px-5 sm:px-7 py-2.5 sm:py-3 flex items-center justify-between">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group active:scale-95 transition-transform">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Travel RTM" class="h-10 sm:h-11 md:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105 drop-shadow-lg shrink-0">
                        <div class="text-left">
                            <span class="block font-black text-base sm:text-lg tracking-wider text-white uppercase leading-none group-hover:text-amber-400 group-active:text-amber-300 transition-colors drop-shadow-sm">Travel RTM</span>
                            <span class="block text-[8px] sm:text-[9px] text-amber-400 font-extrabold tracking-widest uppercase mt-0.5">RTM Family</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center gap-7">
                    <a href="#beranda" class="text-xs sm:text-[13px] font-bold text-slate-100 hover:text-amber-400 active:text-amber-300 active:scale-95 tracking-wide uppercase transition-all drop-shadow-sm">Beranda</a>
                    <a href="#jadwal" class="text-xs sm:text-[13px] font-bold text-slate-100 hover:text-amber-400 active:text-amber-300 active:scale-95 tracking-wide uppercase transition-all drop-shadow-sm">Jadwal</a>
                    <a href="#layanan" class="text-xs sm:text-[13px] font-bold text-slate-100 hover:text-amber-400 active:text-amber-300 active:scale-95 tracking-wide uppercase transition-all drop-shadow-sm">Layanan</a>
                    <a href="#armada" class="text-xs sm:text-[13px] font-bold text-slate-100 hover:text-amber-400 active:text-amber-300 active:scale-95 tracking-wide uppercase transition-all drop-shadow-sm">Armada</a>
                    <a href="#faq" class="text-xs sm:text-[13px] font-bold text-slate-100 hover:text-amber-400 active:text-amber-300 active:scale-95 tracking-wide uppercase transition-all drop-shadow-sm">FAQ</a>
                    <a href="#kontak" class="text-xs sm:text-[13px] font-bold text-slate-100 hover:text-amber-400 active:text-amber-300 active:scale-95 tracking-wide uppercase transition-all drop-shadow-sm">Kontak</a>
                </div>

                <!-- Auth Buttons (Desktop) -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-xs sm:text-[13px] font-bold text-slate-100 hover:text-amber-400 active:text-amber-300 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 active:bg-white/30 border border-white/20 backdrop-blur-md active:scale-95 transition-all uppercase tracking-wider">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2 text-xs sm:text-[13px] font-extrabold text-slate-950 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 rounded-xl active:scale-95 transition-all uppercase tracking-wider shadow-sm">
                        Daftar Akun
                    </a>
                </div>

                <!-- Mobile Hamburger Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" onclick="toggleMobileDrawer()" class="text-white hover:text-amber-400 active:text-amber-300 active:scale-90 p-2 focus:outline-none transition-all" aria-label="Toggle menu">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Drawer Menu (Frosted Glass) -->
    <div id="mobile-drawer" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-sm transition-opacity duration-300">
        <div class="fixed top-0 right-0 w-80 max-w-full h-full bg-slate-950/95 backdrop-blur-2xl border-l border-white/15 shadow-2xl p-6 flex flex-col justify-between">
            <div class="space-y-8">
                <!-- Header of mobile drawer -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3.5">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Travel RTM" class="h-12 w-auto object-contain shrink-0 drop-shadow-md">
                        <div>
                            <span class="block font-black text-base text-white tracking-wider uppercase">Travel RTM</span>
                            <span class="block text-[9px] text-amber-400 font-extrabold tracking-widest uppercase">RTM Family</span>
                        </div>
                    </div>
                    <button type="button" onclick="toggleMobileDrawer()" class="text-slate-400 hover:text-white active:scale-90 p-1.5 transition-all">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </div>

                <!-- Navigation Links inside Mobile Drawer -->
                <div class="flex flex-col gap-4">
                    <a href="#beranda" onclick="toggleMobileDrawer()" class="text-base font-bold text-slate-200 hover:text-amber-400 active:text-amber-300 active:translate-x-1.5 transition-all py-2.5 border-b border-white/10">Beranda</a>
                    <a href="#jadwal" onclick="toggleMobileDrawer()" class="text-base font-bold text-slate-200 hover:text-amber-400 active:text-amber-300 active:translate-x-1.5 transition-all py-2.5 border-b border-white/10">Jadwal</a>
                    <a href="#layanan" onclick="toggleMobileDrawer()" class="text-base font-bold text-slate-200 hover:text-amber-400 active:text-amber-300 active:translate-x-1.5 transition-all py-2.5 border-b border-white/10">Layanan</a>
                    <a href="#armada" onclick="toggleMobileDrawer()" class="text-base font-bold text-slate-200 hover:text-amber-400 active:text-amber-300 active:translate-x-1.5 transition-all py-2.5 border-b border-white/10">Armada</a>
                    <a href="#faq" onclick="toggleMobileDrawer()" class="text-base font-bold text-slate-200 hover:text-amber-400 active:text-amber-300 active:translate-x-1.5 transition-all py-2.5 border-b border-white/10">FAQ</a>
                    <a href="#kontak" onclick="toggleMobileDrawer()" class="text-base font-bold text-slate-200 hover:text-amber-400 active:text-amber-300 active:translate-x-1.5 transition-all py-2.5 border-b border-white/10">Kontak</a>
                </div>
            </div>

            <!-- Auth Action inside Mobile Drawer -->
            <div class="space-y-3 pt-6 border-t border-white/10">
                <a href="{{ route('login') }}" class="block w-full text-center py-3.5 text-sm font-bold text-white bg-slate-900 border border-white/15 hover:border-amber-400/50 active:bg-slate-800 active:scale-98 rounded-xl transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center py-3.5 text-sm font-extrabold text-slate-950 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-98 rounded-xl transition">
                    Daftar Akun
                </a>
            </div>
        </div>
    </div>

    <!-- Traveloka-Style Hero Section with Rich Background Image -->
    <section id="beranda" class="relative pt-36 pb-24 md:pt-48 md:pb-32 overflow-hidden border-b border-slate-200/80 min-h-[92vh] flex items-center bg-slate-950">
        <!-- Background Image with Static Cinematic Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-travel.png') }}" alt="Background Travel RTM" class="w-full h-full object-cover object-center">
            <!-- Static clean contrast overlay -->
            <div class="absolute inset-0 bg-linear-to-b from-slate-950/85 via-slate-950/65 to-slate-950/90"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-10">
                
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight uppercase drop-shadow-lg">
                    Pesan Tiket Travel Jadi <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-linear-to-r from-amber-400 via-amber-300 to-amber-400">Lebih Mudah & Nyaman</span>
                </h1>
                
                <p class="text-sm sm:text-base text-slate-200 max-w-2xl mx-auto font-normal leading-relaxed drop-shadow-md">
                    Nikmati perjalanan rute Sijunjung, Padang, Solok dengan kepastian jadwal, kursi nyaman, dan supir profesional.
                </p>

            </div>

            <!-- Traveloka Search & Booking Widget (Floating White Card) -->
            <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-2xl shadow-black/40 border border-slate-200/90 overflow-hidden">
                
                <!-- Booking Header Bar (Traveloka Style White) -->
                <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/90 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-base font-bold border border-amber-500/20">
                            <i class="fa-solid fa-van-shuttle"></i>
                        </div>
                        <div>
                            <span class="text-xs sm:text-sm font-black text-black uppercase tracking-wide">Cari & Pesan Tiket Travel</span>
                         
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-[11px] font-extrabold text-amber-900 bg-amber-100/90 border border-amber-200 px-3.5 py-1 rounded-full uppercase tracking-wider shadow-2xs">
                        <i class="fa-solid fa-circle-check text-amber-600"></i> Online Booking
                    </div>
                </div>

                <!-- Main Travel Search Panel -->
                <div class="p-6 sm:p-8 bg-white">
                    <form action="{{ url('/') }}#jadwal" method="GET" class="space-y-6">
                        
                        <!-- Search Fields Grid (Traveloka Style Connected Input Blocks - White) -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 lg:gap-4 items-center">
                            
                            <!-- Dari (Kota Asal) -->
                            <div class="md:col-span-5 relative bg-slate-50 hover:bg-slate-100/90 border border-slate-200/90 hover:border-amber-500 rounded-2xl p-4 transition-all focus-within:ring-2 focus-within:ring-amber-500/30 focus-within:border-amber-500 focus-within:bg-white group">
                                <label for="asal" class="flex items-center gap-1.5 text-[11px] font-black uppercase tracking-wider text-black group-focus-within:text-amber-600 mb-1.5 cursor-pointer">
                                    <i class="fa-solid fa-location-dot text-amber-500 text-xs"></i> Dari (Kota Asal)
                                </label>
                                <div class="relative">
                                    <select id="asal" name="asal" class="w-full bg-transparent font-extrabold text-sm sm:text-base text-black focus:outline-none cursor-pointer appearance-none pr-6">
                                        <option value="">Pilih Kota Asal (Semua)...</option>
                                        @foreach($lokasiAsal as $item)
                                            <option value="{{ $item }}" {{ request('asal') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute right-0 top-1/2 -translate-y-1/2 pointer-events-none text-black">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </span>
                                </div>
                                <span class="block text-[11px] text-black font-normal mt-1">Titik jemput / Pool</span>
                            </div>

                            <!-- Swap Locations Button (Floating Center Pill) -->
                            <div class="md:col-span-1 flex justify-center -my-2 md:my-0">
                                <button type="button" onclick="swapLocations()" class="w-11 h-11 rounded-full bg-white border-2 border-slate-200 hover:border-amber-500 hover:bg-amber-50 active:bg-amber-100 text-black hover:text-amber-600 active:scale-90 flex items-center justify-center shadow-md transition-all hover:scale-105 cursor-pointer z-10" title="Tukar Kota Asal & Tujuan">
                                    <i class="fa-solid fa-right-left text-sm"></i>
                                </button>
                            </div>

                            <!-- Ke (Kota Tujuan) -->
                            <div class="md:col-span-6 relative bg-slate-50 hover:bg-slate-100/90 border border-slate-200/90 hover:border-amber-500 rounded-2xl p-4 transition-all focus-within:ring-2 focus-within:ring-amber-500/30 focus-within:border-amber-500 focus-within:bg-white group">
                                <label for="tujuan" class="flex items-center gap-1.5 text-[11px] font-black uppercase tracking-wider text-black group-focus-within:text-amber-600 mb-1.5 cursor-pointer">
                                    <i class="fa-solid fa-location-crosshairs text-amber-500 text-xs"></i> Ke (Kota Tujuan)
                                </label>
                                <div class="relative">
                                    <select id="tujuan" name="tujuan" class="w-full bg-transparent font-extrabold text-sm sm:text-base text-black focus:outline-none cursor-pointer appearance-none pr-6">
                                        <option value="">Pilih Kota Tujuan (Semua)...</option>
                                        @foreach($lokasiTujuan as $item)
                                            <option value="{{ $item }}" {{ request('tujuan') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute right-0 top-1/2 -translate-y-1/2 pointer-events-none text-black">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </span>
                                </div>
                                <span class="block text-[11px] text-black font-normal mt-1">Titik antar / Destinasi</span>
                            </div>

                        </div>

                        <!-- Date & Action Row -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 lg:gap-4 items-center pt-1">
                            
                            <!-- Tanggal Perjalanan -->
                            <div class="md:col-span-7 bg-slate-50 hover:bg-slate-100/90 border border-slate-200/90 hover:border-amber-500 rounded-2xl p-4 transition-all focus-within:ring-2 focus-within:ring-amber-500/30 focus-within:border-amber-500 focus-within:bg-white group">
                                <div class="flex items-center justify-between mb-1.5">
                                    <label for="tanggal" class="flex items-center gap-1.5 text-[11px] font-black uppercase tracking-wider text-black group-focus-within:text-amber-600 cursor-pointer">
                                        <i class="fa-solid fa-calendar-days text-amber-500 text-xs"></i> Tanggal Berangkat
                                    </label>
                                    
                                    <!-- Quick Date Chips (Traveloka Style White) -->
                                    <div class="flex items-center gap-1.5">
                                        <button type="button" onclick="setDateOffset(0)" class="text-[11px] font-extrabold px-2.5 py-1 rounded-md bg-white border border-slate-200 hover:border-amber-400 hover:text-amber-700 active:bg-amber-100 active:scale-95 text-black transition shadow-2xs">Hari Ini</button>
                                        <button type="button" onclick="setDateOffset(1)" class="text-[11px] font-extrabold px-2.5 py-1 rounded-md bg-white border border-slate-200 hover:border-amber-400 hover:text-amber-700 active:bg-amber-100 active:scale-95 text-black transition shadow-2xs">Besok</button>
                                        <button type="button" onclick="setDateOffset(2)" class="text-[11px] font-extrabold px-2.5 py-1 rounded-md bg-white border border-slate-200 hover:border-amber-400 hover:text-amber-700 active:bg-amber-100 active:scale-95 text-black transition shadow-2xs">Lusa</button>
                                    </div>
                                </div>
                                <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}" min="{{ date('Y-m-d') }}" class="w-full bg-transparent font-extrabold text-sm sm:text-base text-black focus:outline-none cursor-pointer">
                            </div>

                            <!-- Tombol Cari Tiket -->
                            <div class="md:col-span-5 flex items-center">
                                <button type="submit" class="w-full py-4 px-6 text-sm sm:text-base font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-[0.98] rounded-2xl transition-all flex items-center justify-center gap-3 cursor-pointer uppercase tracking-wider shadow-sm">
                                    <i class="fa-solid fa-magnifying-glass text-base"></i>
                                    <span>Cari Tiket Travel</span>
                                </button>
                            </div>

                        </div>

                        <!-- Popular Route Pills (Traveloka Quick Shortcuts) -->
                        <div class="pt-3 flex items-center flex-wrap gap-2.5 text-xs border-t border-slate-100">
                            <span class="text-black font-extrabold flex items-center gap-1.5 text-xs uppercase tracking-wider">
                                <i class="fa-solid fa-fire text-amber-500"></i> Rute Populer:
                            </span>
                            <button type="button" onclick="setQuickRoute('Sijunjung', 'Padang')" class="px-3.5 py-1.5 rounded-full bg-slate-100 hover:bg-amber-100 hover:border-amber-300 hover:text-amber-900 active:bg-amber-200 active:scale-95 text-black font-semibold transition cursor-pointer border border-slate-200">
                                Sijunjung ⇄ Padang
                            </button>
                            <button type="button" onclick="setQuickRoute('Padang', 'Sijunjung')" class="px-3.5 py-1.5 rounded-full bg-slate-100 hover:bg-amber-100 hover:border-amber-300 hover:text-amber-900 active:bg-amber-200 active:scale-95 text-black font-semibold transition cursor-pointer border border-slate-200">
                                Padang ⇄ Sijunjung
                            </button>
                            <button type="button" onclick="setQuickRoute('Padang', 'Solok')" class="px-3.5 py-1.5 rounded-full bg-slate-100 hover:bg-amber-100 hover:border-amber-300 hover:text-amber-900 active:bg-amber-200 active:scale-95 text-black font-semibold transition cursor-pointer border border-slate-200">
                                Padang ⇄ Solok
                            </button>
                            <button type="button" onclick="setQuickRoute('Sijunjung', 'Bukittinggi')" class="px-3.5 py-1.5 rounded-full bg-slate-100 hover:bg-amber-100 hover:border-amber-300 hover:text-amber-900 active:bg-amber-200 active:scale-95 text-black font-semibold transition cursor-pointer border border-slate-200">
                                Sijunjung ⇄ Bukittinggi
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </section>

    <!-- Schedule Section (Jadwal) -->
    <section id="jadwal" class="py-24 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block text-[11px] font-extrabold uppercase tracking-widest text-brand-700 bg-brand-50 px-3.5 py-1.5 rounded-full border border-brand-200 mb-3 shadow-2xs">
                    Informasi Terupdate
                </span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-black tracking-tight uppercase">Jadwal Keberangkatan Travel</h2>
                <p class="mt-3 text-sm sm:text-base text-black leading-relaxed font-normal">
                    Silakan pilih jadwal keberangkatan yang sesuai. Anda harus masuk (login) ke dalam sistem terlebih dahulu untuk memilih kursi dan memproses pemesanan tiket.
                </p>
                <div class="w-12 h-1 bg-brand-500 rounded-full mx-auto mt-4"></div>
            </div>

            <!-- Active Search Badge -->
            @if(request('asal') || request('tujuan') || request('tanggal'))
                <div class="mb-10 p-4 sm:p-5 bg-amber-50 border border-amber-200 rounded-2xl flex items-center justify-between flex-wrap gap-4 shadow-sm">
                    <div class="flex items-center gap-2 text-xs sm:text-sm text-black font-semibold">
                        <i class="fa-solid fa-filter text-amber-600 text-sm animate-bounce"></i>
                        <span>Menampilkan hasil filter: </span>
                        @if(request('asal')) <span class="bg-amber-200/80 px-2.5 py-0.5 rounded font-black text-black">Asal "{{ request('asal') }}"</span> @endif
                        @if(request('tujuan')) <span class="bg-amber-200/80 px-2.5 py-0.5 rounded font-black text-black">Tujuan "{{ request('tujuan') }}"</span> @endif
                        @if(request('tanggal')) <span class="bg-amber-200/80 px-2.5 py-0.5 rounded font-black text-black">Tanggal "{{ date('d M Y', strtotime(request('tanggal'))) }}"</span> @endif
                        <span class="text-black font-normal">({{ $jadwals->count() }} Jadwal ditemukan)</span>
                    </div>
                    <a href="{{ url('/') }}#jadwal" class="text-xs font-bold text-black bg-white hover:bg-slate-100 active:scale-95 border border-slate-300 px-4 py-2 rounded-xl shadow-sm transition">
                        Reset Pencarian
                    </a>
                </div>
            @endif

            <!-- Schedules Grid (Ticket Pass Card Layout) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($jadwals as $j)
                    @php
                        // Hitung ketersediaan kursi
                        $totalKursi = $j->kursis->count() > 0 ? $j->kursis->count() : 6; 
                        $terisi = $j->kursis->where('status', 'Terisi')->count();
                        $tersedia = $totalKursi - $terisi;
                        if($tersedia < 0) $tersedia = 0;
                    @endphp
                    <div class="group relative bg-white hover:-translate-y-1.5 rounded-3xl border border-slate-200 p-6 sm:p-7 transition-all duration-300 hover:shadow-xl hover:border-brand-500/50 flex flex-col justify-between overflow-hidden">
                        
                        <!-- Left Notch ticket cutout -->
                        <div class="absolute -left-3.5 top-[60%] -translate-y-1/2 w-7 h-7 bg-slate-50 border-r border-slate-200 rounded-full z-10"></div>
                        <!-- Right Notch ticket cutout -->
                        <div class="absolute -right-3.5 top-[60%] -translate-y-1/2 w-7 h-7 bg-slate-50 border-l border-slate-200 rounded-full z-10"></div>

                        <!-- Top Accent Bar -->
                        <div class="absolute left-0 right-0 top-0 h-1.5 bg-slate-950 group-hover:bg-brand-500 transition-colors"></div>
                        
                        <div class="space-y-5">
                            <!-- Route Timeline -->
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <div class="flex items-center gap-3 w-full justify-between pr-2">
                                    <div class="text-left">
                                        <span class="block text-[10px] text-black uppercase tracking-widest font-black">Keberangkatan</span>
                                        <span class="font-black text-black text-base sm:text-lg tracking-tight">{{ $j->asal }}</span>
                                    </div>
                                    
                                    <!-- Route Line Icon -->
                                    <div class="flex-1 flex items-center justify-center px-2 relative">
                                        <div class="w-full border-t border-slate-300 border-dashed absolute top-1/2 left-0 right-0 z-0"></div>
                                        <div class="relative z-10 px-2 bg-white text-brand-600 flex gap-1.5 items-center">
                                            <i class="fa-solid fa-circle-dot text-[8px]"></i>
                                            <i class="fa-solid fa-bus text-sm animate-pulse"></i>
                                            <i class="fa-solid fa-location-dot text-[10px] text-black"></i>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <span class="block text-[10px] text-black uppercase tracking-widest font-black">Tujuan</span>
                                        <span class="font-black text-black text-base sm:text-lg tracking-tight">{{ $j->tujuan }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Details (Grid) -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center text-xs sm:text-sm gap-2.5">
                                    <div class="w-8 h-8 bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-center text-black shrink-0">
                                        <i class="fa-regular fa-calendar-days text-xs"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <span class="block text-[10px] text-black uppercase tracking-wider font-bold">Tanggal</span>
                                        <span class="font-extrabold text-black block truncate">{{ date('d M Y', strtotime($j->tanggal)) }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center text-xs sm:text-sm gap-2.5">
                                    <div class="w-8 h-8 bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-center text-black shrink-0">
                                        <i class="fa-regular fa-clock text-xs"></i>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] text-black uppercase tracking-wider font-bold">Keberangkatan</span>
                                        <span class="font-black text-black block">{{ date('H:i', strtotime($j->jam)) }} WIB</span>
                                    </div>
                                </div>

                                <div class="flex items-center text-xs sm:text-sm gap-2.5 col-span-2">
                                    <div class="w-8 h-8 bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-center text-black shrink-0">
                                        <i class="fa-solid fa-car text-xs"></i>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] text-black uppercase tracking-wider font-bold">Tipe Kendaraan</span>
                                        <span class="font-bold text-black block">{{ $j->armada ? $j->armada->merk . ' (' . $j->armada->warna . ')' : 'Toyota Avanza' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Perforated ticket dividing line (aligned with notches) -->
                            <div class="relative border-t border-dashed border-slate-200 my-2"></div>

                            <!-- Seat Availability (Progress Bar) -->
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs font-semibold text-black">
                                    <span>Sisa Kursi: <strong class="text-black font-black text-sm">{{ $tersedia }}</strong>/{{ $totalKursi }}</span>
                                    @if($tersedia <= 3 && $tersedia > 0)
                                        <span class="text-amber-700 font-black animate-pulse">Sisa Sedikit!</span>
                                    @elseif($tersedia == 0)
                                        <span class="text-rose-600 font-black">Penuh</span>
                                    @else
                                        <span class="text-emerald-700 font-black">Tersedia</span>
                                    @endif
                                </div>
                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden border border-slate-200/60">
                                    @php
                                        $persenTersedia = ($tersedia / $totalKursi) * 100;
                                        $barColor = $persenTersedia <= 30 ? 'bg-amber-500' : 'bg-emerald-500';
                                        if($tersedia == 0) $barColor = 'bg-rose-500';
                                    @endphp
                                    <div class="h-full {{ $barColor }} transition-all duration-500" style="width: {{ $persenTersedia }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Price & Book Button -->
                        <div class="mt-6 pt-4 flex items-center justify-between gap-4 border-t border-slate-100">
                            <div>
                                <span class="block text-[10px] text-black uppercase tracking-widest font-black">Harga Tiket</span>
                                <span class="text-lg sm:text-xl font-black text-brand-600">Rp {{ number_format($j->harga, 0, ',', '.') }}</span>
                            </div>
                            
                            @if($tersedia > 0)
                                <a href="{{ route('login', ['redirect' => 'booking', 'id_jadwal' => $j->id_jadwal]) }}" class="px-5 py-3 text-xs sm:text-sm font-extrabold text-white bg-slate-950 hover:bg-amber-400 hover:text-slate-950 active:bg-amber-500 active:scale-95 rounded-xl border border-slate-800 shadow-sm transition-all duration-200 cursor-pointer">
                                    Pesan Tiket
                                </a>
                            @else
                                <button disabled class="px-5 py-3 text-xs sm:text-sm font-bold text-slate-400 bg-slate-100 rounded-xl border border-slate-200 cursor-not-allowed">
                                    Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 border border-slate-200 rounded-full flex items-center justify-center text-black mx-auto mb-4">
                            <i class="fa-solid fa-calendar-xmark text-2xl text-amber-500"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-black uppercase">Jadwal Perjalanan Tidak Ditemukan</h3>
                        <p class="text-sm text-black mt-2 max-w-md mx-auto leading-relaxed font-normal">
                            Maaf, tidak ada jadwal keberangkatan untuk kriteria pencarian Anda saat ini. Silakan ubah kriteria filter pencarian.
                        </p>
                        @if(request('asal') || request('tujuan') || request('tanggal'))
                            <a href="{{ url('/') }}#jadwal" class="inline-block mt-6 px-6 py-3 text-xs sm:text-sm font-extrabold text-white bg-slate-950 hover:bg-amber-400 hover:text-slate-950 active:scale-95 rounded-xl shadow transition-all">
                                Lihat Semua Jadwal
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Services / Layanan Section -->
    <section id="layanan" class="py-24 bg-white border-b border-slate-200 text-black relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block text-[10px] font-extrabold uppercase tracking-widest text-brand-600 bg-brand-50 border border-brand-100 px-3 py-1 rounded-full mb-3">
                    Kenapa Memilih Kami?
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-black tracking-tight uppercase">Keunggulan Layanan Travel RTM</h2>
                <p class="mt-3 text-sm text-black leading-relaxed font-normal">
                    Kenyamanan dan kepuasan perjalanan Anda adalah prioritas utama kami. Kami menyediakan fasilitas terbaik untuk menjamin perjalanan yang berkesan.
                </p>
                <div class="w-12 h-1 bg-brand-500 rounded-full mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Card 1 -->
                <div class="bg-slate-50 border border-slate-200/90 p-6 rounded-3xl hover:border-brand-500/50 hover:bg-white hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-brand-600 flex items-center justify-center text-xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-couch"></i>
                    </div>
                    <h3 class="text-sm font-extrabold text-black uppercase tracking-wider">Kenyamanan Eksekutif</h3>
                    <p class="mt-3 text-xs text-black leading-relaxed font-normal">
                        Dilengkapi dengan kursi ergonomis, AC dingin yang merata, serta ruang kaki yang luas di setiap baris.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-50 border border-slate-200/90 p-6 rounded-3xl hover:border-brand-500/50 hover:bg-white hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-brand-600 flex items-center justify-center text-xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-sm font-extrabold text-black uppercase tracking-wider">Keamanan Kelas Utama</h3>
                    <p class="mt-3 text-xs text-black leading-relaxed font-normal">
                        Seluruh armada dipelihara berkala,  dan dikemudikan oleh sopir profesional.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-50 border border-slate-200/90 p-6 rounded-3xl hover:border-brand-500/50 hover:bg-white hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-brand-600 flex items-center justify-center text-xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h3 class="text-sm font-extrabold text-black uppercase tracking-wider">Garansi Tepat Waktu</h3>
                    <p class="mt-3 text-xs text-black leading-relaxed font-normal">
                        Komitmen keberangkatan sesuai dengan jadwal. 
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="bg-slate-50 border border-slate-200/90 p-6 rounded-3xl hover:border-brand-500/50 hover:bg-white hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-brand-600 flex items-center justify-center text-xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-location-arrow"></i>
                    </div>
                    <h3 class="text-sm font-extrabold text-black uppercase tracking-wider">Layanan Antar Jemput</h3>
                    <p class="mt-3 text-xs text-black leading-relaxed font-normal">
                        Layanan point-to-point (pintu ke pintu) praktis yang memudahkan Anda dijemput dari lokasi rumah dan diantar langsung hingga ke titik alamat tujuan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fleet Section (Armada) -->
    <section id="armada" class="py-24 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block text-[11px] font-extrabold uppercase tracking-widest text-brand-700 bg-brand-50 px-3.5 py-1.5 rounded-full border border-brand-200 mb-3 shadow-2xs">
                    <i class="fa-solid fa-car-side text-brand-600 mr-1.5"></i> Armada Resmi RTM Family
                </span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-black tracking-tight uppercase">Pilihan Armada Tangguh & Nyaman</h2>
                <p class="mt-3 text-sm sm:text-base text-black leading-relaxed font-normal">
                    Travel RTM mengoperasikan total <strong>8 unit armada</strong> pilihan terbaik yang selalu bersih, terawat berkala, dan ber-AC dingin untuk memastikan perjalanan Anda di Sumatera Barat berlangsung aman dan berkesan.
                </p>
                <div class="w-12 h-1 bg-brand-500 rounded-full mx-auto mt-4"></div>
            </div>

            <!-- Fleet Models 4-Card Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                
                <!-- Fleet Card 1: Kijang Inova Reborn -->
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:border-amber-400/60 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Header Image with Unit Count -->
                        <div class="relative h-48 bg-slate-950 overflow-hidden group/img">
                            <img src="{{ asset('images/armada/innova-reborn.png') }}" alt="Kijang Inova Reborn" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-linear-to-t from-slate-950/70 via-slate-950/20 to-black/30"></div>
                            
                            <!-- Unit Badge -->
                            <span class="absolute top-3.5 right-3.5 bg-amber-400 text-slate-950 font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                                1 Unit Armada
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 sm:p-6 space-y-3.5">
                            <div>
                                <h3 class="text-base sm:text-lg font-black text-black group-hover:text-amber-700 transition-colors">Kijang Inova Reborn</h3>
                                <p class="text-xs text-black font-semibold mt-0.5">Kenyamanan Perjalanan & Suspensi Empuk</p>
                            </div>

                            <p class="text-xs sm:text-sm text-black font-normal leading-relaxed">
                                Armada dengan kabin senyap, ruang kaki lapang, dan kenyamanan suspensi prima untuk perjalanan jarak jauh.
                            </p>

                            <!-- Color Options -->
                            <div class="pt-3 border-t border-slate-100">
                                <span class="block text-[11px] font-black uppercase tracking-wider text-black mb-1.5">Warna Unit:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-black bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full bg-white border border-slate-400 shadow-2xs"></span> Putih
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Features -->
                    <div class="p-5 sm:p-6 pt-0">
                        <div class="border-t border-slate-100 pt-3.5 grid grid-cols-2 gap-2 text-xs text-black font-semibold">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-chair text-amber-500"></i> 7 Kursi</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-snowflake text-amber-500"></i> Double AC</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-plug text-amber-500"></i> Fast Charge</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-suitcase text-amber-500"></i> Bagasi Lega</span>
                        </div>
                    </div>
                </div>

                <!-- Fleet Card 2: Toyota Avanza -->
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:border-amber-400/60 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Header Image -->
                        <div class="relative h-48 bg-slate-950 overflow-hidden group/img">
                            <img src="{{ asset('images/armada/toyota-avanza.png') }}" alt="Toyota Avanza" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-linear-to-t from-slate-950/70 via-slate-950/20 to-black/30"></div>
                            
                            <!-- Unit Badge -->
                            <span class="absolute top-3.5 right-3.5 bg-amber-400 text-slate-950 font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                                2 Unit Armada
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 sm:p-6 space-y-3.5">
                            <div>
                                <h3 class="text-base sm:text-lg font-black text-black group-hover:text-amber-700 transition-colors">Toyota Avanza</h3>
                                <p class="text-xs text-black font-semibold mt-0.5">Mobil Tangguh & Nyaman</p>
                            </div>

                            <p class="text-xs sm:text-sm text-black font-normal leading-relaxed">
                                Kendaraan tangguh yang lincah menaklukkan rute Sijunjung, Solok, Padang dengan kabin bersih & nyaman.
                            </p>

                            <!-- Color Options -->
                            <div class="pt-3 border-t border-slate-100">
                                <span class="block text-[11px] font-black uppercase tracking-wider text-black mb-1.5">Warna Unit (2 Unit):</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-black bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full bg-pink-400 border border-pink-500 shadow-2xs"></span> Pink
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-black bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full bg-slate-900 border border-slate-700 shadow-2xs"></span> Hitam
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Features -->
                    <div class="p-5 sm:p-6 pt-0">
                        <div class="border-t border-slate-100 pt-3.5 grid grid-cols-2 gap-2 text-xs text-black font-semibold">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-chair text-amber-500"></i> 7 Kursi</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-snowflake text-amber-500"></i> Full AC</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-plug text-amber-500"></i> USB Port</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-music text-amber-500"></i> Audio</span>
                        </div>
                    </div>
                </div>

                <!-- Fleet Card 3: Daihatsu Xenia -->
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:border-amber-400/60 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Header Image -->
                        <div class="relative h-48 bg-slate-950 overflow-hidden group/img">
                            <img src="{{ asset('images/armada/daihatsu-xenia.png') }}" alt="Daihatsu Xenia" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-linear-to-t from-slate-950/70 via-slate-950/20 to-black/30"></div>
                            
                            <!-- Unit Badge -->
                            <span class="absolute top-3.5 right-3.5 bg-amber-400 text-slate-950 font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                                1 Unit Armada
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 sm:p-6 space-y-3.5">
                            <div>
                                <h3 class="text-base sm:text-lg font-black text-black group-hover:text-amber-700 transition-colors">Daihatsu Xenia</h3>
                                <p class="text-xs text-black font-semibold mt-0.5">Berkendara Stabil & Interior Nyaman</p>
                            </div>

                            <p class="text-xs sm:text-sm text-black font-normal leading-relaxed">
                                Pilihan armada yang stabil dengan kabin lega dan pendingin udara sejuk, memberikan pengalaman perjalanan yang rileks.
                            </p>

                            <!-- Color Options -->
                            <div class="pt-3 border-t border-slate-100">
                                <span class="block text-[11px] font-black uppercase tracking-wider text-black mb-1.5">Warna Unit:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-black bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full bg-[#c3b091] border border-[#a89476] shadow-2xs"></span> Khaki
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Features -->
                    <div class="p-5 sm:p-6 pt-0">
                        <div class="border-t border-slate-100 pt-3.5 grid grid-cols-2 gap-2 text-xs text-black font-semibold">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-chair text-amber-500"></i> 7 Kursi</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-snowflake text-amber-500"></i> Full AC</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-plug text-amber-500"></i> Charger HP</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-shield text-amber-500"></i> Aman & Prima</span>
                        </div>
                    </div>
                </div>

                <!-- Fleet Card 4: Toyota Calya -->
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:border-amber-400/60 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Header Image -->
                        <div class="relative h-48 bg-slate-950 overflow-hidden group/img">
                            <img src="{{ asset('images/armada/toyota-calya.png') }}" alt="Toyota Calya" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-linear-to-t from-slate-950/70 via-slate-950/20 to-black/30"></div>
                            
                            <!-- Unit Badge -->
                            <span class="absolute top-3.5 right-3.5 bg-amber-400 text-slate-950 font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                                4 Unit Armada
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 sm:p-6 space-y-3.5">
                            <div>
                                <h3 class="text-base sm:text-lg font-black text-black group-hover:text-amber-700 transition-colors">Toyota Calya</h3>
                                <p class="text-xs text-black font-semibold mt-0.5">Armada Gesit & Antar-Jemput Praktis</p>
                            </div>

                            <p class="text-xs sm:text-sm text-black font-normal leading-relaxed">
                                Armada terbanyak kami yang sangat lincah untuk penjemputan alamat door-to-door dengan kenyamanan kabin ber-AC penuh.
                            </p>

                            <!-- Color Options -->
                            <div class="pt-3 border-t border-slate-100">
                                <span class="block text-[11px] font-black uppercase tracking-wider text-black mb-1.5">Warna Unit (4 Unit):</span>
                                <div class="grid grid-cols-2 gap-1.5">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-black bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full bg-white border border-slate-400 shadow-2xs"></span> Putih
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-black bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full bg-slate-900 border border-slate-700 shadow-2xs"></span> Hitam
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-black bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full bg-slate-400 border border-slate-500 shadow-2xs"></span> Grey
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-black bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full bg-[#800000] border border-[#550000] shadow-2xs"></span> Maroon
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Features -->
                    <div class="p-5 sm:p-6 pt-0">
                        <div class="border-t border-slate-100 pt-3.5 grid grid-cols-2 gap-2 text-xs text-black font-semibold">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-chair text-amber-500"></i> 7 Kursi</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-snowflake text-amber-500"></i> Full AC</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-bolt text-amber-500"></i> USB Charger</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-amber-500"></i> Door-to-Door</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section (UI/UX enhancement) -->
    <section id="faq" class="py-24 bg-white border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            
            <div class="text-center mb-16">
                <span class="inline-block text-[11px] font-extrabold uppercase tracking-widest text-brand-700 bg-brand-50 px-3.5 py-1.5 rounded-full border border-brand-200 mb-3 shadow-2xs">
                    Tanya Jawab
                </span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-black tracking-tight uppercase">Pertanyaan Umum (FAQ)</h2>
                <p class="mt-3 text-sm sm:text-base text-black leading-relaxed font-normal">
                    Temukan jawaban cepat atas pertanyaan yang sering diajukan mengenai pemesanan tiket dan layanan kami.
                </p>
                <div class="w-12 h-1 bg-brand-500 rounded-full mx-auto mt-4"></div>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                    <button type="button" onclick="toggleAccordion(1)" class="w-full px-6 sm:px-7 py-5 text-left font-extrabold text-black text-sm sm:text-base flex items-center justify-between hover:bg-slate-100 active:bg-amber-100/60 transition-colors cursor-pointer">
                        <span>Bagaimana cara memesan tiket travel secara online?</span>
                        <i id="accordion-icon-1" class="fa-solid fa-chevron-down text-black text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="accordion-content-1" class="hidden px-6 sm:px-7 pb-6 text-xs sm:text-sm text-black leading-relaxed font-normal border-t border-slate-200 pt-4">
                        Penumpang perlu mendaftar akun/masuk ke dalam sistem, cari jadwal perjalanan yang sesuai di halaman utama, pilih nomor kursi kosong yang diinginkan, konfirmasi data penumpang, lalu e-tiket resmi berformat PDF akan otomatis diterbitkan dan lakukan pembayaran setelah sampai di tujuan.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                    <button type="button" onclick="toggleAccordion(2)" class="w-full px-6 sm:px-7 py-5 text-left font-extrabold text-black text-sm sm:text-base flex items-center justify-between hover:bg-slate-100 active:bg-amber-100/60 transition-colors cursor-pointer">
                        <span>Apakah armada Travel RTM memiliki AC dan Charger HP?</span>
                        <i id="accordion-icon-2" class="fa-solid fa-chevron-down text-black text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="accordion-content-2" class="hidden px-6 sm:px-7 pb-6 text-xs sm:text-sm text-black leading-relaxed font-normal border-t border-slate-200 pt-4">
                        Ya, seluruh 8 unit armada kami (Kijang Inova Reborn, Toyota Avanza, Daihatsu Xenia, dan Toyota Calya) selalu terjaga kebersihan dan performanya secara rutin, serta dilengkapi fasilitas Full AC sejuk di seluruh kabin, serta kursi nyaman.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                    <button type="button" onclick="toggleAccordion(3)" class="w-full px-6 sm:px-7 py-5 text-left font-extrabold text-black text-sm sm:text-base flex items-center justify-between hover:bg-slate-100 active:bg-amber-100/60 transition-colors cursor-pointer">
                        <span>Apakah ada layanan antar-jemput sampai alamat rumah?</span>
                        <i id="accordion-icon-3" class="fa-solid fa-chevron-down text-black text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="accordion-content-3" class="hidden px-6 sm:px-7 pb-6 text-xs sm:text-sm text-black leading-relaxed font-normal border-t border-slate-200 pt-4">
                        Ya, kami melayani sistem antar-jemput pintu ke pintu (point-to-point) untuk kota-kota tertentu dalam jangkauan rute operasional kami. Silakan hubungi customer service WhatsApp kami untuk konfirmasi detail alamat penjemputan Anda.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                    <button type="button" onclick="toggleAccordion(4)" class="w-full px-6 sm:px-7 py-5 text-left font-extrabold text-black text-sm sm:text-base flex items-center justify-between hover:bg-slate-100 active:bg-amber-100/60 transition-colors cursor-pointer">
                        <span>Bagaimana jika saya ingin mengubah jadwal keberangkatan?</span>
                        <i id="accordion-icon-4" class="fa-solid fa-chevron-down text-black text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="accordion-content-4" class="hidden px-6 sm:px-7 pb-6 text-xs sm:text-sm text-black leading-relaxed font-normal border-t border-slate-200 pt-4">
                        Perubahan jadwal (reschedule) atau pembatalan tiket dapat diproses secara langsung pada status pemesanan tiket atau secara manual dengan menghubungi customer service WhatsApp kami minimal 6 jam sebelum jam keberangkatan awal yang tertera pada tiket Anda.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact & Call to Action Section -->
    <section id="kontak" class="py-24 bg-slate-950 text-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-linear-to-r from-amber-500 via-amber-400 to-amber-500 rounded-3xl p-8 sm:p-12 md:p-14 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
                <!-- Decorative background shapes -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="space-y-4 max-w-xl text-left relative z-10">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight uppercase leading-tight text-slate-950">Ada Pertanyaan Perjalanan?</h2>
                    <p class="text-xs sm:text-sm md:text-base text-slate-950 font-bold leading-relaxed">
                        Hubungi customer service kami via WhatsApp untuk bantuan pemesanan tiket perjalanan, informasi jadwal keberangkatan, atau konsultasi rute perjalanan Anda.
                    </p>
                </div>

                <div class="relative z-10 shrink-0">
                    <a href="https://wa.me/628123456789" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 text-xs sm:text-sm font-black text-white bg-slate-950 hover:bg-slate-900 active:bg-black active:scale-95 rounded-2xl shadow-xl transition-all uppercase tracking-wider">
                        <i class="fa-brands fa-whatsapp text-xl text-emerald-400 animate-bounce"></i> Hubungi WhatsApp
                    </a>
                </div>
            </div>

            <!-- Address and office details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-20 text-slate-300 text-xs sm:text-sm font-normal">
                <div class="space-y-3 p-5 rounded-2xl bg-white/5 border border-white/10 hover:border-amber-400/40 transition">
                    <h4 class="text-xs sm:text-sm font-black text-white uppercase tracking-widest border-l-3 border-amber-400 pl-2.5">Kantor Pusat Sijunjung</h4>
                    <p class="leading-relaxed text-slate-300">
                        Jl. Lintas Sumatera KM 110, Muaro Sijunjung, Sumatera Barat.<br>
                        <span class="text-amber-400 font-bold">Telepon:</span> (0754) 123456
                    </p>
                </div>
                <div class="space-y-3 p-5 rounded-2xl bg-white/5 border border-white/10 hover:border-amber-400/40 transition">
                    <h4 class="text-xs sm:text-sm font-black text-white uppercase tracking-widest border-l-3 border-amber-400 pl-2.5">Kantor Perwakilan Padang</h4>
                    <p class="leading-relaxed text-slate-300">
                        Jl. Dr. Hamka No. 42 (Dekat Kampus UNP), Air Tawar, Padang, Sumatera Barat.<br>
                        <span class="text-amber-400 font-bold">Telepon:</span> (0751) 987654
                    </p>
                </div>
                <div class="space-y-3 p-5 rounded-2xl bg-white/5 border border-white/10 hover:border-amber-400/40 transition">
                    <h4 class="text-xs sm:text-sm font-black text-white uppercase tracking-widest border-l-3 border-amber-400 pl-2.5">Jam Layanan</h4>
                    <p class="leading-relaxed text-slate-300">
                        Senin - Minggu: 06:00 - 22:00 WIB<br>
                        <span class="text-amber-400 font-bold">Pemesanan online:</span> Aktif 24 Jam Penuh
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (UI/UX Enhanced with Distinct Click States) -->
    <footer class="bg-slate-950 text-slate-300 pt-16 pb-10 border-t border-white/10 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Main Footer Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-white/10">
                
                <!-- Col 1: Brand Info -->
                <div class="lg:col-span-4 space-y-4">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group active:scale-95 transition-transform inline-flex">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Travel RTM" class="h-12 w-auto object-contain shrink-0 drop-shadow-md">
                        <div class="text-left">
                            <span class="block font-black text-lg text-white tracking-widest uppercase group-hover:text-amber-400 group-active:text-amber-300 transition-colors">Travel RTM</span>
                            <span class="block text-[9px] text-amber-400 font-black tracking-widest uppercase">RTM Family</span>
                        </div>
                    </a>
                    <p class="text-xs text-slate-400 leading-relaxed font-normal">
                        Layanan transportasi  antarkota di Sumatera Barat dengan komitmen ketepatan waktu, kenyamanan kabin ber-AC, dan kemudahan pemesanan e-tiket online terpercaya.
                    </p>
                 
                </div>

                <!-- Col 2: Quick Navigation with Click Feedback -->
                <div class="lg:col-span-3 space-y-3">
                    <h5 class="text-xs font-black text-white uppercase tracking-widest border-l-2 border-amber-400 pl-2 mb-4">Navigasi Cepat</h5>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="#beranda" class="inline-block py-1 px-2.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-white/5 active:text-amber-300 active:bg-amber-400/20 active:scale-95 active:translate-x-1 transition-all duration-150 font-medium">
                                <i class="fa-solid fa-angle-right text-[10px] mr-1.5 text-amber-500"></i> Beranda
                            </a>
                        </li>
                        <li>
                            <a href="#jadwal" class="inline-block py-1 px-2.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-white/5 active:text-amber-300 active:bg-amber-400/20 active:scale-95 active:translate-x-1 transition-all duration-150 font-medium">
                                <i class="fa-solid fa-angle-right text-[10px] mr-1.5 text-amber-500"></i> Jadwal Keberangkatan
                            </a>
                        </li>
                        <li>
                            <a href="#layanan" class="inline-block py-1 px-2.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-white/5 active:text-amber-300 active:bg-amber-400/20 active:scale-95 active:translate-x-1 transition-all duration-150 font-medium">
                                <i class="fa-solid fa-angle-right text-[10px] mr-1.5 text-amber-500"></i> Keunggulan Layanan
                            </a>
                        </li>
                        <li>
                            <a href="#armada" class="inline-block py-1 px-2.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-white/5 active:text-amber-300 active:bg-amber-400/20 active:scale-95 active:translate-x-1 transition-all duration-150 font-medium">
                                <i class="fa-solid fa-angle-right text-[10px] mr-1.5 text-amber-500"></i> Pilihan Armada
                            </a>
                        </li>
                        <li>
                            <a href="#faq" class="inline-block py-1 px-2.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-white/5 active:text-amber-300 active:bg-amber-400/20 active:scale-95 active:translate-x-1 transition-all duration-150 font-medium">
                                <i class="fa-solid fa-angle-right text-[10px] mr-1.5 text-amber-500"></i> Tanya Jawab (FAQ)
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Popular Routes with Quick Trigger & Click Feedback -->
                <div class="lg:col-span-3 space-y-3">
                    <h5 class="text-xs font-black text-white uppercase tracking-widest border-l-2 border-amber-400 pl-2 mb-4">Rute Perjalanan</h5>
                    <ul class="space-y-1.5">
                        <li>
                            <button type="button" onclick="setQuickRoute('Sijunjung', 'Padang'); window.scrollTo({top: 0, behavior: 'smooth'});" class="w-full text-left py-1 px-2.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-white/5 active:text-amber-300 active:bg-amber-400/20 active:scale-95 active:translate-x-1 transition-all duration-150 font-medium cursor-pointer">
                                <i class="fa-solid fa-location-dot text-[10px] mr-1.5 text-amber-500"></i> Sijunjung ⇄ Padang
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="setQuickRoute('Padang', 'Sijunjung'); window.scrollTo({top: 0, behavior: 'smooth'});" class="w-full text-left py-1 px-2.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-white/5 active:text-amber-300 active:bg-amber-400/20 active:scale-95 active:translate-x-1 transition-all duration-150 font-medium cursor-pointer">
                                <i class="fa-solid fa-location-dot text-[10px] mr-1.5 text-amber-500"></i> Padang ⇄ Sijunjung
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="setQuickRoute('Padang', 'Solok'); window.scrollTo({top: 0, behavior: 'smooth'});" class="w-full text-left py-1 px-2.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-white/5 active:text-amber-300 active:bg-amber-400/20 active:scale-95 active:translate-x-1 transition-all duration-150 font-medium cursor-pointer">
                                <i class="fa-solid fa-location-dot text-[10px] mr-1.5 text-amber-500"></i> Padang ⇄ Solok
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="setQuickRoute('Sijunjung', 'Bukittinggi'); window.scrollTo({top: 0, behavior: 'smooth'});" class="w-full text-left py-1 px-2.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-white/5 active:text-amber-300 active:bg-amber-400/20 active:scale-95 active:translate-x-1 transition-all duration-150 font-medium cursor-pointer">
                                <i class="fa-solid fa-location-dot text-[10px] mr-1.5 text-amber-500"></i> Sijunjung ⇄ Bukittinggi
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Account & Contact Buttons -->
                <div class="lg:col-span-2 space-y-3">
                    <h5 class="text-xs font-black text-white uppercase tracking-widest border-l-2 border-amber-400 pl-2 mb-4">Akses Cepat</h5>
                    <div class="space-y-2">
                        <a href="{{ route('login') }}" class="block w-full text-center py-2 px-3 rounded-xl bg-white/10 hover:bg-white/20 active:bg-amber-400/30 active:text-amber-300 active:scale-95 text-white font-bold transition-all border border-white/15">
                            Masuk Akun
                        </a>
                        <a href="{{ route('register') }}" class="block w-full text-center py-2 px-3 rounded-xl bg-amber-400 hover:bg-amber-300 active:bg-amber-500 active:scale-95 text-slate-950 font-extrabold transition-all">
                            Daftar Penumpang
                        </a>
                    <a href="https://wa.me/628123456789" target="_blank" class="block w-full text-center py-2 px-3 rounded-xl bg-[#25D366] hover:bg-[#20ba5a] active:bg-[#1caa52] text-white font-bold transition-all shadow-md active:scale-95">
    <i class="fa-brands fa-whatsapp mr-1"></i> WhatsApp CS
</a>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright Bar with Clickable Legal Links -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-400">
                <p>&copy; {{ date('Y') }} <strong class="text-white font-bold">CV. Travel RTM Family</strong>. Hak Cipta Dilindungi.</p>
                <div class="flex items-center gap-4">
                    <a href="#beranda" class="hover:text-amber-400 active:text-amber-300 active:scale-95 transition-all">Kebijakan Privasi</a>
                    <span>•</span>
                    <a href="#beranda" class="hover:text-amber-400 active:text-amber-300 active:scale-95 transition-all">Syarat & Ketentuan</a>
                    <span>•</span>
                    <a href="#kontak" class="hover:text-amber-400 active:text-amber-300 active:scale-95 transition-all">Bantuan</a>
                </div>
            </div>

        </div>
    </footer>

    <!-- JavaScript code for interactive UI/UX components -->
    <script>
        // Quick Date Helper (Hari Ini, Besok, Lusa)
        function setDateOffset(days) {
            const dateInput = document.getElementById('tanggal');
            const targetDate = new Date();
            targetDate.setDate(targetDate.getDate() + days);
            
            const year = targetDate.getFullYear();
            const month = String(targetDate.getMonth() + 1).padStart(2, '0');
            const day = String(targetDate.getDate()).padStart(2, '0');
            
            dateInput.value = `${year}-${month}-${day}`;
        }

        // Popular Route Quick Selector
        function setQuickRoute(asal, tujuan) {
            const asalSelect = document.getElementById('asal');
            const tujuanSelect = document.getElementById('tujuan');
            if (asalSelect && tujuanSelect) {
                asalSelect.value = asal;
                tujuanSelect.value = tujuan;
            }
        }

        // Swap Locations Functionality
        function swapLocations() {
            const asal = document.getElementById('asal');
            const tujuan = document.getElementById('tujuan');
            const temp = asal.value;
            asal.value = tujuan.value;
            tujuan.value = temp;
        }

        // Accordion Toggle
        function toggleAccordion(id) {
            const content = document.getElementById(`accordion-content-${id}`);
            const icon = document.getElementById(`accordion-icon-${id}`);
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        // Mobile Menu Drawer Toggle
        function toggleMobileDrawer() {
            const drawer = document.getElementById('mobile-drawer');
            if (drawer.classList.contains('hidden')) {
                drawer.classList.remove('hidden');
            } else {
                drawer.classList.add('hidden');
            }
        }

        // Smooth scroll for nav anchor links with offset adjustment
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetHref = this.getAttribute('href');
                if (targetHref.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(targetHref);
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>
