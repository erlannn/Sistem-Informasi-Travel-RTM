<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Travel RTM Family - Perjalanan Premium & Nyaman</title>

    <!-- Google Fonts: Poppins & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-brand-500 selection:text-slate-950">

    <!-- Floating Navbar with Blur Kaca (Frosted Glassmorphism - Compact) -->
    <header class="fixed top-3 sm:top-4 left-0 right-0 z-50 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="w-full bg-slate-950/40 backdrop-blur-2xl backdrop-saturate-150 border-t border-t-white/30 border-b border-b-white/10 border-x border-x-white/20 rounded-2xl shadow-2xl shadow-black/30 transition-all duration-300">
            <div class="px-5 sm:px-6 py-2 sm:py-2.5 flex items-center justify-between">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Travel RTM" class="h-10 sm:h-11 md:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105 drop-shadow-lg shrink-0">
                        <div class="text-left">
                            <span class="block font-black text-base sm:text-lg tracking-wider text-white uppercase leading-none group-hover:text-amber-400 transition-colors drop-shadow-sm">Travel RTM</span>
                            <span class="block text-[8px] sm:text-[9px] text-amber-400 font-extrabold tracking-widest uppercase mt-0.5">RTM Family</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center gap-7">
                    <a href="#beranda" class="text-xs font-bold text-slate-100 hover:text-amber-400 tracking-wide uppercase transition-colors drop-shadow-sm">Beranda</a>
                    <a href="#jadwal" class="text-xs font-bold text-slate-100 hover:text-amber-400 tracking-wide uppercase transition-colors drop-shadow-sm">Jadwal</a>
                    <a href="#layanan" class="text-xs font-bold text-slate-100 hover:text-amber-400 tracking-wide uppercase transition-colors drop-shadow-sm">Layanan</a>
                    <a href="#armada" class="text-xs font-bold text-slate-100 hover:text-amber-400 tracking-wide uppercase transition-colors drop-shadow-sm">Armada</a>
                    <a href="#faq" class="text-xs font-bold text-slate-100 hover:text-amber-400 tracking-wide uppercase transition-colors drop-shadow-sm">FAQ</a>
                    <a href="#kontak" class="text-xs font-bold text-slate-100 hover:text-amber-400 tracking-wide uppercase transition-colors drop-shadow-sm">Kontak</a>
                </div>

                <!-- Auth Buttons (Desktop) -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-100 hover:text-amber-400 px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md transition-all uppercase tracking-wider">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4.5 py-2 text-xs font-extrabold text-slate-950 bg-amber-400 hover:bg-amber-300 rounded-xl shadow-lg shadow-amber-400/30 active:scale-95 transition-all uppercase tracking-wider">
                        Daftar Akun
                    </a>
                </div>

                <!-- Mobile Hamburger Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" onclick="toggleMobileDrawer()" class="text-white hover:text-amber-400 p-1 focus:outline-none" aria-label="Toggle menu">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Drawer Menu (Frosted Glass) -->
    <div id="mobile-drawer" class="fixed inset-0 z-50 hidden bg-slate-950/60 backdrop-blur-sm transition-opacity duration-300">
        <div class="fixed top-0 right-0 w-80 max-w-full h-full bg-slate-950/90 backdrop-blur-2xl border-l border-white/15 shadow-2xl p-6 flex flex-col justify-between">
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
                    <button type="button" onclick="toggleMobileDrawer()" class="text-slate-400 hover:text-white">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- Navigation Links inside Mobile Drawer -->
                <div class="flex flex-col gap-5">
                    <a href="#beranda" onclick="toggleMobileDrawer()" class="text-base font-semibold text-slate-200 hover:text-amber-400 transition-colors py-2 border-b border-white/10">Beranda</a>
                    <a href="#jadwal" onclick="toggleMobileDrawer()" class="text-base font-semibold text-slate-200 hover:text-amber-400 transition-colors py-2 border-b border-white/10">Jadwal</a>
                    <a href="#layanan" onclick="toggleMobileDrawer()" class="text-base font-semibold text-slate-200 hover:text-amber-400 transition-colors py-2 border-b border-white/10">Layanan</a>
                    <a href="#armada" onclick="toggleMobileDrawer()" class="text-base font-semibold text-slate-200 hover:text-amber-400 transition-colors py-2 border-b border-white/10">Armada</a>
                    <a href="#faq" onclick="toggleMobileDrawer()" class="text-base font-semibold text-slate-200 hover:text-amber-400 transition-colors py-2 border-b border-white/10">FAQ</a>
                    <a href="#kontak" onclick="toggleMobileDrawer()" class="text-base font-semibold text-slate-200 hover:text-amber-400 transition-colors py-2 border-b border-white/10">Kontak</a>
                </div>
            </div>

            <!-- Auth Action inside Mobile Drawer -->
            <div class="space-y-4">
                <a href="{{ route('login') }}" class="block w-full text-center py-3 text-sm font-bold text-white bg-slate-900 border border-white/10 hover:border-amber-400/50 rounded-xl transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center py-3 text-sm font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 rounded-xl shadow-lg transition">
                    Daftar Akun
                </a>
            </div>
        </div>
    </div>

    <!-- Traveloka-Style Hero Section with Rich Background Image -->
    <section id="beranda" class="relative pt-36 pb-24 md:pt-48 md:pb-32 overflow-hidden border-b border-slate-200/80 min-h-[92vh] flex items-center bg-slate-950">
        <!-- Background Image with Static Cinematic Overlay (No Pulsing/Glow) -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-travel.png') }}" alt="Background Travel RTM" class="w-full h-full object-cover object-center">
            <!-- Static clean contrast overlay -->
            <div class="absolute inset-0 bg-linear-to-b from-slate-950/85 via-slate-950/65 to-slate-950/90"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            
            <!-- Headline & Tagline (Traveloka Style Centered) -->
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/20 border border-amber-400/40 text-amber-300 text-xs font-black uppercase tracking-wider shadow-lg select-none backdrop-blur-md">
                    <i class="fa-solid fa-crown text-amber-400"></i> Platform Pemesanan Travel Terpercaya Sumatera Barat
                </div>
                
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight uppercase drop-shadow-lg">
                    Pesan Tiket Travel Jadi <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-linear-to-r from-amber-400 via-amber-300 to-amber-400">Lebih Mudah & Nyaman</span>
                </h1>
                
                <p class="text-sm sm:text-base text-slate-200 max-w-2xl mx-auto font-light leading-relaxed drop-shadow-md">
                    Nikmati perjalanan eksekutif Toyota HiAce Premio & Isuzu Elf Long rute Sijunjung, Padang, Bukittinggi, Solok dengan kepastian jadwal, kursi nyaman, dan supir profesional.
                </p>

                <!-- Mini Highlight Chips (Glass Pills) -->
                <div class="flex items-center justify-center gap-3 pt-2 flex-wrap text-xs text-white font-bold">
                    <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-md border border-white/20 px-3.5 py-1.5 rounded-full shadow-lg">
                        <i class="fa-solid fa-star text-amber-400"></i> 4.9/5 Rating
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-md border border-white/20 px-3.5 py-1.5 rounded-full shadow-lg">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i> 100% Pasti Berangkat
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-md border border-white/20 px-3.5 py-1.5 rounded-full shadow-lg">
                        <i class="fa-solid fa-van-shuttle text-amber-400"></i> HiAce Premio & Elf Long
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-md border border-white/20 px-3.5 py-1.5 rounded-full shadow-lg">
                        <i class="fa-solid fa-snowflake text-sky-400"></i> Full AC & Reclining Seat
                    </span>
                </div>
            </div>

            <!-- Traveloka Search & Booking Widget (Floating White Card) -->
            <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-2xl shadow-black/40 border border-slate-200/90 overflow-hidden">
                
                <!-- Booking Header Bar (Traveloka Style White) -->
                <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/80 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center text-sm font-bold border border-amber-500/20">
                            <i class="fa-solid fa-van-shuttle"></i>
                        </div>
                        <div>
                            <span class="text-xs sm:text-sm font-black text-slate-900 uppercase tracking-wide">Cari & Pesan Tiket Travel Antarkota</span>
                            <span class="hidden sm:inline-block text-[11px] text-slate-500 ml-2 font-normal">• Rute Resmi & Jadwal Real-time</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-[10px] font-extrabold text-amber-800 bg-amber-100/80 border border-amber-200 px-3 py-1 rounded-full uppercase tracking-wider">
                        <i class="fa-solid fa-circle-check text-amber-600"></i> Online Booking
                    </div>
                </div>

                <!-- Main Travel Search Panel -->
                <div class="p-6 sm:p-8 bg-white">
                    <form action="{{ url('/') }}#jadwal" method="GET" class="space-y-6">
                        
                        <!-- Search Fields Grid (Traveloka Style Connected Input Blocks - White) -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 lg:gap-4 items-center">
                            
                            <!-- Dari (Kota Asal) -->
                            <div class="md:col-span-5 relative bg-slate-50 hover:bg-slate-100/80 border border-slate-200/90 hover:border-amber-500 rounded-2xl p-3.5 transition-all focus-within:ring-2 focus-within:ring-amber-500/30 focus-within:border-amber-500 focus-within:bg-white group">
                                <label for="asal" class="flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider text-slate-500 group-focus-within:text-amber-600 mb-1 cursor-pointer">
                                    <i class="fa-solid fa-location-dot text-amber-500 text-xs"></i> Dari (Kota Asal)
                                </label>
                                <div class="relative">
                                    <select id="asal" name="asal" class="w-full bg-transparent font-bold text-sm sm:text-base text-slate-900 focus:outline-none cursor-pointer appearance-none pr-6">
                                        <option value="">Pilih Kota Asal (Semua)...</option>
                                        @foreach($lokasiAsal as $item)
                                            <option value="{{ $item }}" {{ request('asal') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute right-0 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-hover:text-slate-600">
                                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                    </span>
                                </div>
                                <span class="block text-[10px] text-slate-400 font-light mt-0.5">Titik jemput / Pool</span>
                            </div>

                            <!-- Swap Locations Button (Floating Center Pill) -->
                            <div class="md:col-span-1 flex justify-center -my-2 md:my-0">
                                <button type="button" onclick="swapLocations()" class="w-10 h-10 rounded-full bg-white border border-slate-200 hover:border-amber-500 hover:bg-amber-50 text-slate-600 hover:text-amber-600 flex items-center justify-center shadow-md transition-all hover:scale-110 hover:rotate-180 active:scale-95 cursor-pointer z-10" title="Tukar Kota Asal & Tujuan">
                                    <i class="fa-solid fa-right-left text-xs"></i>
                                </button>
                            </div>

                            <!-- Ke (Kota Tujuan) -->
                            <div class="md:col-span-6 relative bg-slate-50 hover:bg-slate-100/80 border border-slate-200/90 hover:border-amber-500 rounded-2xl p-3.5 transition-all focus-within:ring-2 focus-within:ring-amber-500/30 focus-within:border-amber-500 focus-within:bg-white group">
                                <label for="tujuan" class="flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider text-slate-500 group-focus-within:text-amber-600 mb-1 cursor-pointer">
                                    <i class="fa-solid fa-location-crosshairs text-amber-500 text-xs"></i> Ke (Kota Tujuan)
                                </label>
                                <div class="relative">
                                    <select id="tujuan" name="tujuan" class="w-full bg-transparent font-bold text-sm sm:text-base text-slate-900 focus:outline-none cursor-pointer appearance-none pr-6">
                                        <option value="">Pilih Kota Tujuan (Semua)...</option>
                                        @foreach($lokasiTujuan as $item)
                                            <option value="{{ $item }}" {{ request('tujuan') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute right-0 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-hover:text-slate-600">
                                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                    </span>
                                </div>
                                <span class="block text-[10px] text-slate-400 font-light mt-0.5">Titik antar / Destinasi</span>
                            </div>

                        </div>

                        <!-- Date & Action Row -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 lg:gap-4 items-center pt-1">
                            
                            <!-- Tanggal Perjalanan -->
                            <div class="md:col-span-7 bg-slate-50 hover:bg-slate-100/80 border border-slate-200/90 hover:border-amber-500 rounded-2xl p-3.5 transition-all focus-within:ring-2 focus-within:ring-amber-500/30 focus-within:border-amber-500 focus-within:bg-white group">
                                <div class="flex items-center justify-between mb-1">
                                    <label for="tanggal" class="flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider text-slate-500 group-focus-within:text-amber-600 cursor-pointer">
                                        <i class="fa-solid fa-calendar-days text-amber-500 text-xs"></i> Tanggal Berangkat
                                    </label>
                                    
                                    <!-- Quick Date Chips (Traveloka Style White) -->
                                    <div class="flex items-center gap-1.5">
                                        <button type="button" onclick="setDateOffset(0)" class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-white border border-slate-200 hover:border-amber-400 hover:text-amber-600 text-slate-600 transition shadow-2xs">Hari Ini</button>
                                        <button type="button" onclick="setDateOffset(1)" class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-white border border-slate-200 hover:border-amber-400 hover:text-amber-600 text-slate-600 transition shadow-2xs">Besok</button>
                                        <button type="button" onclick="setDateOffset(2)" class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-white border border-slate-200 hover:border-amber-400 hover:text-amber-600 text-slate-600 transition shadow-2xs">Lusa</button>
                                    </div>
                                </div>
                                <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}" min="{{ date('Y-m-d') }}" class="w-full bg-transparent font-bold text-sm sm:text-base text-slate-900 focus:outline-none cursor-pointer">
                            </div>

                            <!-- Tombol Cari Tiket (Solid Amber CTA Button) -->
                            <div class="md:col-span-5 flex items-center">
                                <button type="submit" class="w-full py-4 px-6 text-sm font-black text-slate-950 bg-amber-500 hover:bg-amber-400 active:scale-[0.98] rounded-2xl shadow-xl shadow-amber-500/25 transition-all flex items-center justify-center gap-3 cursor-pointer uppercase tracking-wider">
                                    <i class="fa-solid fa-magnifying-glass text-base"></i>
                                    <span>Cari Tiket Travel</span>
                                </button>
                            </div>

                        </div>

                        <!-- Popular Route Pills (Traveloka Quick Shortcuts) -->
                        <div class="pt-2 flex items-center flex-wrap gap-2 text-xs border-t border-slate-100">
                            <span class="text-slate-400 font-bold flex items-center gap-1.5">
                                <i class="fa-solid fa-fire text-amber-500"></i> Rute Populer:
                            </span>
                            <button type="button" onclick="setQuickRoute('Sijunjung', 'Padang')" class="px-3 py-1 rounded-full bg-slate-100 hover:bg-amber-100/80 hover:text-amber-800 text-slate-700 font-medium transition cursor-pointer border border-slate-200/60">
                                Sijunjung ⇄ Padang
                            </button>
                            <button type="button" onclick="setQuickRoute('Padang', 'Sijunjung')" class="px-3 py-1 rounded-full bg-slate-100 hover:bg-amber-100/80 hover:text-amber-800 text-slate-700 font-medium transition cursor-pointer border border-slate-200/60">
                                Padang ⇄ Sijunjung
                            </button>
                            <button type="button" onclick="setQuickRoute('Padang', 'Solok')" class="px-3 py-1 rounded-full bg-slate-100 hover:bg-amber-100/80 hover:text-amber-800 text-slate-700 font-medium transition cursor-pointer border border-slate-200/60">
                                Padang ⇄ Solok
                            </button>
                            <button type="button" onclick="setQuickRoute('Sijunjung', 'Bukittinggi')" class="px-3 py-1 rounded-full bg-slate-100 hover:bg-amber-100/80 hover:text-amber-800 text-slate-700 font-medium transition cursor-pointer border border-slate-200/60">
                                Sijunjung ⇄ Bukittinggi
                            </button>
                        </div>

                    </form>
                </div>

            </div>

            <!-- Traveloka-Style 4 Feature Badges Under Search Box -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 max-w-5xl mx-auto mt-8">
                <div class="bg-slate-900/60 backdrop-blur-xl p-4 rounded-2xl border border-white/15 flex items-center gap-3.5 shadow-xl hover:border-amber-400/40 transition">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/30 text-amber-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-shield-halved text-base"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-white uppercase tracking-tight">Jaminan Tiket Resmi</h4>
                        <p class="text-[11px] text-slate-300 font-light">E-Tiket resmi instan & valid</p>
                    </div>
                </div>

                <div class="bg-slate-900/60 backdrop-blur-xl p-4 rounded-2xl border border-white/15 flex items-center gap-3.5 shadow-xl hover:border-amber-400/40 transition">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/30 text-amber-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-couch text-base"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-white uppercase tracking-tight">Pilih Kursi Sendiri</h4>
                        <p class="text-[11px] text-slate-300 font-light">Bebas pilih nomor kursi kosong</p>
                    </div>
                </div>

                <div class="bg-slate-900/60 backdrop-blur-xl p-4 rounded-2xl border border-white/15 flex items-center gap-3.5 shadow-xl hover:border-amber-400/40 transition">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/30 text-amber-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-clock-rotate-left text-base"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-white uppercase tracking-tight">Pasti Berangkat</h4>
                        <p class="text-[11px] text-slate-300 font-light">Jadwal tepat & armada prima</p>
                    </div>
                </div>

                <div class="bg-slate-900/60 backdrop-blur-xl p-4 rounded-2xl border border-white/15 flex items-center gap-3.5 shadow-xl hover:border-amber-400/40 transition">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/30 text-amber-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-headset text-base"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-white uppercase tracking-tight">Bantuan CS 24/7</h4>
                        <p class="text-[11px] text-slate-300 font-light">Respon cepat via WhatsApp</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Schedule Section (Jadwal) -->
    <section id="jadwal" class="py-24 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block text-[10px] font-extrabold uppercase tracking-widest text-brand-600 bg-brand-50 px-3 py-1 rounded-full border border-brand-100 mb-3">
                    Informasi Terupdate
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight uppercase">Jadwal Keberangkatan Travel</h2>
                <p class="mt-3 text-sm text-slate-500 leading-relaxed font-light">
                    Silakan pilih jadwal keberangkatan yang sesuai. Anda harus masuk (login) ke dalam sistem terlebih dahulu untuk memilih kursi dan memproses pemesanan tiket.
                </p>
                <div class="w-12 h-1 bg-brand-500 rounded-full mx-auto mt-4"></div>
            </div>

            <!-- Active Search Badge -->
            @if(request('asal') || request('tujuan') || request('tanggal'))
                <div class="mb-10 p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-center justify-between flex-wrap gap-4 shadow-sm">
                    <div class="flex items-center gap-2 text-xs text-amber-800 font-medium">
                        <i class="fa-solid fa-filter text-amber-600 text-sm animate-bounce"></i>
                        <span>Menampilkan hasil filter: </span>
                        @if(request('asal')) <span class="bg-amber-100 px-2 py-0.5 rounded font-bold">Asal "{{ request('asal') }}"</span> @endif
                        @if(request('tujuan')) <span class="bg-amber-100 px-2 py-0.5 rounded font-bold">Tujuan "{{ request('tujuan') }}"</span> @endif
                        @if(request('tanggal')) <span class="bg-amber-100 px-2 py-0.5 rounded font-bold">Tanggal "{{ date('d M Y', strtotime(request('tanggal'))) }}"</span> @endif
                        <span class="text-slate-400 font-normal">({{ $jadwals->count() }} Jadwal ditemukan)</span>
                    </div>
                    <a href="{{ url('/') }}#jadwal" class="text-xs font-bold text-slate-900 bg-white hover:bg-slate-100 border border-slate-300 px-3 py-1.5 rounded-lg shadow-sm transition">
                        Reset Pencarian
                    </a>
                </div>
            @endif

            <!-- Schedules Grid (Ticket Pass Card Layout) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($jadwals as $j)
                    @php
                        // Hitung ketersediaan kursi
                        $totalKursi = 10; 
                        $terisi = $j->kursis->where('status', 'Terisi')->count();
                        $tersedia = $totalKursi - $terisi;
                        if($tersedia < 0) $tersedia = 0;
                    @endphp
                    <div class="group relative bg-white hover:-translate-y-1.5 rounded-3xl border border-slate-200/80 p-6 transition-all duration-300 hover:shadow-xl hover:border-brand-500/40 flex flex-col justify-between overflow-hidden">
                        
                        <!-- Left Notch ticket cutout -->
                        <div class="absolute -left-3 top-[62%] -translate-y-1/2 w-6 h-6 bg-slate-50 border-r border-slate-200/80 rounded-full z-10"></div>
                        <!-- Right Notch ticket cutout -->
                        <div class="absolute -right-3 top-[62%] -translate-y-1/2 w-6 h-6 bg-slate-50 border-l border-slate-200/80 rounded-full z-10"></div>

                        <!-- Top Accent Bar -->
                        <div class="absolute left-0 right-0 top-0 h-1.5 bg-slate-950 group-hover:bg-brand-500 transition-colors"></div>
                        
                        <div class="space-y-5">
                            <!-- Route Timeline (Visual UI/UX improvement) -->
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <div class="flex items-center gap-3 w-full justify-between pr-2">
                                    <div class="text-left">
                                        <span class="block text-[9px] text-slate-400 uppercase tracking-widest font-extrabold">Keberangkatan</span>
                                        <span class="font-bold text-slate-900 text-sm tracking-tight">{{ $j->asal }}</span>
                                    </div>
                                    
                                    <!-- Route Line Icon -->
                                    <div class="flex-1 flex items-center justify-center px-2 relative">
                                        <div class="w-full border-t border-slate-200 border-dashed absolute top-1/2 left-0 right-0 z-0"></div>
                                        <div class="relative z-10 px-2 bg-white text-brand-500 flex gap-1.5 items-center">
                                            <i class="fa-solid fa-circle-dot text-[7px]"></i>
                                            <i class="fa-solid fa-bus text-xs animate-pulse"></i>
                                            <i class="fa-solid fa-location-dot text-[8px] text-slate-400"></i>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <span class="block text-[9px] text-slate-400 uppercase tracking-widest font-extrabold">Tujuan</span>
                                        <span class="font-bold text-slate-900 text-sm tracking-tight">{{ $j->tujuan }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Details (Grid) -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center text-xs gap-2.5">
                                    <div class="w-7 h-7 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-center text-slate-500 shrink-0">
                                        <i class="fa-regular fa-calendar-days text-[11px]"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <span class="block text-[9px] text-slate-400 uppercase tracking-wider font-bold">Tanggal</span>
                                        <span class="font-medium text-slate-800 block truncate">{{ date('d M Y', strtotime($j->tanggal)) }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center text-xs gap-2.5">
                                    <div class="w-7 h-7 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-center text-slate-500 shrink-0">
                                        <i class="fa-regular fa-clock text-[11px]"></i>
                                    </div>
                                    <div>
                                        <span class="block text-[9px] text-slate-400 uppercase tracking-wider font-bold">Keberangkatan</span>
                                        <span class="font-extrabold text-slate-800 block">{{ date('H:i', strtotime($j->jam)) }} WIB</span>
                                    </div>
                                </div>

                                <div class="flex items-center text-xs gap-2.5 col-span-2">
                                    <div class="w-7 h-7 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-center text-slate-500 shrink-0">
                                        <i class="fa-solid fa-car text-[11px]"></i>
                                    </div>
                                    <div>
                                        <span class="block text-[9px] text-slate-400 uppercase tracking-wider font-bold">Tipe Kendaraan</span>
                                        <span class="font-medium text-slate-800 block">{{ $j->armada->merk ?? 'Toyota HiAce Premio' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Perforated ticket dividing line (aligned with notches) -->
                            <div class="relative border-t border-dashed border-slate-200/80 my-2"></div>

                            <!-- Seat Availability (Progress Bar UI/UX improvement) -->
                            <div class="space-y-1.5">
                                <div class="flex justify-between text-[10px] font-medium text-slate-500">
                                    <span>Sisa Kursi: <strong class="text-slate-800 font-bold">{{ $tersedia }}</strong>/{{ $totalKursi }}</span>
                                    @if($tersedia <= 3 && $tersedia > 0)
                                        <span class="text-amber-600 font-extrabold animate-pulse">Sisa Sedikit!</span>
                                    @elseif($tersedia == 0)
                                        <span class="text-rose-600 font-extrabold">Penuh</span>
                                    @else
                                        <span class="text-emerald-600 font-extrabold">Tersedia</span>
                                    @endif
                                </div>
                                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
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
                        <div class="mt-6 pt-4 flex items-center justify-between gap-4">
                            <div>
                                <span class="block text-[9px] text-slate-400 uppercase tracking-widest font-extrabold">Harga Tiket</span>
                                <span class="text-base sm:text-lg font-black text-brand-600">Rp {{ number_format($j->harga, 0, ',', '.') }}</span>
                            </div>
                            
                            @if($tersedia > 0)
                                <a href="{{ route('login', ['redirect' => 'booking', 'id_jadwal' => $j->id_jadwal]) }}" class="px-4 py-2.5 text-xs font-bold text-white bg-slate-900 hover:bg-slate-950 active:scale-95 rounded-xl border border-slate-800 hover:border-brand-500/40 shadow-sm transition-all duration-200 cursor-pointer">
                                    Pesan Tiket
                                </a>
                            @else
                                <button disabled class="px-4 py-2.5 text-xs font-bold text-slate-400 bg-slate-100 rounded-xl border border-slate-200 cursor-not-allowed">
                                    Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-sm">
                        <div class="w-14 h-14 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center text-slate-400 mx-auto mb-4">
                            <i class="fa-solid fa-calendar-xmark text-xl"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800">Jadwal Perjalanan Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-400 mt-2 max-w-sm mx-auto leading-relaxed">
                            Maaf, tidak ada jadwal keberangkatan untuk kriteria pencarian Anda saat ini. Silakan ubah kriteria filter pencarian.
                        </p>
                        @if(request('asal') || request('tujuan') || request('tanggal'))
                            <a href="{{ url('/') }}#jadwal" class="inline-block mt-5 px-5 py-2.5 text-xs font-bold text-white bg-slate-950 hover:bg-slate-900 rounded-xl shadow transition">
                                Lihat Semua Jadwal
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Services / Layanan Section -->
    <section id="layanan" class="py-24 bg-slate-950 text-white relative overflow-hidden">
        <!-- Background light glows -->
        <div class="absolute top-1/4 left-0 w-80 h-80 bg-brand-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-0 w-80 h-80 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block text-[10px] font-extrabold uppercase tracking-widest text-brand-500 bg-brand-500/10 border border-brand-500/20 px-3 py-1 rounded-full mb-3">
                    Kenapa Memilih Kami?
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight uppercase">Keunggulan Layanan Travel RTM</h2>
                <p class="mt-3 text-sm text-slate-400 leading-relaxed font-light">
                    Kenyamanan dan kepuasan perjalanan Anda adalah prioritas utama kami. Kami menyediakan fasilitas premium terbaik untuk menjamin perjalanan yang berkesan.
                </p>
                <div class="w-12 h-1 bg-brand-500 rounded-full mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Card 1 -->
                <div class="bg-slate-900/40 border border-white/5 p-6 rounded-2xl hover:border-brand-500/30 hover:bg-slate-900/60 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-11 h-11 rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-500 flex items-center justify-center text-lg mb-6 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-couch"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Kenyamanan Eksekutif</h3>
                    <p class="mt-3 text-xs text-slate-400 leading-relaxed font-light">
                        Dilengkapi dengan kursi ergonomis premium yang dapat direbahkan (reclining seat), AC dingin yang merata, serta ruang kaki yang luas di setiap baris.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-900/40 border border-white/5 p-6 rounded-2xl hover:border-brand-500/30 hover:bg-slate-900/60 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-11 h-11 rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-500 flex items-center justify-center text-lg mb-6 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Keamanan Kelas Utama</h3>
                    <p class="mt-3 text-xs text-slate-400 leading-relaxed font-light">
                        Seluruh armada dipelihara berkala secara ketat, dilengkapi asuransi keselamatan, dan dikemudikan oleh sopir profesional berlisensi resmi.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-900/40 border border-white/5 p-6 rounded-2xl hover:border-brand-500/30 hover:bg-slate-900/60 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-11 h-11 rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-500 flex items-center justify-center text-lg mb-6 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Garansi Tepat Waktu</h3>
                    <p class="mt-3 text-xs text-slate-400 leading-relaxed font-light">
                        Komitmen keberangkatan sesuai dengan jadwal waktu tiket Anda. Kami menghargai waktu Anda tanpa kompromi keterlambatan yang disengaja.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="bg-slate-900/40 border border-white/5 p-6 rounded-2xl hover:border-brand-500/30 hover:bg-slate-900/60 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-11 h-11 rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-500 flex items-center justify-center text-lg mb-6 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-location-arrow"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Layanan Antar Jemput</h3>
                    <p class="mt-3 text-xs text-slate-400 leading-relaxed font-light">
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
                <span class="inline-block text-[10px] font-extrabold uppercase tracking-widest text-brand-600 bg-brand-50 px-3 py-1 rounded-full border border-brand-100 mb-3">
                    Armada Berkelas
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight uppercase">Kendaraan Premium RTM Family</h2>
                <p class="mt-3 text-sm text-slate-500 leading-relaxed font-light">
                    Semua kendaraan kami selalu dijaga dalam performa terbaik dan kebersihan yang prima untuk menjamin kenyamanan sepanjang perjalanan.
                </p>
                <div class="w-12 h-1 bg-brand-500 rounded-full mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Fleet Card 1 -->
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative h-48 bg-slate-950 flex items-center justify-center text-slate-600">
                        <i class="fa-solid fa-bus text-4xl text-slate-700 animate-pulse"></i>
                        <span class="absolute top-4 right-4 bg-brand-500 text-slate-950 font-extrabold text-[9px] px-3 py-1 rounded-full uppercase tracking-wider">Premium Class</span>
                    </div>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-bold text-slate-900">Toyota Hiace Premio</h3>
                        <p class="text-xs text-slate-500 font-light leading-relaxed">
                            Armada terpopuler kami yang menghadirkan suspensi sangat empuk dan kabin yang sangat senyap, ideal untuk perjalanan jarak jauh.
                        </p>
                        <div class="border-t border-slate-100 pt-4 flex flex-wrap gap-y-2 justify-between text-[11px] text-slate-600 font-medium">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-users text-brand-500 text-xs"></i> 11 Kursi</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-snowflake text-brand-500 text-xs"></i> Full AC</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-plug text-brand-500 text-xs"></i> USB Charger</span>
                        </div>
                    </div>
                </div>

                <!-- Fleet Card 2 -->
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative h-48 bg-slate-950 flex items-center justify-center text-slate-600">
                        <i class="fa-solid fa-bus text-4xl text-slate-700"></i>
                        <span class="absolute top-4 right-4 bg-brand-500 text-slate-950 font-extrabold text-[9px] px-3 py-1 rounded-full uppercase tracking-wider">Executive Class</span>
                    </div>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-bold text-slate-900">Isuzu Elf Long</h3>
                        <p class="text-xs text-slate-500 font-light leading-relaxed">
                            Pilihan terbaik untuk kapasitas penumpang rombongan keluarga yang lebih banyak dengan bagasi super luas untuk barang bawaan Anda.
                        </p>
                        <div class="border-t border-slate-100 pt-4 flex flex-wrap gap-y-2 justify-between text-[11px] text-slate-600 font-medium">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-users text-brand-500 text-xs"></i> 14 Kursi</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-snowflake text-brand-500 text-xs"></i> Full AC</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-suitcase text-brand-500 text-xs"></i> Bagasi Luas</span>
                        </div>
                    </div>
                </div>

                <!-- Fleet Card 3 -->
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative h-48 bg-slate-950 flex items-center justify-center text-slate-600">
                        <i class="fa-solid fa-bus text-4xl text-slate-700"></i>
                        <span class="absolute top-4 right-4 bg-brand-500 text-slate-950 font-extrabold text-[9px] px-3 py-1 rounded-full uppercase tracking-wider">VIP Class</span>
                    </div>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-bold text-slate-900">Mercedes-Benz Sprinter</h3>
                        <p class="text-xs text-slate-500 font-light leading-relaxed">
                            Armada VIP dengan konfigurasi tempat duduk eksklusif, tingkat keamanan tertinggi di kelasnya, dan keheningan kabin total.
                        </p>
                        <div class="border-t border-slate-100 pt-4 flex flex-wrap gap-y-2 justify-between text-[11px] text-slate-600 font-medium">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-users text-brand-500 text-xs"></i> 8 Kursi VIP</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-snowflake text-brand-500 text-xs"></i> Climate Control</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-wifi text-brand-500 text-xs"></i> WiFi Free</span>
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
                <span class="inline-block text-[10px] font-extrabold uppercase tracking-widest text-brand-600 bg-brand-50 px-3 py-1 rounded-full border border-brand-100 mb-3">
                    Tanya Jawab
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight uppercase">Pertanyaan Umum (FAQ)</h2>
                <p class="mt-3 text-sm text-slate-500 leading-relaxed font-light">
                    Temukan jawaban cepat atas pertanyaan yang sering diajukan mengenai pemesanan tiket dan layanan kami.
                </p>
                <div class="w-12 h-1 bg-brand-500 rounded-full mx-auto mt-4"></div>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
                    <button type="button" onclick="toggleAccordion(1)" class="w-full px-6 py-5 text-left font-bold text-slate-900 text-sm sm:text-base flex items-center justify-between hover:bg-slate-100/50 transition cursor-pointer">
                        <span>Bagaimana cara memesan tiket travel secara online?</span>
                        <i id="accordion-icon-1" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="accordion-content-1" class="hidden px-6 pb-5 text-xs sm:text-sm text-slate-500 leading-relaxed font-light border-t border-slate-200/50 pt-4">
                        Penumpang perlu mendaftar akun/masuk ke dalam sistem, cari jadwal perjalanan yang sesuai di halaman utama, pilih nomor kursi kosong yang diinginkan, konfirmasi data penumpang, lakukan pembayaran, dan e-tiket resmi berformat PDF akan otomatis diterbitkan.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
                    <button type="button" onclick="toggleAccordion(2)" class="w-full px-6 py-5 text-left font-bold text-slate-900 text-sm sm:text-base flex items-center justify-between hover:bg-slate-100/50 transition cursor-pointer">
                        <span>Apakah armada Travel RTM memiliki AC dan Charger HP?</span>
                        <i id="accordion-icon-2" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="accordion-content-2" class="hidden px-6 pb-5 text-xs sm:text-sm text-slate-500 leading-relaxed font-light border-t border-slate-200/50 pt-4">
                        Ya, seluruh armada operasional utama kami (Toyota HiAce Premio, Isuzu Elf Long, Mercedes Sprinter) sudah dilengkapi AC dingin di seluruh bagian kabin, port USB charger pengisian daya handphone di setiap baris kursi penumpang, serta reclining seats.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
                    <button type="button" onclick="toggleAccordion(3)" class="w-full px-6 py-5 text-left font-bold text-slate-900 text-sm sm:text-base flex items-center justify-between hover:bg-slate-100/50 transition cursor-pointer">
                        <span>Apakah ada layanan antar-jemput sampai alamat rumah?</span>
                        <i id="accordion-icon-3" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="accordion-content-3" class="hidden px-6 pb-5 text-xs sm:text-sm text-slate-500 leading-relaxed font-light border-t border-slate-200/50 pt-4">
                        Ya, kami melayani sistem antar-jemput pintu ke pintu (point-to-point) untuk kota-kota tertentu dalam jangkauan rute operasional kami. Silakan hubungi customer service WhatsApp kami untuk konfirmasi detail alamat penjemputan Anda.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
                    <button type="button" onclick="toggleAccordion(4)" class="w-full px-6 py-5 text-left font-bold text-slate-900 text-sm sm:text-base flex items-center justify-between hover:bg-slate-100/50 transition cursor-pointer">
                        <span>Bagaimana jika saya ingin mengubah jadwal keberangkatan?</span>
                        <i id="accordion-icon-4" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="accordion-content-4" class="hidden px-6 pb-5 text-xs sm:text-sm text-slate-500 leading-relaxed font-light border-t border-slate-200/50 pt-4">
                        Perubahan jadwal (reschedule) atau pembatalan tiket dapat diproses secara manual dengan menghubungi customer service WhatsApp kami minimal 6 jam sebelum jam keberangkatan awal yang tertera pada tiket Anda.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact & Call to Action Section -->
    <section id="kontak" class="py-24 bg-slate-950 text-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-linear-to-r from-brand-600 to-amber-600 rounded-3xl p-8 md:p-16 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
                <!-- Decorative background shapes -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="space-y-4 max-w-xl text-left relative z-10">
                    <h2 class="text-3xl font-extrabold tracking-tight uppercase leading-none text-slate-950">Ada Pertanyaan Perjalanan?</h2>
                    <p class="text-xs sm:text-sm text-slate-900 font-semibold leading-relaxed">
                        Hubungi customer service kami via WhatsApp untuk bantuan pemesanan tiket perjalanan, informasi jadwal keberangkatan, atau konsultasi rute perjalanan Anda.
                    </p>
                </div>

                <div class="relative z-10 shrink-0">
                    <a href="https://wa.me/628123456789" target="_blank" class="inline-flex items-center gap-2.5 px-8 py-4 text-xs sm:text-sm font-extrabold text-white bg-slate-950 hover:bg-slate-900 rounded-2xl shadow-xl transition-all hover:scale-105 active:scale-95 uppercase tracking-wider">
                        <i class="fa-brands fa-whatsapp text-lg text-emerald-500 animate-bounce"></i> Hubungi WhatsApp
                    </a>
                </div>
            </div>

            <!-- Address and office details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-20 text-slate-400 text-xs font-light">
                <div class="space-y-3">
                    <h4 class="text-xs font-extrabold text-white uppercase tracking-widest border-l-2 border-brand-500 pl-2">Kantor Pusat Sijunjung</h4>
                    <p class="leading-relaxed">
                        Jl. Lintas Sumatera KM 110, Muaro Sijunjung, Sumatera Barat.<br>
                        Telepon: (0754) 123456
                    </p>
                </div>
                <div class="space-y-3">
                    <h4 class="text-xs font-extrabold text-white uppercase tracking-widest border-l-2 border-brand-500 pl-2">Kantor Perwakilan Padang</h4>
                    <p class="leading-relaxed">
                        Jl. Dr. Hamka No. 42 (Dekat Kampus UNP), Air Tawar, Padang, Sumatera Barat.<br>
                        Telepon: (0751) 987654
                    </p>
                </div>
                <div class="space-y-3">
                    <h4 class="text-xs font-extrabold text-white uppercase tracking-widest border-l-2 border-brand-500 pl-2">Jam Layanan</h4>
                    <p class="leading-relaxed">
                        Senin - Minggu: 06:00 - 22:00 WIB<br>
                        Pemesanan online aktif 24 jam penuh di platform.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 py-8 text-center text-xs text-slate-500 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <div class="flex items-center justify-center gap-3.5">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Travel RTM" class="h-12 w-auto object-contain shrink-0 drop-shadow-md">
                <div class="text-left">
                    <span class="block font-black text-base text-white tracking-widest uppercase">Travel RTM Family</span>
                    <span class="block text-[11px] text-slate-400">Transportasi Eksekutif Sumatera Barat</span>
                </div>
            </div>
            <p>&copy; {{ date('Y') }} <strong>CV. Travel RTM</strong>. Hak Cipta Dilindungi.</p>
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
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
