@extends('layouts.penumpang')

@section('title', 'Pilih Kursi - RTM Family')

@section('content')
<div class="py-8 bg-slate-50 md:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">

        <!-- Header Workflow Stepper -->
        <div class="max-w-xl mx-auto mb-10">
            <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                <div class="flex flex-col items-center gap-1.5 text-slate-900">
                    <span class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold">1</span>
                    <span>Pilih Jadwal</span>
                </div>
                <div class="h-0.5 flex-1 bg-gold-400 mx-2 -mt-4"></div>
                <div class="flex flex-col items-center gap-1.5 text-slate-900">
                    <span class="w-7 h-7 rounded-full bg-gold-400 text-slate-950 flex items-center justify-center font-bold ring-4 ring-gold-100">2</span>
                    <span class="font-bold">Pilih Kursi</span>
                </div>
                <div class="h-0.5 flex-1 bg-slate-200 mx-2 -mt-4"></div>
                <div class="flex flex-col items-center gap-1.5">
                    <span class="w-7 h-7 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center font-bold">3</span>
                    <span>Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Main Title -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pilih Kursi Anda</h1>
            <p class="mt-1 text-sm text-slate-500">Pilih satu atau beberapa nomor kursi yang ingin Anda pesan (Unlimited)</p>
        </div>

        <!-- Form wrapping the seat data -->
        <form action="{{ route('penumpang.konfirmasi') }}" method="GET" id="seat-selection-form">
            <!-- Hidden inputs -->
            <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal ?? '' }}">
            <input type="hidden" name="id_kursi" id="selected-seat-id" value="">
            <input type="hidden" name="kursi" id="selected-seat-input" value="">
            <div id="selected-seats-container"></div>

            <!-- Core Grid Split -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Informasi Perjalanan -->
                <div class="md:col-span-5">
                    <div class="bg-white rounded-2xl shadow-card border border-slate-100 p-6 transition-all">
                        <h2 class="text-base font-bold text-slate-900 pb-4 mb-4 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-gold-500"></span>
                            Informasi Perjalanan
                        </h2>
                        
                        <!-- Travel Detail Table -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Kota Asal</span>
                                <span class="font-bold text-slate-800">{{ $jadwal->asal ?? 'Sijunjung' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Kota Tujuan</span>
                                <span class="font-bold text-slate-800">{{ $jadwal->tujuan ?? 'Padang' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Tanggal Perjalanan</span>
                                <span class="font-bold text-slate-800">{{ $jadwal->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y') : date('d-m-Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Jam Keberangkatan</span>
                                <span class="font-bold text-slate-800">{{ $jadwal->jam ? \Carbon\Carbon::parse($jadwal->jam)->format('H.i') . ' WIB' : '05.00 WIB' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Armada</span>
                                <span class="font-bold text-slate-800">{{ $jadwal->armada->merk ?? 'Toyota Avanza' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-medium">Harga Tiket / Kursi</span>
                                <span class="font-bold text-gold-600">Rp {{ number_format($jadwal->harga ?? 70000, 0, ',', '.') }}</span>
                            </div>
                            
                            <!-- Dynamically Display Selected Seat -->
                            <div class="pt-4 border-t border-slate-100 mt-4 flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-bold">Kursi Dipilih</span>
                                <span id="selected-seat-badge" class="font-extrabold text-gold-600 bg-gold-50 border border-gold-200/50 px-3 py-1 rounded-lg">
                                    Belum Dipilih
                                </span>
                            </div>

                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 font-bold">Estimasi Total Harga</span>
                                <span id="total-harga-display" class="font-black text-slate-900 text-base">
                                    Rp 0
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Denah Kursi -->
                <div class="md:col-span-7">
                    <div class="bg-white rounded-2xl shadow-card border border-slate-100 p-6 transition-all">
                        <h2 class="text-base font-bold text-slate-900 pb-4 mb-6 border-b border-slate-100 flex items-center justify-between gap-2">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span>
                                Denah Kursi (Layout {{ $jadwal->armada->merk ?? 'Armada' }})
                            </span>
                            <span class="text-xs px-2.5 py-1 bg-gold-50 border border-gold-200 text-gold-700 font-extrabold rounded-lg">
                                {{ $jadwal->armada->kursi ?? count($kursis ?? []) }} Kursi Total
                            </span>
                        </h2>

                        <!-- Interactive Van layout wrapping grid -->
                        <div class="relative max-w-[340px] mx-auto bg-slate-50 border-2 border-slate-200 rounded-3xl p-5 md:p-6 shadow-inner space-y-4">
                            
                            <!-- Front Cabin Indicator -->
                            <div class="border-b-2 border-dashed border-slate-200 pb-3 flex justify-between items-center text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0-9m0 0l-3-3m3 3l3-3m-3 3v6" /></svg>
                                    Kemudi Sopir
                                </div>
                                <span class="bg-slate-200/60 px-2 py-0.5 rounded">Depan</span>
                            </div>

                            @php
                                $allKursi = $kursis ?? collect();
                                $kFront = $allKursi->first();
                                $kMiddle = $allKursi->slice(1, 3);
                                $kBack = $allKursi->slice(4);
                            @endphp

                            <!-- Baris Depan: Sopir & 1 Kursi Disamping Sopir -->
                            <div class="grid grid-cols-2 gap-3 items-center pb-3 border-b border-slate-200/80">
                                <div class="py-3 text-xs font-bold text-slate-500 bg-slate-200/70 border border-slate-300 rounded-xl flex items-center justify-center select-none shadow-xs">
                                    Sopir
                                </div>
                                @if($kFront)
                                    @if($kFront->status === 'Terisi')
                                        <div class="py-3 text-sm font-bold text-white bg-slate-900 border-2 border-slate-800 rounded-xl shadow-xs flex items-center justify-center select-none cursor-not-allowed opacity-80" title="Kursi {{ $kFront->nomor_kursi }} sudah terisi">
                                            {{ $kFront->nomor_kursi }}
                                        </div>
                                    @else
                                        <button type="button" data-seat-id="{{ $kFront->id_kursi }}" data-seat="{{ $kFront->nomor_kursi }}" class="seat-btn py-3 text-sm font-bold text-slate-600 bg-white border-2 border-slate-200 rounded-xl shadow-xs transition-all hover:border-slate-300 focus:outline-none cursor-pointer flex items-center justify-center">
                                            {{ $kFront->nomor_kursi }}
                                        </button>
                                    @endif
                                @endif
                            </div>

                            <!-- Baris Tengah: 3 Kursi -->
                            @if($kMiddle->isNotEmpty())
                                <div class="space-y-1.5 pb-3 border-b border-slate-200/80">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider block text-center">Baris Tengah (3 Kursi)</span>
                                    <div class="grid grid-cols-3 gap-2.5 items-center justify-center">
                                        @foreach($kMiddle as $k)
                                            @if($k->status === 'Terisi')
                                                <div class="py-3 text-sm font-bold text-white bg-slate-900 border-2 border-slate-800 rounded-xl shadow-xs flex items-center justify-center select-none cursor-not-allowed opacity-80" title="Kursi {{ $k->nomor_kursi }} sudah terisi">
                                                    {{ $k->nomor_kursi }}
                                                </div>
                                            @else
                                                <button type="button" data-seat-id="{{ $k->id_kursi }}" data-seat="{{ $k->nomor_kursi }}" class="seat-btn py-3 text-sm font-bold text-slate-600 bg-white border-2 border-slate-200 rounded-xl shadow-xs transition-all hover:border-slate-300 focus:outline-none cursor-pointer flex items-center justify-center">
                                                    {{ $k->nomor_kursi }}
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Baris Belakang: 3 Kursi (jika 7 kursi total) atau 2 Kursi (jika 6 kursi total) -->
                            @if($kBack->isNotEmpty())
                                <div class="space-y-1.5">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider block text-center">Baris Belakang ({{ $kBack->count() }} Kursi)</span>
                                    <div class="grid {{ $kBack->count() >= 3 ? 'grid-cols-3' : 'grid-cols-2' }} gap-2.5 items-center justify-center">
                                        @foreach($kBack as $k)
                                            @if($k->status === 'Terisi')
                                                <div class="py-3 text-sm font-bold text-white bg-slate-900 border-2 border-slate-800 rounded-xl shadow-xs flex items-center justify-center select-none cursor-not-allowed opacity-80" title="Kursi {{ $k->nomor_kursi }} sudah terisi">
                                                    {{ $k->nomor_kursi }}
                                                </div>
                                            @else
                                                <button type="button" data-seat-id="{{ $k->id_kursi }}" data-seat="{{ $k->nomor_kursi }}" class="seat-btn py-3 text-sm font-bold text-slate-600 bg-white border-2 border-slate-200 rounded-xl shadow-xs transition-all hover:border-slate-300 focus:outline-none cursor-pointer flex items-center justify-center">
                                                    {{ $k->nomor_kursi }}
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Back Cabin Indicator -->
                            <div class="pt-2 text-center text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                Bagasi / Belakang
                            </div>
                        </div>

                        <!-- Seat Status Legends list -->
                        <div class="mt-8 flex justify-center gap-6 text-xs font-semibold text-slate-600 border-t border-slate-100 pt-6">
                            <div class="flex items-center gap-1.5">
                                <span class="w-3.5 h-3.5 bg-gold-400 border border-gold-500/20 rounded-md shadow-xs"></span>
                                <span>Dipilih</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3.5 h-3.5 bg-slate-900 rounded-md shadow-xs"></span>
                                <span>Terisi</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3.5 h-3.5 bg-white border-2 border-slate-200 rounded-md shadow-xs"></span>
                                <span>Tersedia</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Form Submit Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('penumpang.jadwal') }}" class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors text-center cursor-pointer">
                    Kembali ke Jadwal
                </a>
                <button type="submit" id="submit-btn" disabled class="w-full sm:w-auto px-8 py-3 text-sm font-semibold text-slate-400 bg-slate-200 rounded-xl transition-all cursor-not-allowed shadow-sm">
                    Lanjutkan Ke Pemesanan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seatButtons = document.querySelectorAll('.seat-btn');
        const selectedSeatInput = document.getElementById('selected-seat-input');
        const selectedSeatId = document.getElementById('selected-seat-id');
        const selectedSeatsContainer = document.getElementById('selected-seats-container');
        const selectedSeatBadge = document.getElementById('selected-seat-badge');
        const submitBtn = document.getElementById('submit-btn');
        const hargaPerTiket = {{ $jadwal->harga ?? 70000 }};
        const totalHargaDisplay = document.getElementById('total-harga-display');

        let selectedSeats = [];

        seatButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const seatNum = this.getAttribute('data-seat');
                const seatId = this.getAttribute('data-seat-id') || '';

                const index = selectedSeats.findIndex(s => s.id === seatId);

                if (index > -1) {
                    selectedSeats.splice(index, 1);
                    this.classList.remove('bg-gold-400', 'text-slate-950', 'border-gold-500');
                    this.classList.add('bg-white', 'text-slate-600', 'border-slate-200');
                } else {
                    selectedSeats.push({ id: seatId, num: seatNum });
                    this.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');
                    this.classList.add('bg-gold-400', 'text-slate-950', 'border-gold-500');
                }

                updateSelectionUI();
            });
        });

        function updateSelectionUI() {
            selectedSeatsContainer.innerHTML = '';

            if (selectedSeats.length === 0) {
                selectedSeatInput.value = '';
                selectedSeatId.value = '';
                selectedSeatBadge.textContent = 'Belum Dipilih';
                selectedSeatBadge.className = 'font-extrabold text-gold-600 bg-gold-50 border border-gold-200/50 px-3 py-1 rounded-lg';
                
                if (totalHargaDisplay) totalHargaDisplay.textContent = 'Rp 0';

                submitBtn.disabled = true;
                submitBtn.className = 'w-full sm:w-auto px-8 py-3 text-sm font-semibold text-slate-400 bg-slate-200 rounded-xl transition-all cursor-not-allowed shadow-sm';
            } else {
                const seatNums = selectedSeats.map(s => s.num);
                const seatIds = selectedSeats.map(s => s.id);

                selectedSeatInput.value = seatNums.join(',');
                selectedSeatId.value = seatIds.join(',');

                selectedSeats.forEach(s => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'id_kursi[]';
                    hiddenInput.value = s.id;
                    selectedSeatsContainer.appendChild(hiddenInput);
                });

                selectedSeatBadge.textContent = 'Kursi ' + seatNums.join(', ') + ' (' + selectedSeats.length + ' Kursi)';
                selectedSeatBadge.className = 'font-extrabold text-white bg-gold-500 border border-gold-600 px-3 py-1 rounded-lg shadow-sm';

                const totalHarga = hargaPerTiket * selectedSeats.length;
                if (totalHargaDisplay) totalHargaDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalHarga);

                submitBtn.disabled = false;
                submitBtn.className = 'w-full sm:w-auto px-8 py-3 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-950 border border-gold-500/20 hover:border-gold-500/40 rounded-xl shadow-md transition-colors cursor-pointer';
            }
        }
    });
</script>
@endsection
