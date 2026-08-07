<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'CV. Travel RTM - Admin Dashboard')</title>

  <!-- Favicon (Logo RTM Family) -->
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Vite Build Assets & Alpine.js & Chart.js -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  @yield('styles')
  @stack('styles')
</head>

<body class="bg-slate-50 text-slate-900 font-sans min-h-screen flex antialiased" x-data="{ mobileSidebarOpen: false }">

  <!-- Sidebar Component (Deep Slate #0F172A with Brand Accent) -->
  <aside class="w-64 bg-slate-900 text-slate-300 hidden md:flex flex-col border-r border-slate-800 shrink-0 min-h-screen sticky top-0 h-screen z-40">
    <!-- Brand Info Header with Logo PNG -->
    <div class="h-20 border-b border-slate-800 flex items-center px-6 gap-3">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-slate-950 border border-slate-800 flex items-center justify-center p-2 shadow-md shrink-0">
          <img src="{{ asset('images/logo.png') }}" alt="Logo CV. Travel RTM" class="w-full h-auto object-contain select-none pointer-events-none">
        </div>
        <div>
          <span class="font-extrabold text-white text-sm tracking-tight block">CV. Travel RTM</span>
          <span class="text-[10px] text-brand-500 font-bold uppercase tracking-wider">Admin Dashboard</span>
        </div>
      </a>
    </div>

    <!-- Sidebar Navigation Menus -->
    <nav class="flex-grow py-6 px-4 space-y-1.5 overflow-y-auto">
      <a href="{{ route('admin.dashboard') }}"
        class="block px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.dashboard') ? 'bg-brand-500/15 text-brand-500 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        Dashboard
      </a>

      <a href="{{ route('admin.armada.index') }}"
        class="block px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.armada.*') ? 'bg-brand-500/15 text-brand-500 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        Kelola Armada
      </a>

      <a href="{{ route('admin.sopir.index') }}"
        class="block px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.sopir.*') ? 'bg-brand-500/15 text-brand-500 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        Kelola Sopir
      </a>

      <a href="{{ route('admin.penumpang.index') }}"
        class="block px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.penumpang.*') ? 'bg-brand-500/15 text-brand-500 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        Data Penumpang
      </a>

      <a href="{{ route('admin.jadwal.index') }}"
        class="block px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.jadwal.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        Jadwal Perjalanan
      </a>

      <a href="{{ route('admin.pemesanan.index') }}"
        class="block px-4 py-3 rounded-xl text-xs font-semibold transition-all {{ Request::routeIs('admin.pemesanan.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
        Transaksi Pemesanan
      </a>
    </nav>
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
        <div class="w-8 h-8 rounded-full bg-slate-950 border border-slate-800 flex items-center justify-center p-1.5">
          <img src="{{ asset('images/logo.png') }}" alt="Logo Portal" class="w-full h-auto object-contain">
        </div>
        <span class="font-extrabold text-white text-sm">Admin Portal</span>
      </div>
      <button @click="mobileSidebarOpen = false" class="text-slate-400 hover:text-white">
        &times;
      </button>
    </div>
    <nav class="flex-grow py-6 px-4 space-y-1.5 overflow-y-auto">
      <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.dashboard') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        Dashboard
      </a>
      <a href="{{ route('admin.armada.index') }}" class="block px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.armada.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        Kelola Armada
      </a>
      <a href="{{ route('admin.sopir.index') }}" class="block px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.sopir.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        Kelola Sopir
      </a>
      <a href="{{ route('admin.penumpang.index') }}" class="block px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.penumpang.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        Data Penumpang
      </a>
      <a href="{{ route('admin.jadwal.index') }}" class="block px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.jadwal.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        Jadwal Perjalanan
      </a>
      <a href="{{ route('admin.pemesanan.index') }}" class="block px-4 py-3 rounded-xl text-xs font-semibold {{ Request::routeIs('admin.pemesanan.*') ? 'bg-brand-500/15 text-brand-400 border-l-4 border-brand-500 font-bold' : 'text-slate-400' }}">
        Transaksi Pemesanan
      </a>
    </nav>
  </div>

  <!-- Main Content & Topbar Container -->
  <div class="flex flex-col flex-grow min-w-0">
    <header class="h-20 bg-white/90 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-6 md:px-8 sticky top-0 z-30 shadow-xs relative">
      <!-- Accent Gradient Line from brand-500 via gold-400 -->
      <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-gradient-to-r from-brand-500 via-gold-400 to-brand-500 opacity-80"></div>

      <!-- Mobile Sidebar Toggle -->
      <div class="flex items-center gap-3 md:hidden">
        <button @click="mobileSidebarOpen = true" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 hover:bg-slate-200 transition-colors text-xs font-bold">
          Menu
        </button>
        <span class="font-extrabold text-slate-800 text-sm">CV. Travel RTM</span>
      </div>

      <!-- Desktop Breadcrumb / Title -->
      <div class="hidden md:block">
        <h1 class="text-lg font-extrabold text-slate-800 tracking-tight">
          @yield('page_title', 'Admin Control Center')
        </h1>
        <p class="text-xs text-slate-500 font-medium">Pengelolaan Sistem Informasi CV. Travel RTM</p>
      </div>

      <!-- Admin Profile & Actions Header -->
      <div class="flex items-center gap-4">
        @auth
          <div class="text-right hidden sm:block">
            <span class="block text-xs font-bold text-slate-800">{{ Auth::user()->name }}</span>
            <span class="inline-block px-2 py-0.5 rounded-md bg-brand-50 text-brand-700 border border-brand-200 font-extrabold text-[10px] uppercase tracking-wider">Administrator</span>
          </div>
          <div class="relative" x-data="{ userMenuOpen: false }">
            <button @click="userMenuOpen = !userMenuOpen" class="w-9 h-9 rounded-full bg-slate-900 border border-slate-800 text-brand-500 font-extrabold flex items-center justify-center shadow-xs transition-all">
              {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </button>
            <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-transition:enter="transition ease-out duration-100"
              x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
              x-transition:leave-end="transform opacity-0 scale-95"
              class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 font-bold">
                  Keluar
                </button>
              </form>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="text-xs font-semibold text-brand-600">Masuk</a>
        @endauth
      </div>
    </header>

    <!-- Flash Alerts -->
    <div class="px-6 md:px-8 mt-4">
      @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold shadow-xs">
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs font-bold shadow-xs">
          {{ session('error') }}
        </div>
      @endif

      @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs font-bold shadow-xs space-y-1">
          <p class="font-extrabold">Terjadi kesalahan input data:</p>
          <ul class="list-disc list-inside text-[11px] font-medium">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    <!-- Main Content Viewport -->
    <main class="flex-grow p-6 md:p-8 overflow-y-auto w-full">
      @yield('content')
    </main>

    <!-- Footer Admin -->
    <footer class="bg-white border-t border-slate-200 py-4 px-6 md:px-8 text-xs text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-2">
      <p>&copy; {{ date('Y') }} <strong>CV. Travel RTM</strong>. Hak Cipta Dilindungi.</p>
      <span class="text-[11px] font-semibold text-slate-500">System Information Panel</span>
    </footer>
  </div>

  @yield('scripts')
  @stack('scripts')
</body>

</html>
