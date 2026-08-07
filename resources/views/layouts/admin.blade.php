<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'CV. Travel RTM - Admin Dashboard')</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Vite Build Assets (Tailwind CSS v4 & JS), Alpine.js & Chart.js -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  @yield('styles')
</head>

<body class="bg-slate-50 text-slate-900 font-sans min-h-screen flex antialiased" x-data="{ mobileSidebarOpen: false }">

  <!-- Sidebar Component (Deep Slate #0F172A / #1E293B) -->
  <aside class="w-64 bg-slate-900 text-slate-300 hidden md:flex flex-col border-r border-slate-800 shrink-0 min-h-screen sticky top-0 h-screen">
    <!-- Brand Info Header -->
    <div class="h-20 border-b border-slate-800 flex items-center px-6 gap-3">
      <div class="w-10 h-10 rounded-xl bg-slate-950 border border-brand-500/40 flex items-center justify-center text-brand-500 shadow-md shadow-brand-500/20">
        <i class="fa-solid fa-shield-halved text-lg"></i>
      </div>
      <div>
        <span class="font-extrabold text-white text-md tracking-tight block">CV. Travel RTM</span>
        <span class="text-[10px] text-brand-400 font-bold uppercase tracking-wider">Admin Dashboard</span>
      </div>
    </div>

    <!-- Sidebar Navigation Menus -->
    <nav class="flex-grow py-6 px-4 space-y-1.5 overflow-y-auto">
      <a href="{{ url('/admin/dashboard') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ Request::is('admin/dashboard*') ? 'bg-brand-500/10 text-brand-400 border-l-4 border-brand-500 shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-400' }}">
        <i class="fa-solid fa-chart-pie w-5"></i> Dashboard
      </a>

      <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-800 hover:text-white text-slate-400">
        <i class="fa-solid fa-bus w-5"></i> Kelola Armada
      </a>

      <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-800 hover:text-white text-slate-400">
        <i class="fa-solid fa-user-tie w-5"></i> Kelola Sopir
      </a>

      <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-800 hover:text-white text-slate-400">
        <i class="fa-solid fa-users-viewfinder w-5"></i> Data Penumpang
      </a>

      <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-800 hover:text-white text-slate-400">
        <i class="fa-solid fa-calendar-days w-5"></i> Jadwal Perjalanan
      </a>

      <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-800 hover:text-white text-slate-400">
        <i class="fa-solid fa-receipt w-5"></i> Transaksi Pemesanan
      </a>

      <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-800 hover:text-white text-slate-400">
        <i class="fa-solid fa-chart-line w-5"></i> Laporan Analytics
      </a>
    </nav>

    <!-- Sidebar Bottom User Profile & Navigation Button -->
    <div class="p-4 border-t border-slate-800 space-y-3">
      @auth
        <div class="flex items-center gap-3 px-3 py-2 bg-slate-800/60 rounded-xl border border-slate-800">
          <div class="w-8 h-8 rounded-lg bg-brand-500 text-slate-900 flex items-center justify-center font-bold text-xs">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
          <div class="overflow-hidden">
            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
            <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
          </div>
        </div>
      @endauth

      <a href="{{ url('/') }}"
        class="flex items-center gap-2 justify-center py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold rounded-xl border border-slate-700 transition-colors">
        <i class="fa-solid fa-house"></i> Portal Utama
      </a>
    </div>
  </aside>

  <!-- Mobile Drawer Sidebar Backdrop -->
  <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/80 z-40 md:hidden"></div>

  <!-- Mobile Sidebar Drawer Panel -->
  <div x-show="mobileSidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-slate-300 z-50 flex flex-col md:hidden border-r border-slate-800">
    <div class="h-20 border-b border-slate-800 flex items-center justify-between px-6">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl bg-slate-950 border border-brand-500/40 flex items-center justify-center text-brand-500">
          <i class="fa-solid fa-shield-halved text-sm"></i>
        </div>
        <span class="font-extrabold text-white text-sm">Admin Portal</span>
      </div>
      <button @click="mobileSidebarOpen = false" class="text-slate-400 hover:text-white">
        <i class="fa-solid fa-xmark text-lg"></i>
      </button>
    </div>
    <nav class="flex-grow py-6 px-4 space-y-1.5 overflow-y-auto">
      <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold bg-brand-500/10 text-brand-400 border-l-4 border-brand-500">
        <i class="fa-solid fa-chart-pie w-5"></i> Dashboard
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 text-slate-400">
        <i class="fa-solid fa-bus w-5"></i> Kelola Armada
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 text-slate-400">
        <i class="fa-solid fa-user-tie w-5"></i> Kelola Sopir
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 text-slate-400">
        <i class="fa-solid fa-users-viewfinder w-5"></i> Data Penumpang
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 text-slate-400">
        <i class="fa-solid fa-calendar-days w-5"></i> Jadwal Perjalanan
      </a>
    </nav>
  </div>

  <!-- Main Content & Topbar Container -->
  <div class="flex flex-col flex-grow min-w-0">
    <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 md:px-8 sticky top-0 z-30 shadow-sm">
      <!-- Mobile Sidebar Toggle -->
      <div class="flex items-center gap-3 md:hidden">
        <button @click="mobileSidebarOpen = true" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 hover:bg-slate-200 transition-colors">
          <i class="fa-solid fa-bars text-lg"></i>
        </button>
        <span class="font-extrabold text-slate-800 text-sm">Travel RTM</span>
      </div>

      <!-- Desktop Breadcrumb / Title -->
      <div class="hidden md:block">
        <h1 class="text-lg font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
          <i class="fa-solid fa-shield-halved text-brand-500"></i>
          @yield('page_title', 'Admin Dashboard Control Center')
        </h1>
        <p class="text-xs text-slate-400 font-medium">Pengelolaan Sistem Informasi Travel CV. Travel RTM</p>
      </div>

      <!-- Admin Profile & Actions Header -->
      <div class="flex items-center gap-4">
        @auth
          <div class="text-right hidden sm:block">
            <span class="block text-sm font-bold text-slate-800">{{ Auth::user()->name }}</span>
            <span class="inline-block px-2 py-0.5 rounded-md bg-purple-100 text-purple-700 font-bold text-[10px] uppercase tracking-wider">Administrator</span>
          </div>
          <div class="relative" x-data="{ userMenuOpen: false }">
            <button @click="userMenuOpen = !userMenuOpen" class="w-10 h-10 rounded-full bg-slate-900 text-brand-400 font-bold flex items-center justify-center border border-slate-200 shadow-sm hover:scale-105 transition-transform">
              {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </button>
            <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-transition:enter="transition ease-out duration-100"
              x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
              x-transition:leave-end="transform opacity-0 scale-95"
              class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-semibold flex items-center gap-2">
                  <i class="fa-solid fa-right-from-bracket w-4"></i> Keluar
                </button>
              </form>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="text-sm font-semibold text-brand-600">Masuk</a>
        @endauth
      </div>
    </header>

    <!-- Flash Alerts -->
    <div class="px-6 md:px-8 mt-4">
      @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 flex items-center gap-3 shadow-sm">
          <i class="fa-solid fa-circle-check text-xl text-emerald-500"></i>
          <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
      @endif

      @if(session('error'))
        <div class="p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-700 flex items-center gap-3 shadow-sm">
          <i class="fa-solid fa-circle-exclamation text-xl text-red-500"></i>
          <span class="text-sm font-semibold">{{ session('error') }}</span>
        </div>
      @endif
    </div>

    <!-- Main Content Viewport -->
    <main class="flex-grow p-6 md:p-8 overflow-y-auto w-full">
      @yield('content')
    </main>

    <!-- Footer Admin -->
    <footer class="bg-white border-t border-slate-200 py-4 px-6 md:px-8 text-xs text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-2">
      <p>&copy; {{ date('Y') }} <strong>CV. Travel RTM</strong>. All rights reserved.</p>
      <span class="text-[11px] font-semibold text-slate-500">Admin Control Panel v1.0</span>
    </footer>
  </div>

  @yield('scripts')
  @stack('scripts')
</body>

</html>
