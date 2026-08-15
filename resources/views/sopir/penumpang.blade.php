@extends('layouts.sopir')

@section('title', 'Penumpang - CV RTM Travel')
@section('page_title', 'Penumpang Rute')

@section('content')
<div class="space-y-5">
    <!-- Header Card -->
    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div class="flex justify-between items-center gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center text-base shadow-xs shrink-0 font-black">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-extrabold tracking-wider uppercase block">JADWAL #{{ $jadwal->id_jadwal }} &bull; {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }} ({{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB)</span>
                    <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 leading-snug">Penumpang</h1>
                    <p class="text-xs font-bold text-slate-600 mt-0.5 flex items-center gap-1.5">
                        <span>{{ $jadwal->asal }}</span>
                        <i class="fa-solid fa-arrow-right text-[10px] text-amber-500"></i>
                        <span>{{ $jadwal->tujuan }}</span>
                    </p>
                </div>
            </div>
            <a href="{{ route('sopir.jadwal.detail', $jadwal->id_jadwal) }}" class="text-slate-700 bg-slate-100 hover:bg-slate-200 p-2.5 rounded-2xl border border-slate-300 transition-all shadow-xs flex items-center justify-center cursor-pointer shrink-0" title="Kembali ke Detail Jadwal">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <form action="{{ route('sopir.jadwal.penumpang', $jadwal->id_jadwal) }}" method="GET" class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs space-y-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <!-- Search Text -->
            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-600 block">Cari Penumpang</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Nama / No HP..." 
                        class="w-full bg-slate-50 border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/30 text-xs sm:text-sm rounded-xl py-2.5 pl-3.5 pr-9 outline-none text-slate-800 font-semibold transition-all">
                    <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </div>
            </div>

            <!-- Filter Status Perjalanan -->
            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-600 block">Status Perjalanan</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/30 text-xs sm:text-sm rounded-xl py-2.5 px-3 outline-none text-slate-800 font-semibold transition-all cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="Pending" {{ $status === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Naik" {{ $status === 'Naik' ? 'selected' : '' }}>Naik Armada</option>
                    <option value="Selesai" {{ $status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Batal" {{ $status === 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2 pt-1">
            <button type="submit" class="px-4 py-2 bg-amber-400 hover:bg-amber-500 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-filter text-xs"></i>
                <span>Terapkan Filter</span>
            </button>
            @if($search || $status)
                <a href="{{ route('sopir.jadwal.penumpang', $jadwal->id_jadwal) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-rotate-left text-xs"></i>
                    <span>Reset</span>
                </a>
            @endif
        </div>
    </form>

    <!-- Passenger List (Card-based Layout per Group) -->
    <div class="space-y-4">
        @forelse($groupedPemesanans as $groupKey => $group)
            @php
                $firstP = $group->first();
                $seatCount = $group->count();
                $seatNumbers = $group->map(function($i) { return $i->kursi->nomor_kursi ?? '-'; })->unique()->implode(', ');
                $totalTagihan = $group->sum(function($i) use ($jadwal) {
                    return $i->total_bayar > 0 ? $i->total_bayar : ($jadwal->harga * $i->jumlah_penumpang);
                });

                $statuses = $group->pluck('status_perjalanan');
                if ($statuses->contains('Naik')) {
                    $groupStatusPerjalanan = 'Naik';
                } elseif ($statuses->every(fn($s) => $s === 'Selesai')) {
                    $groupStatusPerjalanan = 'Selesai';
                } elseif ($statuses->every(fn($s) => $s === 'Batal')) {
                    $groupStatusPerjalanan = 'Batal';
                } else {
                    $groupStatusPerjalanan = 'Pending';
                }

                $payments = $group->pluck('status_pembayaran');
                $isLunas = $payments->every(fn($p) => $p === 'Lunas');
            @endphp
            <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs relative overflow-hidden group">
                <!-- Status Tag Badge (Pojok Kanan Atas) -->
                <div class="absolute top-0 right-0">
                    @if($groupStatusPerjalanan === 'Selesai')
                        <span class="px-3.5 py-1 bg-emerald-500 text-white text-[10px] font-extrabold rounded-bl-2xl uppercase tracking-wider block">Selesai</span>
                    @elseif($groupStatusPerjalanan === 'Naik')
                        <span class="px-3.5 py-1 bg-indigo-600 text-white text-[10px] font-extrabold rounded-bl-2xl uppercase tracking-wider block">Naik Armada</span>
                    @elseif($groupStatusPerjalanan === 'Batal')
                        <span class="px-3.5 py-1 bg-red-600 text-white text-[10px] font-extrabold rounded-bl-2xl uppercase tracking-wider block">Batal</span>
                    @else
                        <span class="px-3.5 py-1 bg-amber-400 text-slate-950 text-[10px] font-extrabold rounded-bl-2xl uppercase tracking-wider block">Pending</span>
                    @endif
                </div>

                <div class="flex gap-3.5 items-start">
                    <!-- Seat Number Badge -->
                    <div class="min-w-14 min-h-14 p-2 rounded-2xl bg-amber-100 border border-amber-300 flex flex-col items-center justify-center shrink-0 shadow-xs text-center">
                        <span class="text-[8px] text-amber-900 font-extrabold uppercase tracking-wider leading-none">KURSI</span>
                        <span class="text-base font-black text-amber-950 leading-none mt-1">{{ $seatNumbers }}</span>
                        @if($seatCount > 1)
                            <span class="text-[9px] font-bold text-amber-800 mt-0.5">({{ $seatCount }} Kursi)</span>
                        @endif
                    </div>

                    <!-- Passenger Details -->
                    <div class="space-y-1.5 pr-16 flex-grow">
                        <span class="text-[10px] text-slate-400 font-extrabold tracking-wider uppercase block leading-none">Nama Penumpang</span>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 leading-snug">
                            {{ $firstP->penumpang->nama ?? '-' }}
                            @if($seatCount > 1)
                                <span class="ml-1.5 inline-block px-2 py-0.5 bg-amber-100 text-amber-900 border border-amber-300 rounded-md text-[10px] font-black uppercase">
                                    {{ $seatCount }} Kursi Tiket
                                </span>
                            @endif
                        </h3>
                        <div class="text-xs text-slate-600 font-bold flex items-center gap-1.5 mt-0.5">
                            <span>Jumlah: {{ $seatCount }} Orang</span>
                        </div>
                    </div>
                </div>

                <!-- Contact & Payment Details -->
                <div class="mt-4 pt-3.5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2.5 text-xs sm:text-sm">
                    <!-- Contact WhatsApp -->
                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400 font-bold">WhatsApp:</span>
                        @if($firstP->penumpang && $firstP->penumpang->no_hp)
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $firstP->penumpang->no_hp) }}" target="_blank" class="font-extrabold text-slate-800 hover:text-emerald-600 transition-colors flex items-center gap-1">
                                <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i>
                                <span>{{ $firstP->penumpang->no_hp }}</span>
                            </a>
                        @else
                            <span class="font-bold text-slate-800">-</span>
                        @endif
                    </div>

                    <!-- Direct Payment State -->
                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400 font-bold">Bayar Cash:</span>
                        @if($isLunas)
                            <span class="font-extrabold text-emerald-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Rp {{ number_format($totalTagihan, 0, ',', '.') }} (Lunas)</span>
                            </span>
                        @elseif($groupStatusPerjalanan === 'Batal')
                            <span class="font-bold text-slate-400 line-through">Batal</span>
                        @else
                            <span class="font-extrabold text-amber-900 bg-amber-100 border border-amber-300 px-2.5 py-0.5 rounded-lg text-xs flex items-center gap-1">
                                <i class="fa-solid fa-money-bill-wave text-amber-600"></i>
                                <span>Tagih Rp {{ number_format($totalTagihan, 0, ',', '.') }} {{ $seatCount > 1 ? "($seatCount Kursi)" : '' }}</span>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Driver Action Buttons per Group (Simultaneous Confirmation) -->
                @if($groupStatusPerjalanan !== 'Batal' && $groupStatusPerjalanan !== 'Selesai')
                    <div class="mt-3.5 pt-3.5 border-t border-slate-100 flex flex-wrap items-center gap-2">
                        @if($groupStatusPerjalanan === 'Pending')
                            <form action="{{ route('sopir.pemesanan.naik', $firstP->id_pemesanan) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3.5 py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-[0.99] rounded-xl transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                                    <i class="fa-solid fa-user-check text-xs"></i>
                                    <span>Naikkan Penumpang {{ $seatCount > 1 ? "($seatCount Kursi sekaligus)" : '' }}</span>
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('sopir.pemesanan.terima_cash', $firstP->id_pemesanan) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3.5 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-[0.99] rounded-xl transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                                <i class="fa-solid fa-hand-holding-dollar text-xs"></i>
                                <span>Selesai & Terima Cash {{ $seatCount > 1 ? "($seatCount Kursi sekaligus)" : '' }}</span>
                            </button>
                        </form>

                        <form action="{{ route('sopir.pemesanan.batal', $firstP->id_pemesanan) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan penumpang ini ({{ $seatCount }} kursi)?')">
                            @csrf
                            <button type="submit" class="px-3.5 py-2 text-xs font-bold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition-all flex items-center gap-1.5 cursor-pointer">
                                <i class="fa-solid fa-user-xmark text-xs"></i>
                                <span>Batal / No-Show {{ $seatCount > 1 ? "($seatCount Kursi)" : '' }}</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12 bg-white border border-slate-200/80 rounded-3xl shadow-xs space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-lg mx-auto">
                    <i class="fa-solid fa-users-slash"></i>
                </div>
                <p class="text-xs sm:text-sm text-slate-700 font-bold">Tidak ada penumpang terdaftar pada rute ini yang sesuai filter.</p>
                <p class="text-[11px] text-slate-400 font-medium">Data pemesanan penumpang baru akan muncul secara otomatis di sini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    @if($pemesanans->hasPages())
        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-center">
            {{ $pemesanans->links() }}
        </div>
    @endif

    <!-- Back Button -->
    <div class="pt-2">
        <a href="{{ route('sopir.jadwal.detail', $jadwal->id_jadwal) }}" class="w-full inline-block text-center bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 font-bold py-3 rounded-2xl text-xs sm:text-sm transition-all">
            Kembali ke Detail Jadwal
        </a>
    </div>
</div>
@endsection