@extends('layouts.penumpang')

@section('title', 'Beranda - Pemesanan Tiket Travel RTM Family')

@section('content')
<div class="py-8 bg-slate-50 md:py-12">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Welcome Hero Section -->
        <div class="relative mb-8 text-center md:text-left pt-2">
  
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Selamat Datang di Travel RTM Family
            </h1>
            <p class="mt-2 text-xs md:text-sm text-slate-600 max-w-2xl leading-relaxed font-medium">
                Pesan tiket travel dengan mudah, cepat, dan dapatkan rekomendasi jadwal terbaik untuk perjalanan Anda.
            </p>
        </div>

        <!-- Main Workspace Grid (Search & Recommendations) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Side: Form Cari Tiket (5 Cols on Large Screens) -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 md:p-7 transition-all hover:shadow-md">
                    <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-slate-100">
                        <!-- Icon Bus (Warna Amber Brand Identity) -->
                        <div class="w-9 h-9 rounded-xl bg-amber-400 text-slate-950 shadow-xs flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 17h8M8 17a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 104 0 2 2 0 00-4 0zM4 11V6a2 2 0 012-2h12a2 2 0 012 2v5M4 11h16M4 11v6a1 1 0 001 1h1m14-7v6a1 1 0 01-1 1h-1M6 8h.01M18 8h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900">Cari Tiket Perjalanan</h2>
                            <p class="text-xs text-slate-500 font-semibold">Pilih rute & tanggal keberangkatan</p>
                        </div>
                    </div>

                    <form action="{{ route('penumpang.jadwal') }}" method="GET" id="ticket-search-form" class="space-y-4">
                        <!-- Input: Kota Asal -->
                        <div>
                            <label for="asal" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-700 mb-1.5">Kota Asal</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </span>
                                <select id="asal" name="asal" class="block w-full pl-10 pr-10 py-3 text-xs md:text-sm font-bold text-slate-800 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Kota Asal...</option>
                                    <option value="Sijunjung">Sijunjung</option>
                                    <option value="Solok">Solok</option>
                                    <option value="Padang">Padang</option>
                                    <option value="BIM">Bandara Internasional Minangkabau (BIM)</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                </span>
                            </div>
                        </div>

                        <!-- Input: Kota Tujuan -->
                        <div>
                            <label for="tujuan" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-700 mb-1.5">Kota Tujuan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                                    </svg>
                                </span>
                                <select id="tujuan" name="tujuan" class="block w-full pl-10 pr-10 py-3 text-xs md:text-sm font-bold text-slate-800 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Kota Tujuan...</option>
                                    <option value="Padang">Padang</option>
                                    <option value="Solok">Solok</option>
                                    <option value="BIM">Bandara Internasional Minangkabau (BIM)</option>
                                    <option value="Sijunjung">Sijunjung</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                </span>
                            </div>
                        </div>

                        <!-- Input: Tanggal Keberangkatan -->
                        <div>
                            <label for="tanggal" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal Perjalanan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                                <input type="date" id="tanggal" name="tanggal" min="{{ date('Y-m-d') }}" class="block w-full pl-10 pr-4 py-3 text-xs md:text-sm font-bold text-slate-800 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition-all cursor-pointer">
                            </div>
                        </div>

                        <!-- Submit Button (Dark Slate dengan Hover Amber Brand) -->
                        <button type="submit" class="w-full mt-2 py-3.5 px-4 text-xs md:text-sm font-black text-white bg-slate-900 hover:bg-amber-500 hover:text-slate-950 active:scale-[0.99] rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2 group cursor-pointer">
                            <svg class="w-4 h-4 text-amber-400 group-hover:text-slate-950 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z"></path>
                            </svg>
                            Cari Jadwal Perjalanan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side: Rekomendasi Jadwal (7 Cols on Large Screens) -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 md:p-7 transition-all">
                    
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <!-- Magic Recommendation Icon (Indigo Deep Accent) -->
                            <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white shadow-xs flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-extrabold text-slate-900">Rekomendasi Jadwal</h2>
                                <p class="text-xs text-slate-500 font-semibold">Personalisasi berbasis Content-Based Filtering (CBF)</p>
                            </div>
                        </div>
                        
                        <!-- Status indicator badge (Amber Brand Accent) -->
                        <span class="text-[11px] font-black text-amber-950 bg-amber-400 px-3 py-1 rounded-lg shadow-xs">
                            @if(!empty($hasHistory)) Terpersonalisasi @else Akun Baru @endif
                        </span>
                    </div>

                    <!-- Recommended Schedule Cards list -->
                    <div class="space-y-3.5">
                        @if(!empty($hasHistory) && count($jadwals ?? []) > 0)
                            @foreach($jadwals as $j)
                                <div class="group relative bg-slate-50/80 hover:bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 transition-all duration-200 hover:shadow-md hover:border-amber-400 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    
                                    <div class="flex items-start gap-3">
                                        <!-- Star Badge Icon (Tanpa Background) -->
                                        <div class="mt-1 flex items-center justify-center text-amber-500 shrink-0">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        </div>
                                        <div class="space-y-1">
                                            <!-- Route Details -->
                                            <div class="flex items-center gap-2">
                                                <span class="font-black text-slate-900 text-sm md:text-base tracking-tight">{{ $j->asal }}</span>
                                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path></svg>
                                                <span class="font-black text-slate-900 text-sm md:text-base tracking-tight">{{ $j->tujuan }}</span>
                                            </div>
                                            <!-- Meta Badges -->
                                            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-600 font-semibold">
                                                <!-- Time Badge -->
                                                <span class="flex items-center gap-1.5 font-extrabold text-indigo-900 bg-indigo-50 border border-indigo-100 px-2.5 py-0.5 rounded-md text-[11px]">
                                                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    {{ \Carbon\Carbon::parse($j->jam)->format('H.i') }} WIB ({{ $j->tanggal }})
                                                </span>
                                                <span class="text-slate-300">•</span>
                                                <span class="text-slate-800 font-bold text-[11px]">
                                                    {{ $j->armada->merk ?? 'Super Executive' }}
                                                </span>
                                                @if(isset($j->match_percentage))
                                                    <span class="text-slate-300">•</span>
                                                    <!-- Match Percentage (Tanpa Emote) -->
                                                    <span class="text-amber-900 bg-amber-100 border border-amber-200/80 font-extrabold px-2 py-0.5 rounded-md text-[10px]">
                                                        {{ $j->match_percentage }}% Cocok
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CTA & Price -->
                                    <div class="flex items-center md:flex-col md:items-end justify-between md:justify-center border-t md:border-t-0 border-slate-200/70 pt-3 md:pt-0 gap-2 shrink-0">
                                        <div class="text-left md:text-right">
                                            <span class="text-[10px] uppercase font-black text-slate-400 block tracking-wider">Mulai dari</span>
                                            <span class="text-base md:text-lg font-black text-amber-600">Rp {{ number_format($j->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <!-- Tombol Pilih Jadwal (Matching Dark Slate dengan Hover Amber) -->
                                        <a href="{{ route('penumpang.pilih_kursi', $j->id_jadwal) }}" class="px-4 py-2 text-xs font-black text-white bg-slate-900 hover:bg-amber-500 hover:text-slate-950 active:scale-[0.98] rounded-xl shadow-xs transition-all flex items-center gap-1.5 group/btn cursor-pointer">
                                            <span>Pilih Jadwal</span>
                                            <svg class="w-3.5 h-3.5 text-amber-400 group-hover/btn:text-slate-950 transition-transform group-hover/btn:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="p-8 text-center text-slate-600 text-xs sm:text-sm bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                                <svg class="w-8 h-8 text-amber-500 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                </svg>
                                <p class="font-extrabold text-slate-900 mb-1">Belum Ada Rekomendasi Jadwal</p>
                                <p class="text-slate-500 font-medium max-w-sm mx-auto">Lakukan pemesanan pertama Anda untuk mengaktifkan rekomendasi jadwal perjalanan otomatis berbasis Content-Based Filtering (CBF).</p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>

        <!-- Extra Value Propositions Section -->
        <div class="mt-14 border-t border-slate-200 pt-10">
            <h3 class="text-base sm:text-lg font-black text-slate-900 text-center mb-8 tracking-tight">Keunggulan Utama Layanan RTM Family</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Point 1: Armada Bersih (Sky Blue Badge) -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-start gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-sky-500 text-white shadow-xs flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-sm mb-1">Armada Bersih & Nyaman</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Kendaraan model terbaru dengan AC dingin, kursi ergonomis, dan kebersihan terjaga di setiap rute.</p>
                    </div>
                </div>

                <!-- Point 2: Jadwal Tepat Waktu (Indigo Badge) -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-start gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white shadow-xs flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-sm mb-1">Jadwal Tepat Waktu</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Keberangkatan yang teratur dan konsisten untuk memastikan Anda tiba di kota tujuan sesuai jadwal.</p>
                    </div>
                </div>

                <!-- Point 3: Sopir Berpengalaman (Amber Badge) -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-start gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-400 text-slate-950 shadow-xs flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-sm mb-1">Sopir Berpengalaman</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Pengemudi profesional, ramah, dan berpengalaman demi keamanan serta kenyamanan Anda selama perjalanan.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Client-side Validation and Notification Toast Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('ticket-search-form');
        const asal = document.getElementById('asal');
        const tujuan = document.getElementById('tujuan');
        const tanggal = document.getElementById('tanggal');

        // Function to create and show premium toast using top transition offset
        function showToast(message) {
            let toast = document.getElementById('search-validation-toast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'search-validation-toast';
                toast.className = 'fixed top-[-80px] left-1/2 -translate-x-1/2 z-50 flex items-center gap-2.5 px-5 py-3.5 bg-slate-900 border border-amber-400 text-white text-xs font-bold rounded-2xl shadow-xl transition-all duration-500 opacity-0';
                toast.innerHTML = `
                    <span class="text-amber-400 text-sm">⚠️</span>
                    <span id="toast-text"></span>
                `;
                document.body.appendChild(toast);
            }
            document.getElementById('toast-text').textContent = message;

            // Slide down from -80px to 20px (top-5) and Fade in
            setTimeout(() => {
                toast.classList.remove('top-[-80px]', 'opacity-0');
                toast.classList.add('top-5', 'opacity-100');
            }, 50);

            // Slide back up and Fade out after 3.5s
            setTimeout(() => {
                toast.classList.remove('top-5', 'opacity-100');
                toast.classList.add('top-[-80px]', 'opacity-0');
            }, 3500);
        }

        // Helper function to clear error borders on input/change
        [asal, tujuan, tanggal].forEach(input => {
            if (input) {
                input.addEventListener('change', function () {
                    this.classList.remove('border-red-500', 'ring-2', 'ring-red-500/20');
                    this.classList.add('border-slate-200');
                });
                input.addEventListener('input', function () {
                    this.classList.remove('border-red-500', 'ring-2', 'ring-red-500/20');
                    this.classList.add('border-slate-200');
                });
            }
        });

        if (form) {
            form.addEventListener('submit', function (e) {
                let errors = [];
                
                if (!asal.value) {
                    asal.classList.remove('border-slate-200');
                    asal.classList.add('border-red-500', 'ring-2', 'ring-red-500/20');
                    errors.push('Kota Asal');
                }
                if (!tujuan.value) {
                    tujuan.classList.remove('border-slate-200');
                    tujuan.classList.add('border-red-500', 'ring-2', 'ring-red-500/20');
                    errors.push('Kota Tujuan');
                }
                if (!tanggal.value) {
                    tanggal.classList.remove('border-slate-200');
                    tanggal.classList.add('border-red-500', 'ring-2', 'ring-red-500/20');
                    errors.push('Tanggal Perjalanan');
                }

                if (errors.length > 0) {
                    e.preventDefault(); // Stop form submission
                    let message = 'Lengkapi ' + errors.join(', ') + ' Anda untuk mencari jadwal!';
                    showToast(message);
                }
            });
        }
    });
</script>
@endsection