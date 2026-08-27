@extends('layouts.admin')

@section('title', 'Edit Jadwal Perjalanan - CV Travel RTM')
@section('page_title', 'Edit Jadwal Keberangkatan')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Edit Rute {{ $jadwal->asal }} &rarr; {{ $jadwal->tujuan }}
            </h1>
            <p class="text-xs text-slate-500 font-medium">Perbarui rute, jam, armada, harga tiket, atau pengemudi jadwal ini.</p>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="px-4 py-2.5 bg-red-500 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition flex items-center gap-2">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.jadwal.update', $jadwal->id_jadwal) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                        Kota Asal <span class="text-red-500">*</span>
                    </label>
                    <select id="select-asal" name="asal" required
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition font-bold cursor-pointer">
                        <option value="Sijunjung" {{ old('asal', $jadwal->asal) == 'Sijunjung' ? 'selected' : '' }}>Sijunjung</option>
                        <option value="Solok" {{ old('asal', $jadwal->asal) == 'Solok' ? 'selected' : '' }}>Solok</option>
                        <option value="Padang" {{ old('asal', $jadwal->asal) == 'Padang' ? 'selected' : '' }}>Padang</option>
                        <option value="BIM" {{ old('asal', $jadwal->asal) == 'BIM' ? 'selected' : '' }}>Bandara Internasional Minangkabau (BIM)</option>
                    </select>
                    @error('asal')
                        <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                        Kota Tujuan <span class="text-red-500">*</span>
                    </label>
                    <select id="select-tujuan" name="tujuan" required
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition font-bold cursor-pointer">
                        <option value="Padang" {{ old('tujuan', $jadwal->tujuan) == 'Padang' ? 'selected' : '' }}>Padang</option>
                        <option value="Solok" {{ old('tujuan', $jadwal->tujuan) == 'Solok' ? 'selected' : '' }}>Solok</option>
                        <option value="BIM" {{ old('tujuan', $jadwal->tujuan) == 'BIM' ? 'selected' : '' }}>Bandara Internasional Minangkabau (BIM)</option>
                        <option value="Sijunjung" {{ old('tujuan', $jadwal->tujuan) == 'Sijunjung' ? 'selected' : '' }}>Sijunjung</option>
                    </select>
                    @error('tujuan')
                        <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Custom Pricing Inputs: Harga Tiket & Gaji Sopir -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <div>
                    <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                        Harga Tiket Per Penumpang (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-black text-slate-400">Rp</span>
                        <input type="number" id="input-harga" name="harga" value="{{ old('harga', (int)$jadwal->harga) }}" min="0" step="1000" required
                            class="w-full pl-10 pr-4 py-3 text-xs font-extrabold text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium mt-1 block">Dapat disesuaikan dengan harga pasaran saat ini.</span>
                    @error('harga')
                        <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                        Gaji / Bagi Hasil Sopir (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-black text-slate-400">Rp</span>
                        <input type="number" id="input-gaji-sopir" name="bagi_hasil_sopir" value="{{ old('bagi_hasil_sopir', (int)$jadwal->bagi_hasil_sopir) }}" min="0" step="1000" required
                            class="w-full pl-10 pr-4 py-3 text-xs font-extrabold text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none">
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium mt-1 block">Hak sopir per tiket perjalanan.</span>
                    @error('bagi_hasil_sopir')
                        <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Route & Setoran Real-time Summary Banner -->
            <div id="route-info-banner" class="bg-amber-50 border border-amber-200 p-4 rounded-2xl space-y-1 text-xs">
                <div class="flex justify-between font-extrabold text-slate-900">
                    <span id="route-title">{{ $jadwal->asal }} &rarr; {{ $jadwal->tujuan }}</span>
                    <span id="route-price" class="text-amber-700 font-black">Rp {{ number_format($jadwal->harga, 0, ',', '.') }} / Tiket</span>
                </div>
                <div class="flex justify-between text-[11px] text-slate-600 font-medium pt-1.5 border-t border-amber-200/60">
                    <span>Gaji Sopir (Per Tiket): <strong id="route-driver" class="text-emerald-700">Rp {{ number_format($jadwal->bagi_hasil_sopir, 0, ',', '.') }}</strong></span>
                    <span>Setoran Perusahaan (Per Tiket): <strong id="route-company" class="text-blue-700">Rp {{ number_format($jadwal->setoran_perusahaan, 0, ',', '.') }}</strong></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                        Tanggal Keberangkatan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal) }}" required
                        class="w-full px-4 py-3.5 text-sm font-semibold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none cursor-pointer">
                    @error('tanggal')
                        <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                        Jam Keberangkatan <span class="text-red-500">*</span>
                    </label>
                    <select id="select-jam" name="jam" required
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition font-bold cursor-pointer">
                        <!-- Populated by JavaScript -->
                    </select>
                    @error('jam')
                        <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Pilih Armada Kendaraan <span class="text-red-500">*</span>
                </label>
                <select name="id_armada" required
                    class="w-full px-4 py-3.5 text-sm font-bold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none cursor-pointer">
                    <option value="">-- Pilih Armada --</option>
                    @foreach($armadas as $a)
                        <option value="{{ $a->id_armada }}" {{ old('id_armada', $jadwal->id_armada) == $a->id_armada ? 'selected' : '' }}>
                            {{ $a->merk }} ({{ $a->warna }}) - {{ $a->kursi ?? 6 }} Kursi - Status: {{ $a->status }}
                        </option>
                    @endforeach
                </select>
                @error('id_armada')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-black uppercase tracking-wider text-black mb-2">
                    Pilih Sopir Ditugaskan <span class="text-red-500">*</span>
                </label>
                <select name="id_sopir" required
                    class="w-full px-4 py-3.5 text-sm font-bold text-black bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition outline-none cursor-pointer">
                    <option value="">-- Pilih Sopir --</option>
                    @foreach($sopirs as $s)
                        <option value="{{ $s->id_sopir }}" {{ old('id_sopir', $jadwal->id_sopir) == $s->id_sopir ? 'selected' : '' }}>
                            {{ $s->nama }} (HP: {{ $s->no_hp }})
                        </option>
                    @endforeach
                </select>
                @error('id_sopir')
                    <p class="text-xs text-red-500 font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.jadwal.index') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-red-500 hover:bg-red-700 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-extrabold text-slate-950 bg-brand-500 hover:bg-brand-600 rounded-xl shadow-xs transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const asalSelect = document.getElementById('select-asal');
    const tujuanSelect = document.getElementById('select-tujuan');
    const jamSelect = document.getElementById('select-jam');

    const hargaInput = document.getElementById('input-harga');
    const gajiSopirInput = document.getElementById('input-gaji-sopir');

    const routeTitle = document.getElementById('route-title');
    const routePrice = document.getElementById('route-price');
    const routeDriver = document.getElementById('route-driver');
    const routeCompany = document.getElementById('route-company');

    const timesDefault = [
        { val: '05:00:00', label: 'Jam 05:00 Pagi / Subuh' },
        { val: '08:00:00', label: 'Jam 08:00 Pagi' },
        { val: '09:00:00', label: 'Jam 09:00 Pagi' },
        { val: '10:00:00', label: 'Jam 10:00 Pagi' },
        { val: '11:00:00', label: 'Jam 11:00 Pagi' },
        { val: '13:00:00', label: 'Jam 13:00 (1 Siang)' },
        { val: '15:00:00', label: 'Jam 15:00 (3 Sore)' },
        { val: '17:00:00', label: 'Jam 17:00 (5 Sore)' },
        { val: '19:00:00', label: 'Jam 19:00 (7 Malam)' }
    ];

    const currentJam = "{{ old('jam', $jadwal->jam) }}";

    function populateHours() {
        jamSelect.innerHTML = '';
        timesDefault.forEach(t => {
            const opt = document.createElement('option');
            opt.value = t.val;
            opt.textContent = t.label;
            if (t.val === currentJam || t.val.substring(0,5) === currentJam.substring(0,5)) {
                opt.selected = true;
            }
            jamSelect.appendChild(opt);
        });
    }

    function calculateSummary() {
        const asal = asalSelect.value;
        const tujuan = tujuanSelect.value;

        if (asal === tujuan) {
            routeTitle.textContent = `${asal} → ${tujuan} (Kota asal dan tujuan tidak boleh sama)`;
            routePrice.textContent = `Error`;
            routeDriver.textContent = `-`;
            routeCompany.textContent = `-`;
            return;
        }

        const harga = parseFloat(hargaInput.value) || 0;
        const gajiSopir = parseFloat(gajiSopirInput.value) || 0;
        const setoranPerusahaan = Math.max(0, harga - gajiSopir);

        routeTitle.textContent = `${asal} → ${tujuan}`;
        routePrice.textContent = `Rp ${harga.toLocaleString('id-ID')} / Tiket`;
        routeDriver.textContent = `Rp ${gajiSopir.toLocaleString('id-ID')}`;
        routeCompany.textContent = `Rp ${setoranPerusahaan.toLocaleString('id-ID')}`;
    }

    function onRouteChanged(e) {
        const asal = asalSelect.value;
        let tujuan = tujuanSelect.value;

        if (asal === tujuan) {
            const options = Array.from(tujuanSelect.options).map(o => o.value);
            const validOpt = options.find(val => val !== asal);
            if (validOpt) {
                tujuanSelect.value = validOpt;
            }
        }

        calculateSummary();
    }

    asalSelect.addEventListener('change', onRouteChanged);
    tujuanSelect.addEventListener('change', onRouteChanged);
    hargaInput.addEventListener('input', calculateSummary);
    gajiSopirInput.addEventListener('input', calculateSummary);

    populateHours();
    calculateSummary();
});
</script>
@endsection
