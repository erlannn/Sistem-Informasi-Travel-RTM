@extends('layout.app')

@section('title', 'Profil Penumpang - RTM Family')

@section('content')
<div class="py-8 bg-slate-50 md:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">

        <!-- Header Title -->
        <div class="text-center mb-10">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Profil Penumpang</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola informasi pribadi dan pengaturan keamanan akun Anda</p>
        </div>

        <form action="#" method="POST" id="profile-form">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                
                <!-- Left Column: Informasi Akun -->
                <div class="bg-white rounded-2xl shadow-card border border-slate-100 p-6 md:p-8 transition-all">
                    <h2 class="text-base font-bold text-slate-900 pb-4 mb-6 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span>
                        Informasi Akun
                    </h2>

                    <div class="space-y-5">
                        <!-- Input: Nama Lengkap -->
                        <div>
                            <label for="nama" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                </span>
                                <input type="text" id="nama" name="nama" required value="Sri Erma Novira" class="block w-full pl-10 pr-4 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500 transition-all">
                            </div>
                        </div>

                        <!-- Input: Email -->
                        <div>
                            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                                </span>
                                <input type="email" id="email" name="email" required value="srierma@email.com" class="block w-full pl-10 pr-4 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500 transition-all">
                            </div>
                        </div>

                        <!-- Input: Nomor HP -->
                        <div>
                            <label for="telepon" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Nomor HP / WhatsApp</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.14-4.117-6.942-6.942l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                                </span>
                                <input type="tel" id="telepon" name="telepon" required value="081234567890" class="block w-full pl-10 pr-4 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500 transition-all">
                            </div>
                        </div>

                        <!-- Input: Alamat -->
                        <div>
                            <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Alamat Lengkap</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-start pl-3.5 pt-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                                </span>
                                <textarea id="alamat" name="alamat" rows="3" class="block w-full pl-10 pr-4 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500 transition-all resize-none">Sijunjung, Sumatera Barat</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Ubah Password -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-card border border-slate-100 p-6 md:p-8 transition-all">
                        <h2 class="text-base font-bold text-slate-900 pb-4 mb-6 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-gold-500"></span>
                            Ubah Password
                        </h2>

                        <div class="space-y-5">
                            <!-- Input: Password Baru -->
                            <div>
                                <label for="new_password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Password Baru</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                    </span>
                                    <input type="password" id="new_password" name="new_password" class="block w-full pl-10 pr-4 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500 transition-all">
                                </div>
                            </div>

                            <!-- Input: Konfirmasi Password -->
                            <div>
                                <label for="confirm_password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Konfirmasi Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                    </span>
                                    <input type="password" id="confirm_password" name="confirm_password" class="block w-full pl-10 pr-4 py-3 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Action Button (UX Correction: Sleek primary action layout at bottom right) -->
                    <div class="flex items-center justify-end">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-950 border border-gold-500/20 hover:border-gold-500/40 rounded-xl shadow-md hover:shadow-gold-500/5 transition-all cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection
