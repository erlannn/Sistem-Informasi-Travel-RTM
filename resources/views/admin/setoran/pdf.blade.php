<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembagian Hasil Setoran - CV Travel RTM</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.4;
            padding: 20px;
        }

        .header {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 15px;
            display: table;
            width: 100%;
        }

        .brand-col {
            display: table-cell;
            vertical-align: middle;
            width: 60%;
        }

        .info-col {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 40%;
            font-size: 10px;
            color: #475569;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .brand-title span {
            color: #d97706;
        }

        .brand-subtitle {
            font-size: 12px;
            font-weight: 700;
            color: #334155;
            margin-top: 2px;
        }

        .summary-box {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
        }

        .summary-cell {
            display: table-cell;
            width: 25%;
            vertical-align: middle;
            border-right: 1px solid #cbd5e1;
            padding: 0 8px;
        }

        .summary-cell:last-child {
            border-right: none;
        }

        .summary-label {
            font-size: 9px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
        }

        .summary-value {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            margin-top: 2px;
            display: block;
        }

        .text-amber { color: #d97706; }
        .text-indigo { color: #4f46e5; }
        .text-emerald { color: #059669; }
        .text-rose { color: #e11d48; }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: left;
            border: 1px solid #0f172a;
        }

        table.data-table td {
            padding: 7px 10px;
            border: 1px solid #e2e8f0;
            font-size: 10.5px;
        }

        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-secondary {
            background-color: #f1f5f9;
            color: #475569;
        }

        .tfoot-row td {
            background-color: #1e293b;
            color: #ffffff !important;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #1e293b;
        }

        .signature-section {
            display: table;
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }

        .signature-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .signature-col-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
        }

        .signature-space {
            height: 50px;
        }
    </style>
</head>
<body>

    <!-- Header / Kop Surat -->
    <div class="header">
        <div class="brand-col">
            <div class="brand-title">CV. <span>TRAVEL RTM</span></div>
            <div class="brand-subtitle">Laporan Pembagian Hasil Setoran Supir & Kas Admin</div>
        </div>
        <div class="info-col">
            <div><strong>Periode Laporan:</strong> {{ $periodLabel }}</div>
            <div><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB</div>
        </div>
    </div>

    <!-- Summary Box -->
    <div class="summary-box">
        <div class="summary-cell">
            <span class="summary-label">Total Tiket Kotor</span>
            <span class="summary-value text-amber">Rp {{ number_format($totalPendapatanKotorSemua, 0, ',', '.') }}</span>
        </div>
        <div class="summary-cell">
            <span class="summary-label">Hak Supir (Bagi Hasil)</span>
            <span class="summary-value text-indigo">Rp {{ number_format($totalHakSupirSemua, 0, ',', '.') }}</span>
        </div>
        <div class="summary-cell">
            <span class="summary-label">Bagian Kas Admin</span>
            <span class="summary-value text-emerald">Rp {{ number_format($totalSetoranWajibSemua, 0, ',', '.') }}</span>
        </div>
        <div class="summary-cell">
            <span class="summary-label">Belum Disetor ke Kas</span>
            <span class="summary-value text-rose">Rp {{ number_format($totalBelumSetorSemua, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Table Data -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;" class="text-center">No</th>
                <th style="width: 14%;">Tanggal & Jam</th>
                <th style="width: 16%;">Rute Perjalanan</th>
                <th style="width: 18%;">Supir & Armada</th>
                <th style="width: 10%;" class="text-center">Penumpang</th>
                <th style="width: 13%;" class="text-right">Total Tiket</th>
                <th style="width: 12%;" class="text-right">Hak Supir</th>
                <th style="width: 13%;" class="text-right">Kas Admin</th>
                <th style="width: 10%;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapJadwal as $index => $r)
                @php $j = $r['jadwal']; @endphp
                <tr>
                    <td class="text-center font-bold">{{ $loop->iteration }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}<br>
                        <small style="color: #64748b;">Jam {{ \Carbon\Carbon::parse($j->jam)->format('H:i') }} WIB</small>
                    </td>
                    <td class="font-bold">
                        {{ $j->asal }} &rarr; {{ $j->tujuan }}
                    </td>
                    <td>
                        <strong>{{ $j->sopir->nama ?? '-' }}</strong><br>
                        <small style="color: #64748b;">{{ $j->armada->merk ?? '-' }} @if(isset($j->armada->plat_nomor))({{ $j->armada->plat_nomor }})@endif</small>
                    </td>
                    <td class="text-center font-bold">
                        {{ $r['total_penumpang_lunas'] }} Orang
                    </td>
                    <td class="text-right font-bold">
                        Rp {{ number_format($r['total_pendapatan_kotor'], 0, ',', '.') }}
                    </td>
                    <td class="text-right font-bold text-indigo">
                        Rp {{ number_format($r['total_hak_supir'], 0, ',', '.') }}
                    </td>
                    <td class="text-right font-bold text-emerald">
                        Rp {{ number_format($r['total_setoran_wajib'], 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @if($r['is_fully_setor'])
                            <span class="badge badge-success">Disetor</span>
                        @elseif($r['total_setoran_wajib'] == 0)
                            <span class="badge badge-secondary">Nihil</span>
                        @else
                            <span class="badge badge-warning">Belum</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px; color: #64748b;">
                        Belum ada data perjalanan untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($rekapJadwal->count() > 0)
            <tfoot>
                <tr class="tfoot-row">
                    <td colspan="5" class="text-right font-bold" style="text-transform: uppercase;">Total Keseluruhan:</td>
                    <td class="text-right font-bold" style="color: #fef08a !important;">Rp {{ number_format($totalPendapatanKotorSemua, 0, ',', '.') }}</td>
                    <td class="text-right font-bold" style="color: #c7d2fe !important;">Rp {{ number_format($totalHakSupirSemua, 0, ',', '.') }}</td>
                    <td class="text-right font-bold" style="color: #a7f3d0 !important;">Rp {{ number_format($totalSetoranWajibSemua, 0, ',', '.') }}</td>
                    <td class="text-center font-bold" style="font-size: 9px; color: #fecdd3 !important;">Sisa: Rp {{ number_format($totalBelumSetorSemua, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-col">
            <small style="color: #64748b;">Catatan:</small>
            <p style="font-size: 10px; color: #64748b; margin-top: 4px;">
                Laporan ini dicetak secara resmi dari Sistem Informasi Travel RTM sebagai acuan verifikasi keuangan kas admin dan gaji supir.
            </p>
        </div>
        <div class="signature-col-right">
            <div>Mengetahui,</div>
            <div style="font-weight: bold; margin-top: 2px;">Admin Keuangan / Management</div>
            <div class="signature-space"></div>
            <div style="font-weight: bold; text-decoration: underline;">( Admin CV. Travel RTM )</div>
        </div>
    </div>

</body>
</html>
