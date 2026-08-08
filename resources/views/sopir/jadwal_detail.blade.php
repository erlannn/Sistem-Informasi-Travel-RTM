@extends('layouts.sopir')

@section('title', 'Detail Perjalanan - CV RTM Travel')
@section('page_title', 'Detail Tugas Perjalanan')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-md">
        <h1 class="text-lg font-black text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-route text-amber-500"></i> Detail Perjalanan
        </h1>
        <p class="text-[11px] text-slate-500 mt-0.5 font-semibold">Tinjau informasi lengkap jadwal dan kelola status perjalanan Anda.</p>
    </div>

    <!-- Informasi Jadwal Perjalanan Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden">
        <div class="bg-slate-950 text-white px-5 py-4 border-b border-slate-900 flex justify-between items-center">
            <span class="text-xs font-extrabold uppercase tracking-wider">Informasi Perjalanan</span>
            <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30 text-[9px] font-bold">
                ID JADWAL #{{ $jadwal->id_jadwal }}
            </span>
        </div>

        <div class="p-5 space-y-4">
            <!-- Rute Perjalanan -->
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase">ASAL</span>
                    <span class="text-sm font-black text-slate-800">{{ $jadwal->asal }}</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-amber-500 font-bold shrink-0">
                    &rarr;
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase">TUJUAN</span>
                    <span class="text-sm font-black text-slate-800">{{ $jadwal->tujuan }}</span>
                </div>
            </div>

            <!-- Detail Spesifik -->
            <div class="space-y-3 text-xs">
                <div class="flex justify-between py-1 border-b border-slate-50 font-medium">
                    <span class="text-slate-400">Tanggal Perjalanan</span>
                    <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50 font-medium">
                    <span class="text-slate-400">Jam Keberangkatan</span>
                    <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50 font-medium">
                    <span class="text-slate-400">Armada Mobil</span>
                    <span class="font-bold text-slate-800">{{ $jadwal->armada->merk ?? '-' }} ({{ $jadwal->armada->plat_nomor ?? '-' }})</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50 font-medium">
                    <span class="text-slate-400">Warna Armada</span>
                    <span class="font-bold text-slate-800">{{ $jadwal->armada->warna ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-50 font-medium">
                    <span class="text-slate-400">Harga Tiket Penumpang</span>
                    <span class="font-bold text-amber-600">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1 font-medium">
                    <span class="text-slate-400">Jumlah Penumpang Terdaftar</span>
                    <span class="font-extrabold text-slate-900">{{ $jumlahPenumpang }} Orang</span>
                </div>
            </div>

            <!-- Note about payment -->
            <div class="p-3 bg-amber-50 border border-amber-200/80 rounded-2xl text-[10px] text-amber-800 font-semibold space-y-1">
                <div class="flex items-center gap-1.5 text-amber-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Informasi Pembayaran</span>
                </div>
                <p class="leading-relaxed font-medium">Pembayaran oleh penumpang dilakukan secara tunai langsung ke sopir setelah perjalanan selesai.</p>
            </div>

            <!-- Action buttons inside the card -->
            <div class="pt-2 flex flex-col gap-2.5">
                <a href="{{ route('sopir.jadwal.penumpang', $jadwal->id_jadwal) }}" class="w-full text-center bg-slate-900 hover:bg-slate-950 text-white font-extrabold py-3 rounded-2xl text-xs transition-colors shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-users"></i> Lihat Data Penumpang
                </a>

                @php
                    // Check if there are active bookings that can be finished
                    $hasActiveBookings = $jadwal->pemesanans->whereIn('status', ['Pending', 'Lunas'])->isNotEmpty();
                    $isAllCompleted = $jadwal->pemesanans->isNotEmpty() && $jadwal->pemesanans->whereIn('status', ['Pending', 'Lunas'])->isEmpty() && $jadwal->pemesanans->where('status', 'Selesai')->isNotEmpty();
                @endphp

                @if($hasActiveBookings)
                    <!-- Form Selesaikan Perjalanan -->
                    <form id="finish-trip-form" action="{{ route('sopir.jadwal.selesaikan', $jadwal->id_jadwal) }}" method="POST" class="inline">
                        @csrf
                        <button type="button" onclick="confirmFinishTrip()" class="w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3 rounded-2xl text-xs transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer border border-emerald-500/20">
                            <i class="fa-solid fa-circle-check"></i> Selesaikan Perjalanan
                        </button>
                    </form>
                @elseif($isAllCompleted)
                    <div class="w-full py-3 bg-emerald-50 border border-emerald-300 text-emerald-700 font-extrabold text-xs text-center rounded-2xl flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-check"></i> Perjalanan Selesai / Berhasil
                    </div>
                @else
                    <div class="w-full py-3 bg-slate-100 border border-slate-300 text-slate-500 font-bold text-xs text-center rounded-2xl flex items-center justify-center gap-2">
                        <i class="fa-solid fa-ban"></i> Tidak Ada Pemesanan Aktif
                    </div>
                @endif

                <a href="{{ route('sopir.jadwal') }}" class="w-full text-center bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 font-bold py-2.5 rounded-2xl text-xs transition-colors">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- AlpineJS or Simple JS Modal/Confirmation -->
<div id="confirmModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-5 max-w-sm w-full space-y-4 border border-slate-200 shadow-2xl">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-xl shadow-inner">
                <i class="fa-solid fa-circle-question"></i>
            </div>
            <h3 class="text-sm font-black text-slate-900">Selesaikan Perjalanan?</h3>
            <p class="text-[11px] text-slate-500 font-semibold leading-relaxed">
                Tindakan ini akan mengubah status manifest semua penumpang menjadi **Selesai**, membebaskan kursi penumpang, dan membukukan akumulasi gaji Anda untuk periode bulan ini. 
                Pastikan pembayaran tunai telah diterima dari penumpang.
            </p>
        </div>
        <div class="flex gap-2 text-xs pt-1">
            <button onclick="closeModal()" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl border border-slate-200 transition-colors">Batal</button>
            <button onclick="submitForm()" class="flex-1 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-xl transition-colors shadow-sm">Selesaikan</button>
        </div>
    </div>
</div>

<script>
    function confirmFinishTrip() {
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    function submitForm() {
        document.getElementById('finish-trip-form').submit();
    }
</script>
@endsection
