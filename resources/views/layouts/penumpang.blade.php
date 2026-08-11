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

    <!-- Fonts: Traveloka Font Stack (Plus Jakarta Sans & Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS Hook if needed -->
    @stack('styles')
    @yield('styles')
</head>
<body class="flex flex-col min-h-full font-sans antialiased text-black bg-slate-50">

    <!-- Header Navbar with White Glassmorphism -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm relative">
        <!-- Bottom Accent Gradient Border Line -->
        <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 opacity-90"></div>

        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 sm:h-24">
                
                <!-- Left: Logo & Title (Brand Identity in Dark Circle) -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="group focus:outline-none flex items-center gap-3">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-slate-950 hover:bg-slate-900 border border-slate-800 shadow-md flex items-center justify-center p-1.5 transition-all duration-200">
                            <!-- Logo PNG Image -->
                            <img src="{{ asset('images/logo.png') }}" alt="Logo RTM Family" class="w-full h-auto object-contain select-none pointer-events-none">
                        </div>
                        <div class="hidden sm:block text-left">
                            <span class="block text-sm font-black text-black uppercase tracking-wider">CV. Travel RTM</span>
                            <span class="block text-[10px] text-amber-600 font-extrabold tracking-widest uppercase">RTM Family</span>
                        </div>
                    </a>
                </div>

                <!-- Center: Desktop Navigation Menu (Text Only) -->
                <nav class="hidden md:flex items-center space-x-1.5">
                    <a href="{{ route('penumpang.beranda') }}" class="px-4 py-2 text-xs lg:text-sm rounded-xl transition-all {{ request()->routeIs('penumpang.beranda') || request()->routeIs('penumpang.dashboard') ? 'text-amber-950 bg-amber-400/25 border border-amber-400 font-black shadow-xs' : 'text-black hover:text-amber-600 hover:bg-amber-50/70 font-extrabold' }}">
                        Beranda
                    </a>
                    
                    <a href="{{ route('penumpang.jadwal') }}" class="px-4 py-2 text-xs lg:text-sm rounded-xl transition-all {{ request()->routeIs('penumpang.jadwal') || request()->routeIs('penumpang.pilih_kursi') || request()->routeIs('penumpang.konfirmasi') ? 'text-amber-950 bg-amber-400/25 border border-amber-400 font-black shadow-xs' : 'text-black hover:text-amber-600 hover:bg-amber-50/70 font-extrabold' }}">
                        Cari Tiket
                    </a>

                    <a href="{{ route('penumpang.status') }}" class="px-4 py-2 text-xs lg:text-sm rounded-xl transition-all {{ request()->routeIs('penumpang.status') || request()->routeIs('penumpang.status.detail') ? 'text-amber-950 bg-amber-400/25 border border-amber-400 font-black shadow-xs' : 'text-black hover:text-amber-600 hover:bg-amber-50/70 font-extrabold' }}">
                        Status Pemesanan
                    </a>

                    <a href="{{ route('penumpang.profil') }}" class="px-4 py-2 text-xs lg:text-sm rounded-xl transition-all {{ request()->routeIs('penumpang.profil') ? 'text-amber-950 bg-amber-400/25 border border-amber-400 font-black shadow-xs' : 'text-black hover:text-amber-600 hover:bg-amber-50/70 font-extrabold' }}">
                        Profil Saya
                    </a>
                </nav>

                <!-- Right Side: Notifications, Avatar and Logout (Desktop) -->
                <div class="hidden md:flex items-center space-x-4">
                    
                    <!-- Notification Bell Button -->
                    <button class="p-2.5 text-black hover:text-amber-600 hover:bg-amber-50 rounded-xl transition-colors relative cursor-pointer focus:ring-2 focus:ring-amber-200 focus:outline-none">
                        <!-- Pulse Indicator -->
                        <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"></span>
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                    </button>

                    <!-- Divider -->
                    <div class="h-6 w-px bg-slate-200"></div>

                    <!-- User Initials Profile Tag with Status indicator -->
                    @auth
                        <div class="flex items-center gap-3">
                            <div class="relative cursor-pointer group">
                                <div class="w-9 h-9 rounded-full bg-slate-950 text-amber-400 border-2 border-amber-400/50 hover:border-amber-400 flex items-center justify-center font-black text-xs shadow-xs transition-all">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full border border-white"></span>
                            </div>
                            <div class="hidden xl:flex flex-col text-left">
                                <span class="text-xs font-black text-black leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] text-amber-900 font-extrabold bg-amber-100 px-1.5 py-0.5 rounded border border-amber-300 mt-0.5 inline-block">Penumpang</span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="h-6 w-px bg-slate-200"></div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-black text-red-600 hover:text-red-700 hover:bg-red-50 px-2.5 py-1.5 rounded-lg transition-colors focus:outline-none cursor-pointer flex items-center gap-1.5">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold text-black hover:text-amber-600 transition px-3 py-2">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-black text-slate-950 bg-amber-400 hover:bg-amber-300 rounded-xl shadow-xs transition">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Icon (Styled) -->
                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-toggle" type="button" class="inline-flex items-center justify-center p-2.5 rounded-xl bg-slate-950 text-white hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-400" aria-controls="mobile-menu" aria-expanded="false">
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
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200 bg-white/95 backdrop-blur-lg transition-all duration-300 ease-in-out">
            <div class="px-3 pt-3 pb-5 space-y-2">
                <a href="{{ route('penumpang.beranda') }}" class="block px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('penumpang.beranda') || request()->routeIs('penumpang.dashboard') ? 'text-amber-950 bg-amber-400/25 border-l-4 border-amber-500 font-black shadow-xs' : 'text-black hover:text-amber-600 hover:bg-amber-50 font-bold' }}">
                    Beranda
                </a>
                
                <a href="{{ route('penumpang.jadwal') }}" class="block px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('penumpang.jadwal') || request()->routeIs('penumpang.pilih_kursi') || request()->routeIs('penumpang.konfirmasi') ? 'text-amber-950 bg-amber-400/25 border-l-4 border-amber-500 font-black shadow-xs' : 'text-black hover:text-amber-600 hover:bg-amber-50 font-bold' }}">
                    Cari Tiket
                </a>
                
                <a href="{{ route('penumpang.status') }}" class="block px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('penumpang.status') || request()->routeIs('penumpang.status.detail') ? 'text-amber-950 bg-amber-400/25 border-l-4 border-amber-500 font-black shadow-xs' : 'text-black hover:text-amber-600 hover:bg-amber-50 font-bold' }}">
                    Status Pemesanan
                </a>
                
                <a href="{{ route('penumpang.profil') }}" class="block px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('penumpang.profil') ? 'text-amber-950 bg-amber-400/25 border-l-4 border-amber-500 font-black shadow-xs' : 'text-black hover:text-amber-600 hover:bg-amber-50 font-bold' }}">
                    Profil Saya
                </a>
                
                <!-- Mobile Divider & Session Action -->
                <div class="pt-4 mt-3 border-t border-slate-200 flex items-center justify-between px-3">
                    @auth
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-slate-950 text-amber-400 border border-amber-400/50 flex items-center justify-center font-black text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="text-xs font-black text-black">{{ Auth::user()->name }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-black text-red-600 hover:text-red-700 transition-colors">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold text-black hover:text-amber-600">Masuk</a>
                        <a href="{{ route('register') }}" class="text-xs font-black text-amber-600 hover:text-amber-700">Daftar</a>
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
                        <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-slate-950 shadow-md">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo RTM Family" class="w-7 h-auto object-contain">
                        </div>
                        <span class="text-base font-black tracking-wide text-black uppercase">
                            Travel RTM Family
                        </span>
                    </div>
                    <p class="mt-4 text-xs sm:text-sm leading-relaxed text-black max-w-sm font-normal">
                        Menghubungkan Anda dengan destinasi pilihan secara aman, nyaman, dan terjadwal. Pelopor perjalanan antarkota terbaik di Sumatera Barat.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xs font-black uppercase tracking-wider text-black border-l-2 border-amber-400 pl-2">Navigasi</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="{{ route('penumpang.jadwal') }}" class="inline-block text-xs sm:text-sm text-black hover:text-amber-600 active:text-amber-700 active:bg-amber-50 active:scale-95 px-2 py-1 rounded-lg transition-all font-medium">Cari Tiket</a></li>
                        <li><a href="{{ route('penumpang.status') }}" class="inline-block text-xs sm:text-sm text-black hover:text-amber-600 active:text-amber-700 active:bg-amber-50 active:scale-95 px-2 py-1 rounded-lg transition-all font-medium">Status Pemesanan</a></li>
                        <li><a href="{{ url('/#layanan') }}" class="inline-block text-xs sm:text-sm text-black hover:text-amber-600 active:text-amber-700 active:bg-amber-50 active:scale-95 px-2 py-1 rounded-lg transition-all font-medium">Keunggulan Layanan</a></li>
                        <li><a href="{{ url('/#armada') }}" class="inline-block text-xs sm:text-sm text-black hover:text-amber-600 active:text-amber-700 active:bg-amber-50 active:scale-95 px-2 py-1 rounded-lg transition-all font-medium">Pilihan Armada</a></li>
                    </ul>
                </div>

                <!-- Contact & Support -->
                <div>
                    <h3 class="text-xs font-black uppercase tracking-wider text-black border-l-2 border-amber-400 pl-2">Dukungan</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="https://wa.me/628123456789" target="_blank" class="inline-block text-xs sm:text-sm text-black hover:text-emerald-600 active:text-emerald-700 active:bg-emerald-50 active:scale-95 px-2 py-1 rounded-lg transition-all font-medium"><i class="fa-brands fa-whatsapp text-emerald-500 mr-1"></i> Hubungi WhatsApp CS</a></li>
                        <li><a href="{{ url('/#faq') }}" class="inline-block text-xs sm:text-sm text-black hover:text-amber-600 active:text-amber-700 active:bg-amber-50 active:scale-95 px-2 py-1 rounded-lg transition-all font-medium">Tanya Jawab (FAQ)</a></li>
                        <li><a href="{{ url('/#kontak') }}" class="inline-block text-xs sm:text-sm text-black hover:text-amber-600 active:text-amber-700 active:bg-amber-50 active:scale-95 px-2 py-1 rounded-lg transition-all font-medium">Lokasi Kantor</a></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright / Bottom -->
            <div class="pt-8 mt-12 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs">
                <p class="text-black font-semibold">
                    &copy; {{ date('Y') }} CV. Travel RTM Family. Hak Cipta Dilindungi.
                </p>
                <div class="flex space-x-4 text-black font-medium">
                    <a href="{{ url('/') }}" class="hover:text-amber-600 active:text-amber-700 active:scale-95 transition-all">Kebijakan Privasi</a>
                    <span>&bull;</span>
                    <a href="{{ url('/') }}" class="hover:text-amber-600 active:text-amber-700 active:scale-95 transition-all">Syarat & Ketentuan</a>
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
