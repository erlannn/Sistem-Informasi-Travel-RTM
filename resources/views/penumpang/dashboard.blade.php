@extends('layouts.penumpang')

@section('title', 'Dashboard Penumpang - CV RTM Travel')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="glass-card p-6 rounded-3xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 flex items-center gap-3">
                <i class="fa-solid fa-user text-emerald-600"></i>
                Dashboard Penumpang
            </h1>
            <p class="text-xs text-slate-600 font-semibold mt-1">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>. Cari dan pesan tiket travel Anda dengan mudah.</p>
        </div>
        <div>
            <span class="px-3.5 py-2 rounded-xl bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-bold shadow-sm">
                Role: Penumpang
            </span>
        </div>
    </div>

    <!-- Rekomendasi Jadwal (Content-Based Filtering) -->
    <div class="glass-card p-6 rounded-3xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-wand-magic-sparkles text-amber-500"></i>
                    Rekomendasi Jadwal Perjalanan
                </h2>
                <p class="text-xs text-slate-500 font-medium">Rekomendasi personalisasi menggunakan metode <strong>Content-Based Filtering (CBF)</strong></p>
            </div>
            @if(!empty($hasHistory))
                <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 w-fit">
                    <i class="fa-solid fa-check-circle mr-1"></i> Berdasarkan Histori Pemesanan
                </span>
            @endif
        </div>

        @if(!empty($hasHistory) && count($recommendedJadwals ?? []) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($recommendedJadwals as $j)
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 hover:border-amber-400 shadow-sm hover:shadow-md transition relative">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span class="text-xs text-slate-500 uppercase font-bold tracking-wider">Rute Perjalanan</span>
                                <div class="text-lg font-extrabold text-slate-900">{{ $j->asal }} &rarr; {{ $j->tujuan }}</div>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-extrabold text-emerald-700 block">Rp {{ number_format($j->harga, 0, ',', '.') }}</span>
                                @if(isset($j->match_percentage))
                                    <span class="inline-block px-2.5 py-0.5 mt-1 text-[10px] font-extrabold rounded-md bg-amber-100 text-amber-900 border border-amber-300">
                                        ✨ {{ $j->match_percentage }}% Cocok
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs text-slate-800 font-semibold my-3 bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <div><i class="fa-regular fa-calendar text-slate-500 mr-1"></i> {{ $j->tanggal }}</div>
                            <div><i class="fa-regular fa-clock text-slate-500 mr-1"></i> Jam {{ $j->jam }}</div>
                            <div><i class="fa-solid fa-van-shuttle text-slate-500 mr-1"></i> {{ $j->armada->merk ?? '-' }}</div>
                            <div><i class="fa-solid fa-id-badge text-slate-500 mr-1"></i> Sopir: {{ $j->sopir->nama ?? '-' }}</div>
                        </div>

                        <a href="{{ route('penumpang.pilih_kursi', $j->id_jadwal) }}" class="block text-center w-full py-2.5 bg-slate-900 hover:bg-black text-amber-400 font-bold text-xs rounded-xl shadow transition">
                            Pesan Tiket Ini
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State untuk Akun Baru / Tanpa Histori Pemesanan -->
            <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-200">
                <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-full flex items-center justify-center mx-auto mb-3 text-lg font-bold">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">Belum Ada Rekomendasi Jadwal</h3>
                <p class="text-xs text-slate-500 mt-1.5 max-w-md mx-auto leading-relaxed">
                    Akun Anda belum memiliki riwayat pemesanan tiket. Fitur rekomendasi <strong>Content-Based Filtering (CBF)</strong> akan secara otomatis memberikan jadwal yang sesuai dengan preferensi rute, jam, dan armada favorit Anda setelah transaksi pertama dilakukan.
                </p>
                <a href="{{ route('penumpang.jadwal') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-slate-900 hover:bg-black text-amber-400 font-bold text-xs rounded-xl shadow transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Cari & Pesan Tiket Perjalanan
                </a>
            </div>
        @endif
    </div>

    <!-- Riwayat Pemesanan Tiket Saya -->
    <div class="glass-card p-6 rounded-3xl">
        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-ticket text-indigo-600"></i>
            Riwayat Pemesanan Tiket Saya
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800">
                <thead class="bg-slate-100 text-slate-700 uppercase text-[11px] font-extrabold border-b border-slate-200">
                    <tr>
                        <th class="p-3">ID Pemesanan</th>
                        <th class="p-3">Tanggal Pesan</th>
                        <th class="p-3">Rute</th>
                        <th class="p-3">Kursi</th>
                        <th class="p-3">Jumlah</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($myPemesanans as $p)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-bold text-slate-900">#{{ $p->id_pemesanan }}</td>
                            <td class="p-3 font-semibold text-slate-700">{{ $p->tanggal_pesan }}</td>
                            <td class="p-3 font-bold text-sky-700">{{ $p->jadwal->asal ?? '-' }} &rarr; {{ $p->jadwal->tujuan ?? '-' }}</td>
                            <td class="p-3 font-bold text-purple-700">{{ $p->kursi->nomor_kursi ?? '-' }}</td>
                            <td class="p-3 font-semibold text-slate-800">{{ $p->jumlah_penumpang }} Orang</td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    {{ $p->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-slate-600 font-semibold">Anda belum memiliki pemesanan tiket.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
