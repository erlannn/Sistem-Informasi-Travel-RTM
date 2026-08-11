<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'CV. Travel RTM - Admin Dashboard')</title>

  <!-- Favicon (Logo RTM Family) -->
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

  <!-- Fonts & Icons: Traveloka Font Stack (Plus Jakarta Sans & Inter) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Vite Build Assets & Alpine.js & Chart.js -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  @yield('styles')
  @stack('styles')
</head>

<<<<<<< HEAD
<body class="bg-slate-50 text-slate-900 font-sans min-h-screen flex antialiased" x-data="{ mobileSidebarOpen: false, desktopSidebarOpen: localStorage.getItem('admin_sidebar_open') !== 'false', toggleDesktopSidebar() { this.desktopSidebarOpen = !this.desktopSidebarOpen; localStorage.setItem('admin_sidebar_open', this.desktopSidebarOpen); } }">

  <!-- Sidebar Component (Deep Slate #0F172A with Brand Accent) -->
  <aside x-show="desktopSidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="-translate-x-full opacity-0" class="w-64 bg-slate-900 text-slate-300 hidden md:flex flex-col border-r border-slate-800 shrink-0 min-h-screen sticky top-0 h-screen z-40">
    <!-- Brand Info Header with Logo PNG & Toggle Button -->
    <div class="h-20 border-b border-slate-800 flex items-center justify-between px-5">
=======
<body class="bg-slate-50 text-black font-sans min-h-screen flex antialiased" x-data="{ mobileSidebarOpen: false }">

  <!-- Sidebar Component (Deep Slate #0F172A with Brand Accent) -->
  <!-- Sidebar Component (Deep Slate with High-Contrast Amber Highlights) -->
  <aside class="w-64 bg-slate-950 text-slate-100 hidden md:flex flex-col border-r border-slate-800 shrink-0 min-h-screen sticky top-0 h-screen z-40">
    <!-- Brand Info Header with Logo PNG -->
    <div class="h-20 border-b border-slate-800 flex items-center px-6 gap-3">
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center p-2 shadow-md shrink-0">
          <img src="{{ asset('images/logo.png') }}" alt="Logo CV. Travel RTM" class="w-full h-auto object-contain select-none pointer-events-none">
        </div>
        <div>
          <span class="font-extrabold text-white text-sm tracking-tight block">CV. Travel RTM</span>
          <span class="text-[10px] text-amber-400 font-extrabold uppercase tracking-wider">Admin Dashboard</span>
        </div>
      </a>
      {{-- <button @click="toggleDesktopSidebar()" class="hidden md:flex items-center justify-center w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors cursor-pointer shrink-0" title="Tutup Sidebar">
        <i class="fa-solid fa-chevron-left text-xs"></i>
      </button> --}}
    </div>

    <!-- Sidebar Navigation Menus -->
    <nav class="flex-grow py-6 px-4 space-y-2 overflow-y-auto">
      <a href="{{ route('admin.dashboard') }}"
<<<<<<< HEAD
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.dashboard') ? 'bg-brand-500/15 text-brand-500 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        <i class="fa-solid fa-gauge-high text-sm text-center w-5"></i>
        <span>Dashboard</span>
      </a>

      <a href="{{ route('admin.jadwal.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.jadwal.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        <i class="fa-solid fa-calendar-days text-sm text-center w-5"></i>
        <span>Jadwal Perjalanan</span>
      </a>

      <a href="{{ route('admin.armada.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.armada.*') ? 'bg-brand-500/15 text-brand-500 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        <i class="fa-solid fa-van-shuttle text-sm text-center w-5"></i>
        <span>Kelola Armada</span>
      </a>

      <a href="{{ route('admin.sopir.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.sopir.*') ? 'bg-brand-500/15 text-brand-500 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        <i class="fa-solid fa-id-card text-sm text-center w-5"></i>
        <span>Kelola Sopir</span>
      </a>

      <a href="{{ route('admin.penumpang.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.penumpang.*') ? 'bg-brand-500/15 text-brand-500 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        <i class="fa-solid fa-users text-sm text-center w-5"></i>
        <span>Data Penumpang</span>
      </a>

      <a href="{{ route('admin.pemesanan.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.pemesanan.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        <i class="fa-solid fa-ticket text-sm text-center w-5"></i>
        <span>Transaksi Pemesanan</span>
      </a>

      <a href="{{ route('admin.setoran.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.setoran.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        <i class="fa-solid fa-file-invoice-dollar text-sm text-center w-5"></i>
        <span>Laporan</span>
=======
        class="flex items-center px-4 py-3.5 rounded-xl text-sm transition-all {{ Request::routeIs('admin.dashboard') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black shadow-sm' : 'text-slate-200 hover:bg-slate-800/90 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-gauge-high mr-3 text-base text-center w-5"></i>
        <span>Dashboard</span>
      </a>

      <a href="{{ route('admin.armada.index') }}"
        class="flex items-center px-4 py-3.5 rounded-xl text-sm transition-all {{ Request::routeIs('admin.armada.*') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black shadow-sm' : 'text-slate-200 hover:bg-slate-800/90 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-car mr-3 text-base text-center w-5"></i>
        <span>Kelola Armada</span>
      </a>

      <a href="{{ route('admin.sopir.index') }}"
        class="flex items-center px-4 py-3.5 rounded-xl text-sm transition-all {{ Request::routeIs('admin.sopir.*') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black shadow-sm' : 'text-slate-200 hover:bg-slate-800/90 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-user-tie mr-3 text-base text-center w-5"></i>
        <span>Kelola Sopir</span>
      </a>

      <a href="{{ route('admin.penumpang.index') }}"
        class="flex items-center px-4 py-3.5 rounded-xl text-sm transition-all {{ Request::routeIs('admin.penumpang.*') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black shadow-sm' : 'text-slate-200 hover:bg-slate-800/90 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-users mr-3 text-base text-center w-5"></i>
        <span>Data Penumpang</span>
      </a>

      <a href="{{ route('admin.jadwal.index') }}"
        class="flex items-center px-4 py-3.5 rounded-xl text-sm transition-all {{ Request::routeIs('admin.jadwal.*') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black shadow-sm' : 'text-slate-200 hover:bg-slate-800/90 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-calendar-days mr-3 text-base text-center w-5"></i>
        <span>Jadwal Perjalanan</span>
      </a>

      <a href="{{ route('admin.pemesanan.index') }}"
        class="flex items-center px-4 py-3.5 rounded-xl text-sm transition-all {{ Request::routeIs('admin.pemesanan.*') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black shadow-sm' : 'text-slate-200 hover:bg-slate-800/90 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-receipt mr-3 text-base text-center w-5"></i>
        <span>Transaksi Pemesanan</span>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
      </a>
    </nav>
  </aside>

  <!-- Mobile Drawer Sidebar Backdrop -->
  <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-950/80 z-40 md:hidden"></div>

  <!-- Mobile Sidebar Drawer Panel -->
  <div x-show="mobileSidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed inset-y-0 left-0 w-64 bg-slate-950 text-slate-100 z-50 flex flex-col md:hidden border-r border-slate-800">
    <div class="h-20 border-b border-slate-800 flex items-center justify-between px-6">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center p-1.5">
          <img src="{{ asset('images/logo.png') }}" alt="Logo Portal" class="w-full h-auto object-contain">
        </div>
        <span class="font-extrabold text-white text-sm">Admin Portal</span>
      </div>
      <button @click="mobileSidebarOpen = false" class="text-slate-300 hover:text-white p-2">
        <i class="fa-solid fa-xmark text-xl"></i>
      </button>
    </div>
<<<<<<< HEAD
    <nav class="flex-grow py-6 px-4 space-y-1.5 overflow-y-auto">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.dashboard') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        <i class="fa-solid fa-gauge-high text-sm text-center w-5"></i>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('admin.jadwal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.jadwal.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        <i class="fa-solid fa-calendar-days text-sm text-center w-5"></i>
        <span>Jadwal Perjalanan</span>
      </a>
      <a href="{{ route('admin.armada.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.armada.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        <i class="fa-solid fa-van-shuttle text-sm text-center w-5"></i>
        <span>Kelola Armada</span>
      </a>
      <a href="{{ route('admin.sopir.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.sopir.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        <i class="fa-solid fa-id-card text-sm text-center w-5"></i>
        <span>Kelola Sopir</span>
      </a>
      <a href="{{ route('admin.penumpang.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.penumpang.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        <i class="fa-solid fa-users text-sm text-center w-5"></i>
        <span>Data Penumpang</span>
      </a>
      <a href="{{ route('admin.pemesanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.pemesanan.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        <i class="fa-solid fa-ticket text-sm text-center w-5"></i>
        <span>Transaksi Pemesanan</span>
      </a>
      <a href="{{ route('admin.setoran.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.setoran.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        <i class="fa-solid fa-file-invoice-dollar text-sm text-center w-5"></i>
        <span>Laporan</span>
=======
    <nav class="flex-grow py-6 px-4 space-y-2 overflow-y-auto">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3.5 rounded-xl text-sm {{ Request::routeIs('admin.dashboard') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black' : 'text-slate-200 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-gauge-high mr-3 text-base text-center w-5"></i>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('admin.armada.index') }}" class="flex items-center px-4 py-3.5 rounded-xl text-sm {{ Request::routeIs('admin.armada.*') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black' : 'text-slate-200 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-car mr-3 text-base text-center w-5"></i>
        <span>Kelola Armada</span>
      </a>
      <a href="{{ route('admin.sopir.index') }}" class="flex items-center px-4 py-3.5 rounded-xl text-sm {{ Request::routeIs('admin.sopir.*') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black' : 'text-slate-200 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-user-tie mr-3 text-base text-center w-5"></i>
        <span>Kelola Sopir</span>
      </a>
      <a href="{{ route('admin.penumpang.index') }}" class="flex items-center px-4 py-3.5 rounded-xl text-sm {{ Request::routeIs('admin.penumpang.*') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black' : 'text-slate-200 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-users mr-3 text-base text-center w-5"></i>
        <span>Data Penumpang</span>
      </a>
      <a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-4 py-3.5 rounded-xl text-sm {{ Request::routeIs('admin.jadwal.*') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black' : 'text-slate-200 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-calendar-days mr-3 text-base text-center w-5"></i>
        <span>Jadwal Perjalanan</span>
      </a>
      <a href="{{ route('admin.pemesanan.index') }}" class="flex items-center px-4 py-3.5 rounded-xl text-sm {{ Request::routeIs('admin.pemesanan.*') ? 'bg-amber-400/20 text-amber-400 border-l-4 border-amber-400 font-black' : 'text-slate-200 hover:text-amber-400 font-bold' }}">
        <i class="fa-solid fa-receipt mr-3 text-base text-center w-5"></i>
        <span>Transaksi Pemesanan</span>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
      </a>
    </nav>
  </div>

  <!-- Main Content & Topbar Container -->
  <div class="flex flex-col flex-grow min-w-0">
    <header class="h-20 bg-white/95 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-6 sm:px-8 lg:px-10 sticky top-0 z-30 shadow-xs relative">
      <!-- Accent Gradient Line from amber-500 via gold-400 -->
      <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 opacity-90"></div>

      <!-- Mobile Sidebar Toggle -->
      <div class="flex items-center gap-3 md:hidden">
<<<<<<< HEAD
        <button @click="mobileSidebarOpen = true" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 hover:bg-slate-200 transition-colors text-xs font-bold cursor-pointer">
=======
        <button @click="mobileSidebarOpen = true" class="w-10 h-10 rounded-xl bg-slate-950 text-white flex items-center justify-center hover:bg-slate-900 transition-colors text-xs font-bold shadow-xs">
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
          <i class="fa-solid fa-bars text-sm"></i>
        </button>
        <span class="font-black text-black text-sm uppercase tracking-wider">CV. Travel RTM</span>
      </div>

<<<<<<< HEAD
      <!-- Desktop Sidebar Toggle & Title -->
      <div class="hidden md:flex items-center gap-4">
        <button @click="toggleDesktopSidebar()" 
          class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 transition-colors flex items-center justify-center cursor-pointer shadow-xs" 
          title="Buka/Tutup Sidebar">
          <i class="fa-solid fa-bars text-sm"></i>
        </button>
        <div>
          <h1 class="text-lg font-extrabold text-slate-800 tracking-tight">
            @yield('page_title', 'Admin Control Center')
          </h1>
          <p class="text-xs text-slate-500 font-medium">Pengelolaan Sistem Informasi CV. Travel RTM</p>
        </div>
=======
      <!-- Desktop Breadcrumb / Title -->
      <div class="hidden md:block">
        <h1 class="text-xl font-black text-black tracking-tight uppercase">
          @yield('page_title', 'Admin Control Center')
        </h1>
        <p class="text-xs sm:text-sm text-black font-medium">Pengelolaan Sistem Informasi CV. Travel RTM</p>
>>>>>>> a0f5ea27d30b535e03fa56f82fcb748e7b313b14
      </div>

      <!-- Admin Profile & Actions Header -->
      <div class="flex items-center gap-4">
        @auth
          <div class="text-right hidden sm:block">
            <span class="block text-sm font-black text-black leading-tight">{{ Auth::user()->name }}</span>
            <span class="inline-block px-2.5 py-0.5 rounded-md bg-amber-100 text-amber-900 border border-amber-300 font-black text-[11px] uppercase tracking-wider mt-0.5">Administrator</span>
          </div>
          <div class="relative" x-data="{ userMenuOpen: false }">
            <button @click="userMenuOpen = !userMenuOpen" class="w-10 h-10 rounded-full bg-slate-950 border-2 border-amber-400/60 text-amber-400 font-black flex items-center justify-center shadow-xs hover:scale-105 active:scale-95 transition-all cursor-pointer">
              {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </button>
            <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-transition:enter="transition ease-out duration-100"
              x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
              x-transition:leave-end="transform opacity-0 scale-95"
              class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2.5 text-xs font-black text-red-600 hover:bg-red-50 active:bg-red-100 flex items-center gap-2 cursor-pointer transition-colors">
                  <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
              </form>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="text-xs sm:text-sm font-bold text-black hover:text-amber-600">Masuk</a>
        @endauth
      </div>
    </header>

    <!-- Flash Alerts -->
    <div class="px-6 sm:px-8 lg:px-10 mt-6">
      @if(session('success'))
        <div class="p-4 sm:p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs sm:text-sm font-bold shadow-xs">
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="p-4 sm:p-5 rounded-2xl bg-red-50 border border-red-200 text-red-900 text-xs sm:text-sm font-bold shadow-xs">
          {{ session('error') }}
        </div>
      @endif

      @if($errors->any())
        <div class="p-4 sm:p-5 rounded-2xl bg-red-50 border border-red-200 text-red-900 text-xs sm:text-sm font-bold shadow-xs space-y-1.5">
          <p class="font-black">Terjadi kesalahan input data:</p>
          <ul class="list-disc list-inside text-xs sm:text-sm font-medium">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    <!-- Main Content Viewport -->
    <main class="flex-grow p-6 sm:p-8 lg:p-10 overflow-y-auto w-full">
      @yield('content')
    </main>

    <!-- Footer Admin -->
    <footer class="bg-white border-t border-slate-200 py-5 px-6 sm:px-8 lg:px-10 text-xs sm:text-sm text-black flex flex-col sm:flex-row items-center justify-between gap-3">
      <p class="font-medium">&copy; {{ date('Y') }} <strong class="font-black">CV. Travel RTM</strong>. Hak Cipta Dilindungi.</p>
      <span class="text-xs font-extrabold text-amber-700 uppercase tracking-wider">System Information Panel</span>
    </footer>
  </div>

  @yield('scripts')
  @stack('scripts')
</body>

</html>
