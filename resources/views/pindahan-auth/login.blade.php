<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Travel RTM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased text-slate-900 bg-white">

    <div class="flex min-h-screen flex-col md:flex-row">
        
        <!-- Left Side: Brand Banner (Visible only on md screens and up, full height) -->
        <div class="hidden md:flex md:w-1/2 bg-slate-50 relative items-center justify-center p-12 overflow-hidden border-r border-slate-100">
            
            <div class="relative z-10 text-center max-w-sm">
                <!-- Brand Logo with clean dark circle -->
                <div class="w-28 h-28 mx-auto mb-6 bg-slate-950 rounded-full p-5 border border-slate-900 shadow-md flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo RTM" class="w-full h-auto object-contain select-none pointer-events-none">
                </div>
                
                <!-- Brand Title -->
                <h1 class="text-2xl font-bold tracking-wider text-slate-900 uppercase leading-none">
                    Travel RTM
                </h1>
                <p class="text-[10px] text-gold-600 font-semibold tracking-widest uppercase mt-2">
                    RTM Family
                </p>
                <div class="w-10 h-[2px] bg-brand-500 rounded-full mx-auto mt-4"></div>
                <p class="text-xs text-slate-500 mt-6 leading-relaxed font-light">
                    Solusi perjalanan antar kota terbaik dengan kenyamanan dan keamanan kelas utama.
                </p>
            </div>
        </div>

        <!-- Right Side: Form (Centered, full height) -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-white relative">
            <!-- Subtle background glows for right side (only mobile visual enhancement) -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500/5 rounded-full blur-3xl pointer-events-none md:hidden"></div>
            
            <div class="w-full max-w-md">
                
                <!-- On mobile, show logo at top of the form -->
                <div class="text-center md:hidden mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-950 p-3.5 border border-slate-800 shadow-md mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo RTM" class="w-full h-auto object-contain select-none pointer-events-none">
                    </div>
                    <h2 class="text-sm font-bold tracking-wider text-slate-900 uppercase leading-none">Travel RTM</h2>
                    <p class="text-[9px] text-gold-600 font-semibold tracking-widest uppercase mt-1">RTM Family</p>
                </div>

                <!-- Form Heading -->
                <div class="mb-8 text-center md:text-left">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Login</h2>
                    <p class="text-xs text-slate-500 mt-1.5">Masukkan email dan password untuk mengakses akun Anda</p>
                </div>

                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Input: Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </span>
                            <input type="email" id="email" name="email" required placeholder="nama@email.com" 
                                class="block w-full pl-10.5 pr-4 py-2.5 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all placeholder:text-slate-400 outline-none">
                        </div>
                    </div>

                    <!-- Input: Password -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Password</label>
                            <a href="#" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </span>
                            <input type="password" id="password" name="password" required placeholder="••••••••" 
                                class="block w-full pl-10.5 pr-10 py-2.5 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all placeholder:text-slate-400 outline-none">
                            <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                <!-- Eye Open Icon -->
                                <svg class="w-4.5 h-4.5 eye-open" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <!-- Eye Closed Icon -->
                                <svg class="w-4.5 h-4.5 eye-closed hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button matching primary layout action buttons -->
                    <div class="pt-2">
                        <button type="submit" 
                            class="w-full py-3 px-4 text-sm font-bold uppercase tracking-wider text-white bg-slate-900 hover:bg-slate-950 border border-gold-500/20 hover:border-gold-500/50 rounded-xl shadow-md transition-colors cursor-pointer text-center">
                            MASUK
                        </button>
                    </div>
                </form>

                <!-- Footer link to register -->
                <div class="mt-8 text-center">
                    <p class="text-xs font-semibold text-slate-500">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-brand-600 hover:text-brand-700 transition-colors font-bold ml-1">Daftar</a>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Toggle Password Visibility JS -->
    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
