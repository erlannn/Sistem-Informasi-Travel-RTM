<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran Tiket - RTM Family</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #0f172a;
            font-size: 12px;
            line-height: 1.5;
            padding: 25px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .header {
            background-color: #090d16;
            color: #ffffff;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-size: 20px;
            font-weight: 900;
            font-style: italic;
            letter-spacing: -0.5px;
        }

        .brand span {
            color: #eab308;
        }

        .brand-sub {
            font-size: 11px;
            color: #94a3b8;
            font-weight: normal;
            font-style: normal;
            display: block;
            margin-top: 2px;
        }

        .status-badge {
            background-color: #1e293b;
            color: #facc15;
            border: 1px solid rgba(250, 204, 21, 0.3);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section {
            padding: 20px 24px;
            border-bottom: 1px dashed #cbd5e1;
        }

        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 12px;
        }

        .grid-2 {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .col {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .col-left {
            padding-right: 15px;
        }

        .col-right {
            padding-left: 15px;
            border-left: 1px solid #f1f5f9;
        }

        .route-box {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .route-city {
            display: table-cell;
            width: 45%;
        }

        .route-arrow {
            display: table-cell;
            width: 10%;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #eab308;
            vertical-align: middle;
        }

        .label {
            font-size: 10px;
            color: #64748b;
            display: block;
            margin-bottom: 2px;
        }

        .value {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
        }

        .value-gold {
            color: #ca8a04;
        }

        .info-row {
            margin-bottom: 10px;
        }

        .payment-section {
            background-color: #f8fafc;
            padding: 20px 24px;
        }

        .price-table {
            width: 100%;
            border-collapse: collapse;
        }

        .price-table td {
            padding: 4px 0;
            font-size: 11px;
        }

        .price-table .total-row td {
            padding-top: 10px;
            border-top: 1px dashed #cbd5e1;
            font-size: 13px;
            font-weight: bold;
        }

        .barcode-box {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .barcode-lines {
            display: inline-block;
            letter-spacing: 2px;
            font-family: monospace;
            font-weight: bold;
            font-size: 18px;
            background: #000;
            color: #fff;
            padding: 4px 16px;
            border-radius: 4px;
        }

        .footer-note {
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
            margin-top: 15px;
            font-style: italic;
        }
    </style>
</head>
<body>
    @php
        $kode = 'RTM' . sprintf('%04d', $pemesanan->id_pemesanan);
    @endphp

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <div class="brand">R<span>T</span>M Family</div>
                <span class="brand-sub">Sistem Informasi Travel RTM</span>
            </div>
            <div>
                <span class="status-badge">Status: {{ $pemesanan->status }}</span>
            </div>
        </div>

        <!-- Upper Section: Journey & Passenger -->
        <div class="section">
            <div class="grid-2">
                <!-- Col Left: Journey -->
                <div class="col col-left">
                    <div class="section-title">Rincian Perjalanan</div>
                    
                    <div class="route-box">
                        <div class="route-city">
                            <span class="label">Dari</span>
                            <span class="value">{{ $pemesanan->jadwal->asal ?? 'Sijunjung' }}</span>
                        </div>
                        <div class="route-arrow">&rarr;</div>
                        <div class="route-city">
                            <span class="label">Ke</span>
                            <span class="value">{{ $pemesanan->jadwal->tujuan ?? 'Padang' }}</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <span class="label">Tanggal Keberangkatan</span>
                        <span class="value">{{ $pemesanan->jadwal->tanggal ?? date('Y-m-d') }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Jam Berangkat</span>
                        <span class="value">{{ $pemesanan->jadwal->jam ? \Carbon\Carbon::parse($pemesanan->jadwal->jam)->format('H.i') . ' WIB' : '05.00 WIB' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Armada / Mobil</span>
                        <span class="value">{{ $pemesanan->jadwal->armada->merk ?? 'Toyota Avanza' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Nomor Kursi</span>
                        <span class="value value-gold">Kursi {{ $pemesanan->kursi->nomor_kursi ?? '1' }}</span>
                    </div>
                </div>

                <!-- Col Right: Passenger -->
                <div class="col col-right">
                    <div class="section-title">Rincian Penumpang</div>

                    <div class="info-row">
                        <span class="label">Kode Pemesanan</span>
                        <span class="value">{{ $kode }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Nama Penumpang</span>
                        <span class="value">{{ $pemesanan->penumpang->nama ?? 'Penumpang' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Alamat Email</span>
                        <span class="value">{{ $pemesanan->penumpang->email ?? '-' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Nomor Telepon</span>
                        <span class="value">{{ $pemesanan->penumpang->no_hp ?? '-' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Tanggal Pesan</span>
                        <span class="value">{{ $pemesanan->tanggal_pesan ?? date('Y-m-d') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="payment-section">
            <div class="section-title">Detail Harga & Pembayaran</div>
            <table class="price-table">
                <tr>
                    <td style="color: #64748b;">Harga Tiket (1 Penumpang)</td>
                    <td style="text-align: right; font-weight: bold;">Rp {{ number_format($pemesanan->jadwal->harga ?? 70000, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Pembayaran</td>
                    <td style="text-align: right; color: #ca8a04;">Rp {{ number_format($pemesanan->jadwal->harga ?? 70000, 0, ',', '.') }}</td>
                </tr>
            </table>

            <div class="barcode-box">
                <div class="barcode-lines">*{{ $kode }}*</div>
                <div style="font-size: 10px; color: #64748b; margin-top: 6px;">Tunjukkan bukti pembayaran / tiket ini kepada sopir saat keberangkatan</div>
            </div>
        </div>
    </div>

    <div class="footer-note">
        Dokumen ini diterbitkan secara otomatis oleh Sistem Informasi Travel RTM Family dan sah sebagai bukti pemesanan tiket.
    </div>
</body>
</html>
