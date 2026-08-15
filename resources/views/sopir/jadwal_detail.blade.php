@extends('layouts.sopir')

@section('title', 'Detail Perjalanan - CV RTM Travel')
@section('page_title', 'Detail Tugas Perjalanan')

@section('content')
<div class="space-y-5">
    <!-- Header Card -->
    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center text-base shadow-xs shrink-0 font-black">
                <i class="fa-solid fa-route"></i>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                    Detail Perjalanan
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Tinjau informasi lengkap jadwal dan kelola status perjalanan Anda</p>
            </div>
        </div>
    </div>

    <!-- Informasi Jadwal Perjalanan Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <!-- Card Header Strip -->
        <div class="bg-slate-950 text-white px-5 sm:px-6 py-4 flex justify-between items-center border-b border-slate-800">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-300">Informasi Perjalanan</span>
            <span class="px-3 py-1 rounded-md bg-amber-400/20 text-amber-400 border border-amber-400/30 text-[10px] font-extrabold uppercase tracking-wider">
                ID JADWAL #{{ $jadwal->id_jadwal }}
            </span>
        </div>

        <div class="p-5 sm:p-6 space-y-5">
            <!-- Display Rute Perjalanan Utama -->
            <div class="bg-slate-50/90 border border-slate-200/80 p-4 rounded-2xl flex items-center justify-between gap-3">
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Kota Asal</span>
                    <span class="text-sm sm:text-base font-extrabold text-slate-900 mt-0.5">{{ $jadwal->asal }}</span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center font-black shrink-0 shadow-xs">
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Kota Tujuan</span>
                    <span class="text-sm sm:text-base font-extrabold text-slate-900 mt-0.5">{{ $jadwal->tujuan }}</span>
                </div>
            </div>

            <!-- Detail Spesifik Tabel Info -->
            <div class="space-y-3 text-xs sm:text-sm text-slate-800">
                <div class="flex justify-between items-center py-1.5 border-b border-slate-100 font-medium">
                    <span class="text-slate-500 font-semibold">Tanggal Perjalanan</span>
                    <span class="font-extrabold text-slate-900 text-right">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-slate-100 font-medium">
                    <span class="text-slate-500 font-semibold">Jam Keberangkatan</span>
                    <span class="font-extrabold text-slate-900 text-right">{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-slate-100 font-medium">
                    <span class="text-slate-500 font-semibold">Armada Mobil</span>
                    <span class="font-extrabold text-slate-900 text-right">
                        {{ $jadwal->armada->merk ?? '-' }}
                        @if(isset($jadwal->armada->plat_nomor))
                            <span class="text-slate-500 font-semibold">({{ $jadwal->armada->plat_nomor }})</span>
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-slate-100 font-medium">
                    <span class="text-slate-500 font-semibold">Warna Armada</span>
                    <span class="font-extrabold text-slate-900 text-right">{{ $jadwal->armada->warna ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-slate-100 font-medium">
                    <span class="text-slate-500 font-semibold">Harga Tiket Penumpang</span>
                    <span class="font-extrabold text-amber-600 text-right">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center py-1.5 font-medium">
                    <span class="text-slate-500 font-semibold">Jumlah Penumpang Terdaftar</span>
                    <span class="font-extrabold text-slate-900 text-right">{{ $jumlahPenumpang }} Orang</span>
                </div>
            </div>

            <!-- Note Information -->
            <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900 font-medium space-y-1">
                <div class="flex items-center gap-1.5 font-extrabold text-amber-900">
                    <i class="fa-solid fa-circle-info text-amber-600"></i>
                    <span>Informasi Pembayaran</span>
                </div>
                <p class="leading-relaxed text-[11px] sm:text-xs">Pembayaran oleh penumpang dilakukan secara tunai langsung kepada sopir setelah perjalanan selesai.</p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-2 flex flex-col gap-2.5">
                <a href="{{ route('sopir.jadwal.penumpang', $jadwal->id_jadwal) }}" class="w-full text-center bg-slate-900 hover:bg-slate-950 active:scale-[0.99] text-white font-bold py-3 rounded-2xl text-xs sm:text-sm transition-all shadow-xs flex items-center justify-center gap-2">
                    <i class="fa-solid fa-users text-xs"></i>
                    <span>Lihat Data Penumpang</span>
                </a>

                @php
                    // Check if there are active bookings that can be finished
                    $hasActiveBookings = $jadwal->pemesanans->whereIn('status_perjalanan', ['Pending', 'Naik'])->isNotEmpty();
                    $isAllCompleted = $jadwal->pemesanans->isNotEmpty() && $jadwal->pemesanans->whereIn('status_perjalanan', ['Pending', 'Naik'])->isEmpty() && $jadwal->pemesanans->where('status_perjalanan', 'Selesai')->isNotEmpty();
                @endphp

                @if($hasActiveBookings)
                    <!-- Form Selesaikan Perjalanan -->
                    <form id="finish-trip-form" action="{{ route('sopir.jadwal.selesaikan', $jadwal->id_jadwal) }}" method="POST" class="w-full">
                        @csrf
                        <button type="button" onclick="confirmFinishTrip()" class="w-full text-center bg-emerald-600 hover:bg-emerald-700 active:scale-[0.99] text-white font-extrabold py-3 rounded-2xl text-xs sm:text-sm transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-circle-check text-xs"></i>
                            <span>Selesaikan Perjalanan</span>
                        </button>
                    </form>
                @elseif($isAllCompleted)
                    <div class="w-full py-3 bg-emerald-50 border border-emerald-300 text-emerald-800 font-extrabold text-xs sm:text-sm text-center rounded-2xl flex items-center justify-center gap-2 shadow-xs">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span>Perjalanan Selesai / Berhasil</span>
                    </div>
                @else
                    <div class="w-full py-3 bg-slate-100 border border-slate-300 text-slate-500 font-bold text-xs sm:text-sm text-center rounded-2xl flex items-center justify-center gap-2">
                        <i class="fa-solid fa-ban text-slate-400"></i>
                        <span>Tidak Ada Pemesanan Aktif</span>
                    </div>
                @endif

                <a href="{{ route('sopir.jadwal') }}" class="w-full text-center bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 font-bold py-2.5 rounded-2xl text-xs sm:text-sm transition-all">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirmation -->
<div id="confirmModal" class="fixed inset-0 bg-slate-950/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 max-w-sm w-full space-y-4 border border-slate-200 shadow-2xl">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto text-xl font-bold shadow-xs">
                <i class="fa-solid fa-circle-question"></i>
            </div>
            <h3 class="text-base font-extrabold text-slate-900">Selesaikan Perjalanan?</h3>
            <p class="text-xs text-slate-500 font-medium leading-relaxed">
                Tindakan ini akan mengubah status semua penumpang menjadi <strong class="text-slate-800">Selesai</strong>, membebaskan kursi, dan membukukan akumulasi gaji Anda. 
                Pastikan pembayaran tunai telah diterima dari seluruh penumpang.
            </p>
        </div>
        <div class="flex gap-2.5 pt-2">
            <button onclick="closeModal()" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl border border-slate-300 transition-all cursor-pointer">
                Batal
            </button>
            <button onclick="submitForm()" class="flex-1 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl transition-all shadow-xs cursor-pointer">
                Selesaikan
            </button>
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