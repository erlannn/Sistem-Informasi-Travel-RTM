<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'CV. Travel RTM - Driver Portal')</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Vite Build Assets (Tailwind CSS v4 & JS) & Alpine.js -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    /* Mobile Shell Constraints */
    .mobile-container {
      max-width: 480px;
      margin: 0 auto;
    }
    @media print {
      body * {
        visibility: hidden;
      }
      #printable-slip, #printable-slip * {
        visibility: visible;
      }
      #printable-slip {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
      }
    }
  </style>
  @yield('styles')
</head>
<body class="bg-slate-900 min-h-screen flex flex-col antialiased selection:bg-brand-500 selection:text-slate-900">

  <!-- Outer Shell Wrapper for Mobile Viewport Emulation (Centered & Premium) -->
  <div class="w-full flex-grow flex flex-col bg-slate-50 min-h-screen shadow-2xl relative border-x border-slate-200 mobile-container pb-24">
    
    <!-- Top Greeting Header -->
    <header class="bg-gradient-to-r from-slate-900 via-slate-950 to-slate-900 text-white p-6 rounded-b-3xl shadow-lg relative overflow-hidden shrink-0">
      <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:12px_12px]"></div>
      
      <div class="relative flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-full bg-amber-500/20 border border-amber-500/40 flex items-center justify-center text-amber-400 text-lg shadow-md">
            <i class="fa-solid fa-id-badge"></i>
          </div>
          <div>
            <p class="text-xs text-amber-400 font-extrabold uppercase tracking-wider">Driver Portal</p>
            <h2 class="text-base font-extrabold text-white">
              @auth
                Selamat Datang, {{ Auth::user()->name }}
              @else
                Selamat Datang, Sopir
              @endauth
            </h2>
          </div>
        </div>
        
        <!-- Action items / Logout -->
        <div class="flex items-center gap-2">
          <a href="{{ url('/') }}" class="text-xs bg-white/10 hover:bg-white/20 text-white px-3 py-1.5 rounded-xl border border-white/10 font-bold transition-all flex items-center gap-1.5">
            <i class="fa-solid fa-house"></i> Home
          </a>
          @auth
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" title="Keluar" class="text-xs bg-red-500/20 hover:bg-red-500/30 text-red-300 px-3 py-1.5 rounded-xl border border-red-500/30 font-bold transition-all">
                <i class="fa-solid fa-right-from-bracket"></i>
              </button>
            </form>
          @endauth
        </div>
      </div>
    </header>

    <!-- Flash Alerts -->
    <div class="px-4 mt-4">
      @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 flex items-center gap-2.5 shadow-sm text-xs font-semibold">
          <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if(session('error'))
        <div class="p-3.5 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-700 flex items-center gap-2.5 shadow-sm text-xs font-semibold">
          <i class="fa-solid fa-circle-exclamation text-red-500 text-base"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif
    </div>

    <!-- Workspace Content -->
    <main class="flex-grow p-4 space-y-6 overflow-y-auto">
      @yield('content')
    </main>

    <!-- Bottom Sticky Thumb-Friendly Navigation Bar -->
    <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white/95 backdrop-blur-md border-t border-slate-200 z-50 px-3 py-2 flex justify-around items-center shadow-2xl">
      <a href="{{ url('/sopir/dashboard') }}" class="flex flex-col items-center gap-1 text-slate-600 hover:text-brand-600 transition-colors py-1 px-3">
        <i class="fa-solid fa-gauge-high text-lg"></i>
        <span class="text-[10px] font-bold">Dashboard</span>
      </a>

      <a href="#" class="flex flex-col items-center gap-1 text-slate-600 hover:text-brand-600 transition-colors py-1 px-3">
        <i class="fa-solid fa-users text-lg"></i>
        <span class="text-[10px] font-bold">Manifes</span>
      </a>

      <a href="#" class="flex flex-col items-center gap-1 text-slate-600 hover:text-brand-600 transition-colors py-1 px-3">
        <i class="fa-solid fa-calendar-check text-lg"></i>
        <span class="text-[10px] font-bold">Jadwal Saya</span>
      </a>

      <a href="#" class="flex flex-col items-center gap-1 text-slate-600 hover:text-brand-600 transition-colors py-1 px-3">
        <i class="fa-solid fa-wallet text-lg"></i>
        <span class="text-[10px] font-bold">Slip Gaji</span>
      </a>
    </nav>

  </div>

  @yield('scripts')
  @stack('scripts')
</body>
</html>
