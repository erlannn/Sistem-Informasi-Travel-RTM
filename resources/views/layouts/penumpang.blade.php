<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Travel RTM Family - Solusi Perjalanan Terpercaya')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Pesan tiket travel RTM Family dengan mudah, cepat, dan aman. Nikmati perjalanan dengan armada terbaik dan layanan prima.">
    <meta name="author" content="CV Travel RTM">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS Hook if needed -->
    @stack('styles')
    @yield('styles')
</head>
<body class="flex flex-col min-h-full font-sans antialiased text-slate-900 bg-slate-50">

    <!-- Header Navbar with White Glassmorphism -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/60 shadow-sm relative">
        <!-- Bottom Accent Gradient Border Line -->
        <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-gradient-to-r from-brand-500 via-gold-400 to-brand-500 opacity-80"></div>

        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-24">
                
                <!-- Left: Logo & Title (Brand Identity in Dark Circle) -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="group focus:outline-none flex">
                        <div class="w-20 h-20 rounded-full bg-slate-950 hover:bg-slate-900 border border-slate-800 shadow-md group-hover:border-slate-700 flex items-center justify-center p-1.5 transition-all duration-200">
                            <!-- Logo PNG Image -->
                            <img src="{{ asset('images/logo.png') }}" alt="Logo RTM Family" class="w-full h-auto object-contain select-none pointer-events-none">
                        </div>
                    </a>
                </div>

                <!-- Center: Desktop Navigation Menu (Text Only) -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('penumpang.beranda') }}" class="px-4 py-2 text-xs lg:text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('penumpang.beranda') || request()->routeIs('penumpang.dashboard') ? 'text-brand-600 bg-brand-50/80 border border-brand-100 shadow-[0_2px_8px_rgba(37,99,235,0.06)]' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50/80' }}">
                        Beranda
                    </a>
                    
                    <a href="{{ route('penumpang.jadwal') }}" class="px-4 py-2 text-xs lg:text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('penumpang.jadwal') || request()->routeIs('penumpang.pilih_kursi') || request()->routeIs('penumpang.konfirmasi') ? 'text-brand-600 bg-brand-50/80 border border-brand-100 shadow-[0_2px_8px_rgba(37,99,235,0.06)]' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50/80' }}">
                        Cari Tiket
                    </a>

                    <a href="{{ route('penumpang.status') }}" class="px-4 py-2 text-xs lg:text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('penumpang.status') || request()->routeIs('penumpang.status.detail') ? 'text-brand-600 bg-brand-50/80 border border-brand-100 shadow-[0_2px_8px_rgba(37,99,235,0.06)]' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50/80' }}">
                        Status Pemesanan
                    </a>

                    <a href="{{ route('penumpang.profil') }}" class="px-4 py-2 text-xs lg:text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('penumpang.profil') ? 'text-brand-600 bg-brand-50/80 border border-brand-100 shadow-[0_2px_8px_rgba(37,99,235,0.06)]' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50/80' }}">
                        Profil
                    </a>
                </nav>

                <!-- Right Side: Notifications, Avatar and Logout (Desktop) -->
                <div class="hidden md:flex items-center space-x-4">
                    
                    <!-- Notification Bell Button -->
                    <button class="p-2.5 text-slate-500 hover:text-brand-600 hover:bg-slate-50 rounded-xl transition-colors relative cursor-pointer focus:ring-2 focus:ring-slate-100 focus:outline-none">
                        <!-- Pulse Indicator -->
                        <span class="absolute top-2 right-2 w-2 h-2 bg-status-danger rounded-full ring-2 ring-white animate-pulse"></span>
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                    </button>

                    <!-- Divider -->
                    <div class="h-6 w-px bg-slate-200"></div>

                    <!-- User Initials Profile Tag with Status indicator -->
                    @auth
                        <div class="flex items-center gap-3">
                            <div class="relative cursor-pointer group">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-brand-50 to-brand-100/50 border border-brand-200 hover:border-brand-400 flex items-center justify-center text-brand-600 font-extrabold text-xs shadow-sm group-hover:shadow-[0_2px_8px_rgba(37,99,235,0.12)] transition-all">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-status-success rounded-full border border-white"></span>
                            </div>
                            <div class="hidden xl:flex flex-col text-left">
                                <span class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] text-slate-400 font-medium">Penumpang Gold</span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="h-6 w-px bg-slate-200"></div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-slate-500 hover:text-status-danger transition-colors focus:outline-none cursor-pointer">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold text-slate-900 bg-brand-500 hover:bg-brand-400 rounded-xl shadow-md transition">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Icon (Styled) -->
                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-toggle" type="button" class="inline-flex items-center justify-center p-2.5 rounded-xl text-slate-500 hover:text-brand-600 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Buka Menu</span>
                        <!-- Icon Hamburger -->
                        <svg id="hamburger-icon" class="block w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!-- Icon Close -->
                        <svg id="close-icon" class="hidden w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu Dropdown with Glassmorphism backdrop (White Theme) -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white/95 backdrop-blur-lg transition-all duration-300 ease-in-out">
            <div class="px-3 pt-3 pb-5 space-y-2">
                <a href="{{ route('penumpang.beranda') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('penumpang.beranda') || request()->routeIs('penumpang.dashboard') ? 'text-brand-600 bg-brand-50 border-l-4 border-brand-500 shadow-xs' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                    Beranda
                </a>
                
                <a href="{{ route('penumpang.jadwal') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('penumpang.jadwal') || request()->routeIs('penumpang.pilih_kursi') || request()->routeIs('penumpang.konfirmasi') ? 'text-brand-600 bg-brand-50 border-l-4 border-brand-500 shadow-xs' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                    Cari Tiket
                </a>
                
                <a href="{{ route('penumpang.status') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('penumpang.status') || request()->routeIs('penumpang.status.detail') ? 'text-brand-600 bg-brand-50 border-l-4 border-brand-500 shadow-xs' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                    Status Pemesanan
                </a>
                
                <a href="{{ route('penumpang.profil') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('penumpang.profil') ? 'text-brand-600 bg-brand-50 border-l-4 border-brand-500 shadow-xs' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                    Profil Saya
                </a>
                
                <!-- Mobile Divider & Session Action -->
                <div class="pt-4 mt-3 border-t border-slate-100 flex items-center justify-between px-3">
                    @auth
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-brand-50 to-brand-100/50 border border-brand-200 flex items-center justify-center text-brand-600 font-bold text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="text-xs font-bold text-slate-700">{{ Auth::user()->name }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-status-danger hover:text-red-500 transition-colors">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700">Masuk</a>
                        <a href="{{ route('register') }}" class="text-xs font-bold text-brand-600">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Elegant Footer -->
    <footer class="mt-auto border-t border-slate-200 bg-white">
        <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Branding Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-brand-500 shadow-md">
                            <span class="font-extrabold text-white text-sm">R</span>
                        </div>
                        <span class="text-md font-bold tracking-wide text-slate-900">
                            Travel RTM Family
                        </span>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-slate-500 max-w-sm">
                        Menghubungkan Anda dengan destinasi pilihan secara aman, nyaman, dan terjadwal. Pelopor perjalanan antar kota terbaik di kelasnya.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400">Navigasi</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-sm text-slate-500 hover:text-brand-500 transition-colors">Cari Tiket</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-brand-500 transition-colors">Rekomendasi Jadwal</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-brand-500 transition-colors">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <!-- Contact & Support -->
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400">Dukungan</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-sm text-slate-500 hover:text-brand-500 transition-colors">Hubungi CS</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-brand-500 transition-colors">Pusat Bantuan</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-brand-500 transition-colors">Kantor Cabang</a></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright / Bottom -->
            <div class="pt-8 mt-12 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-400">
                    &copy; 2026 CV Travel RTM. Hak Cipta Dilindungi.
                </p>
                <div class="flex space-x-6 text-xs text-slate-400">
                    <a href="#" class="hover:text-slate-600">Kebijakan Privasi</a>
                    <span>&bull;</span>
                    <a href="#" class="hover:text-slate-600">Ketentuan Layanan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            if (toggleBtn && mobileMenu) {
                toggleBtn.addEventListener('click', () => {
                    const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                    toggleBtn.setAttribute('aria-expanded', !isExpanded);
                    mobileMenu.classList.toggle('hidden');
                    
                    // Toggle Icons
                    if (isExpanded) {
                        hamburgerIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    } else {
                        hamburgerIcon.classList.add('hidden');
                        closeIcon.classList.remove('hidden');
                    }
                });
            }
        });
    </script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>
