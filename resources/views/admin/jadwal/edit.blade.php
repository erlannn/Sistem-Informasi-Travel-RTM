@extends('layouts.admin')

@section('title', 'Edit Jadwal Perjalanan - CV Travel RTM')
@section('page_title', 'Edit Jadwal Keberangkatan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                Edit Rute {{ $jadwal->asal }} &rarr; {{ $jadwal->tujuan }}
            </h1>
            <p class="text-xs text-slate-500 font-medium">Perbarui rute, jam, armada, atau pengemudi jadwal ini.</p>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="px-4 py-2.5 bg-red-500 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition flex items-center gap-2">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.jadwal.update', $jadwal->id_jadwal) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kota Asal <span class="text-red-500">*</span>
                    </label>
                    <select id="select-asal" name="asal" required
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition font-bold">
                        <option value="Sijunjung" {{ old('asal', $jadwal->asal) == 'Sijunjung' ? 'selected' : '' }}>Sijunjung</option>
                        <option value="Solok" {{ old('asal', $jadwal->asal) == 'Solok' ? 'selected' : '' }}>Solok</option>
                        <option value="Padang" {{ old('asal', $jadwal->asal) == 'Padang' ? 'selected' : '' }}>Padang</option>
                        <option value="BIM" {{ old('asal', $jadwal->asal) == 'BIM' ? 'selected' : '' }}>Bandara Internasional Minangkabau (BIM)</option>
                    </select>
                    @error('asal')
                        <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kota Tujuan <span class="text-red-500">*</span>
                    </label>
                    <select id="select-tujuan" name="tujuan" required
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition font-bold">
                        <option value="Padang" {{ old('tujuan', $jadwal->tujuan) == 'Padang' ? 'selected' : '' }}>Padang</option>
                        <option value="Solok" {{ old('tujuan', $jadwal->tujuan) == 'Solok' ? 'selected' : '' }}>Solok</option>
                        <option value="BIM" {{ old('tujuan', $jadwal->tujuan) == 'BIM' ? 'selected' : '' }}>Bandara Internasional Minangkabau (BIM)</option>
                        <option value="Sijunjung" {{ old('tujuan', $jadwal->tujuan) == 'Sijunjung' ? 'selected' : '' }}>Sijunjung</option>
                    </select>
                    @error('tujuan')
                        <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Route Info Banner -->
            <div id="route-info-banner" class="bg-amber-50 border border-amber-200 p-4 rounded-2xl space-y-1 text-xs">
                <div class="flex justify-between font-extrabold text-slate-900">
                    <span id="route-title">{{ $jadwal->asal }} &rarr; {{ $jadwal->tujuan }}</span>
                    <span id="route-price" class="text-amber-700 font-black">Rp {{ number_format($jadwal->harga, 0, ',', '.') }} / Tiket</span>
                </div>
                <div class="flex justify-between text-[11px] text-slate-600 font-medium pt-1 border-t border-amber-200/60">
                    <span>Bagi Hasil Supir: <strong id="route-driver" class="text-emerald-700">Rp {{ number_format($jadwal->bagi_hasil_sopir, 0, ',', '.') }}</strong></span>
                    <span>Setoran Perusahaan: <strong id="route-company" class="text-blue-700">Rp {{ number_format($jadwal->setoran_perusahaan, 0, ',', '.') }}</strong></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Tanggal Keberangkatan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal) }}" required
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    @error('tanggal')
                        <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Jam Keberangkatan <span class="text-red-500">*</span>
                    </label>
                    <select id="select-jam" name="jam" required
                        class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition font-bold">
                        <!-- Populated by JavaScript -->
                    </select>
                    @error('jam')
                        <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Pilih Armada Kendaraan <span class="text-red-500">*</span>
                </label>
                <select name="id_armada" required
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    <option value="">-- Pilih Armada --</option>
                    @foreach($armadas as $a)
                        <option value="{{ $a->id_armada }}" {{ old('id_armada', $jadwal->id_armada) == $a->id_armada ? 'selected' : '' }}>
                            {{ $a->merk }} ({{ $a->warna }}) - {{ $a->kursi ?? 6 }} Kursi - Status: {{ $a->status }}
                        </option>
                    @endforeach
                </select>
                @error('id_armada')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Pilih Sopir Ditugaskan <span class="text-red-500">*</span>
                </label>
                <select name="id_sopir" required
                    class="w-full px-4 py-3 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    <option value="">-- Pilih Sopir --</option>
                    @foreach($sopirs as $s)
                        <option value="{{ $s->id_sopir }}" {{ old('id_sopir', $jadwal->id_sopir) == $s->id_sopir ? 'selected' : '' }}>
                            {{ $s->nama }} (HP: {{ $s->no_hp }})
                        </option>
                    @endforeach
                </select>
                @error('id_sopir')
                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.jadwal.index') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-red-500 hover:bg-red-700 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-extrabold text-slate-950 bg-brand-500 hover:bg-brand-600 rounded-xl shadow-xs transition cursor-pointer">
                    Simpan
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

    const routeTitle = document.getElementById('route-title');
    const routePrice = document.getElementById('route-price');
    const routeDriver = document.getElementById('route-driver');
    const routeCompany = document.getElementById('route-company');

    const timesFromSijunjung = [
        { val: '05:00:00', label: 'Jam 05:00 Pagi' },
        { val: '08:00:00', label: 'Jam 08:00 Pagi' },
        { val: '10:00:00', label: 'Jam 10:00 Pagi' },
        { val: '13:00:00', label: 'Jam 13:00 (1 Siang)' },
        { val: '17:00:00', label: 'Jam 17:00 (5 Sore)' }
    ];

    const timesToSijunjung = [
        { val: '09:00:00', label: 'Jam 09:00 Pagi' },
        { val: '11:00:00', label: 'Jam 11:00 Siang' },
        { val: '13:00:00', label: 'Jam 13:00 (1 Siang)' },
        { val: '15:00:00', label: 'Jam 15:00 (3 Sore)' },
        { val: '17:00:00', label: 'Jam 17:00 (5 Sore)' },
        { val: '19:00:00', label: 'Jam 19:00 (7 Malam)' }
    ];

    const pricingMatrix = {
        'Sijunjung-Solok': { harga: 50000, supir: 20000, admin: 30000 },
        'Solok-Sijunjung': { harga: 50000, supir: 20000, admin: 30000 },

        'Sijunjung-Padang': { harga: 80000, supir: 30000, admin: 50000 },
        'Padang-Sijunjung': { harga: 80000, supir: 30000, admin: 50000 },

        'Sijunjung-BIM': { harga: 150000, supir: 50000, admin: 100000 },
        'BIM-Sijunjung': { harga: 150000, supir: 50000, admin: 100000 },
    };

    const currentJam = "{{ old('jam', $jadwal->jam) }}";

    function updateForm() {
        const asal = asalSelect.value;
        const tujuan = tujuanSelect.value;

        // Update schedule hours based on origin
        const times = (asal === 'Sijunjung') ? timesFromSijunjung : timesToSijunjung;
        
        jamSelect.innerHTML = '';
        times.forEach(t => {
            const opt = document.createElement('option');
            opt.value = t.val;
            opt.textContent = t.label;
            if (t.val === currentJam || t.val.substring(0,5) === currentJam.substring(0,5)) {
                opt.selected = true;
            }
            jamSelect.appendChild(opt);
        });

        // Update price banner
        const key = `${asal}-${tujuan}`;
        const p = pricingMatrix[key];
        if (p) {
            routeTitle.textContent = `${asal} → ${tujuan}`;
            routePrice.textContent = `Rp ${p.harga.toLocaleString('id-ID')} / Tiket`;
            routeDriver.textContent = `Rp ${p.supir.toLocaleString('id-ID')}`;
            routeCompany.textContent = `Rp ${p.admin.toLocaleString('id-ID')}`;
        } else {
            routeTitle.textContent = `${asal} → ${tujuan} (Rute Tidak Tersedia)`;
            routePrice.textContent = `Pilih rute yang valid`;
            routeDriver.textContent = `-`;
            routeCompany.textContent = `-`;
        }
    }

    asalSelect.addEventListener('change', updateForm);
    tujuanSelect.addEventListener('change', updateForm);
    updateForm();
});
</script>
@endsection
