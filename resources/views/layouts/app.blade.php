<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CV. Travel RTM Information System')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite Build Assets (Tailwind CSS v4 & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
</head>
<body class="min-h-screen flex flex-col justify-between selection:bg-brand-500 selection:text-slate-900">

    <!-- Top Navbar -->
    <nav class="bg-white sticky top-0 z-50 px-6 py-4 flex items-center justify-between border-b border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-slate-900 border border-brand-500/40 flex items-center justify-center text-brand-500 shadow-md">
                <i class="fa-solid font-bold text-lg fa-bus"></i>
            </div>
            <div>
                <a href="{{ url('/') }}" class="font-extrabold text-xl tracking-tight text-slate-900">CV. Travel RTM</a>
                <span class="block text-xs text-amber-700 font-extrabold uppercase tracking-wider">System Information</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            @auth
                <div class="flex items-center gap-3 bg-slate-100 px-4 py-2 rounded-xl border border-slate-200">
                    <div class="w-8 h-8 rounded-full bg-brand-500 text-slate-900 flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden sm:block text-left">
                        <span class="block text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                        <span class="block text-xs font-extrabold text-amber-700">
                            @if(Auth::user()->hasRole('Admin'))
                                Admin
                            @elseif(Auth::user()->hasRole('Sopir'))
                                Sopir
                            @else
                                Penumpang
                            @endif
                        </span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm font-bold text-slate-700 hover:text-status-danger bg-slate-100 hover:bg-red-50 border border-slate-200 rounded-xl transition duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-brand-600 transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-bold text-slate-900 bg-brand-500 hover:bg-brand-400 rounded-xl shadow transition">Daftar</a>
            @endauth
        </div>
    </nav>

    <!-- Flash Alerts -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 py-8">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-xl text-emerald-500"></i>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-700 flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-xl text-red-500"></i>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 py-6 text-center text-xs text-slate-400 border-t border-slate-800">
        <p>&copy; {{ date('Y') }} <strong>CV. Travel RTM</strong>. All rights reserved.</p>
    </footer>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
