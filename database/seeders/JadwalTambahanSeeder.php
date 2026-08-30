<?php

namespace Database\Seeders;

use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Pemesanan;
use App\Models\Sopir;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalTambahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Safely updates existing schedules and generates missing departure times
     * WITHOUT truncating or deleting any existing schedules, seats, or bookings.
     * Optimized with direct batch queries & chunked transactions for high performance on remote databases.
     */
    public function run(): void
    {
        $armadas = Armada::all();
        $sopirs = Sopir::all();

        if ($armadas->isEmpty() || $sopirs->isEmpty()) {
            if ($this->command) {
                $this->command->warn('Data Armada atau Sopir kosong. Harap jalankan ArmadaSeeder dan SopirSeeder terlebih dahulu.');
            }
            return;
        }

        $pemesananBefore = Pemesanan::query()->count();
        if ($this->command) {
            $this->command->info("Memulai sinkronisasi jadwal. Data pemesanan saat ini: {$pemesananBefore}");
        }

        $now = now();

        // 1. Direct bulk updates for existing schedules (Fast & deadlock-free)
        if ($this->command) {
            $this->command->info("Mengupdate jam jadwal yang sudah ada...");
        }

        $u1 = Jadwal::query()
            ->where('asal', 'Sijunjung')
            ->whereIn('tujuan', ['Padang', 'BIM'])
            ->where('jam', '14:00:00')
            ->update(['jam' => '13:00:00', 'updated_at' => $now]);

        $u2 = Jadwal::query()
            ->whereIn('asal', ['Padang', 'BIM'])
            ->where('tujuan', 'Sijunjung')
            ->where('jam', '08:00:00')
            ->update(['jam' => '09:00:00', 'updated_at' => $now]);

        $u3 = Jadwal::query()
            ->whereIn('asal', ['Padang', 'BIM'])
            ->where('tujuan', 'Sijunjung')
            ->where('jam', '14:00:00')
            ->update(['jam' => '13:00:00', 'updated_at' => $now]);

        $totalUpdated = $u1 + $u2 + $u3;
        if ($this->command) {
            $this->command->info("Berhasil mengedit {$totalUpdated} data jadwal lama.");
        }

        // Target routes configuration (Asal, Tujuan, dan Jam Keberangkatan)
        $targetRoutes = [
            [
                'asal' => 'Sijunjung',
                'tujuan' => 'Padang',
                'harga' => 80000.00,
                'bagi_hasil_sopir' => 30000.00,
                'hours' => ['05:00:00', '08:00:00', '10:00:00', '13:00:00', '17:00:00'],
            ],
            [
                'asal' => 'Sijunjung',
                'tujuan' => 'BIM',
                'harga' => 150000.00,
                'bagi_hasil_sopir' => 50000.00,
                'hours' => ['05:00:00', '08:00:00', '10:00:00', '13:00:00', '17:00:00'],
            ],
            [
                'asal' => 'Padang',
                'tujuan' => 'Sijunjung',
                'harga' => 80000.00,
                'bagi_hasil_sopir' => 30000.00,
                'hours' => ['09:00:00', '11:00:00', '13:00:00', '15:00:00', '17:00:00', '19:00:00'],
            ],
            [
                'asal' => 'BIM',
                'tujuan' => 'Sijunjung',
                'harga' => 150000.00,
                'bagi_hasil_sopir' => 50000.00,
                'hours' => ['09:00:00', '11:00:00', '13:00:00', '15:00:00', '17:00:00', '19:00:00'],
            ],
            [
                'asal' => 'Sijunjung',
                'tujuan' => 'Solok',
                'harga' => 50000.00,
                'bagi_hasil_sopir' => 20000.00,
                'hours' => ['08:00:00', '14:00:00'],
            ],
            [
                'asal' => 'Solok',
                'tujuan' => 'Sijunjung',
                'harga' => 50000.00,
                'bagi_hasil_sopir' => 20000.00,
                'hours' => ['08:00:00', '14:00:00'],
            ],
            [
                'asal' => 'Padang',
                'tujuan' => 'Solok',
                'harga' => 60000.00,
                'bagi_hasil_sopir' => 25000.00,
                'hours' => ['08:00:00', '14:00:00'],
            ],
            [
                'asal' => 'Solok',
                'tujuan' => 'Padang',
                'harga' => 60000.00,
                'bagi_hasil_sopir' => 25000.00,
                'hours' => ['08:00:00', '14:00:00'],
            ],
            [
                'asal' => 'BIM',
                'tujuan' => 'Solok',
                'harga' => 70000.00,
                'bagi_hasil_sopir' => 30000.00,
                'hours' => ['08:00:00', '14:00:00'],
            ],
            [
                'asal' => 'Solok',
                'tujuan' => 'BIM',
                'harga' => 70000.00,
                'bagi_hasil_sopir' => 30000.00,
                'hours' => ['08:00:00', '14:00:00'],
            ],
        ];

        // 2. Fetch existing schedule keys in memory for fast O(1) checking
        $existingJadwals = Jadwal::query()->select(['asal', 'tujuan', 'tanggal', 'jam'])->get();
        $existingMap = [];
        foreach ($existingJadwals as $ej) {
            $jamFormatted = strlen($ej->jam) == 5 ? $ej->jam . ':00' : $ej->jam;
            $existingMap["{$ej->asal}|{$ej->tujuan}|{$ej->tanggal}|{$jamFormatted}"] = true;
        }

        // Distinct dates in existing database or next 30 days
        $dates = Jadwal::query()->distinct()->orderBy('tanggal')->pluck('tanggal')->toArray();
        if (empty($dates)) {
            for ($d = 0; $d <= 30; $d++) {
                $dates[] = Carbon::today()->addDays($d)->toDateString();
            }
        }

        $armadaCount = $armadas->count();
        $sopirCount = $sopirs->count();
        $armadaIndex = 0;
        $sopirIndex = 0;

        // 3. Pre-collect all missing schedule items
        $schedulesToCreate = [];
        foreach ($targetRoutes as $route) {
            $asal = $route['asal'];
            $tujuan = $route['tujuan'];
            $targetHours = $route['hours'];

            foreach ($dates as $tanggal) {
                foreach ($targetHours as $jam) {
                    $key = "{$asal}|{$tujuan}|{$tanggal}|{$jam}";
                    if (!isset($existingMap[$key])) {
                        $armada = $armadas[$armadaIndex % $armadaCount];
                        $sopir = $sopirs[$sopirIndex % $sopirCount];

                        $schedulesToCreate[] = [
                            'asal' => $asal,
                            'tujuan' => $tujuan,
                            'tanggal' => $tanggal,
                            'jam' => $jam,
                            'id_armada' => $armada->id_armada,
                            'id_sopir' => $sopir->id_sopir,
                            'harga' => $route['harga'],
                            'bagi_hasil_sopir' => $route['bagi_hasil_sopir'],
                            'kursi_total' => $armada->kursi ?? 6,
                        ];

                        $existingMap[$key] = true;
                        $armadaIndex++;
                        $sopirIndex++;
                    }
                }
            }
        }

        $createdJadwalCount = 0;
        $createdKursiCount = 0;

        if ($this->command) {
            $this->command->info("Memproses " . count($schedulesToCreate) . " jadwal baru dalam batch cepat...");
        }

        // 4. Process in fast chunked transactions (50 schedules per batch)
        foreach (array_chunk($schedulesToCreate, 50) as $batch) {
            DB::transaction(function () use ($batch, $now, &$createdJadwalCount, &$createdKursiCount) {
                $kursisBatch = [];
                foreach ($batch as $item) {
                    $kursiTotal = $item['kursi_total'];
                    unset($item['kursi_total']);
                    $item['created_at'] = $now;
                    $item['updated_at'] = $now;

                    $jadwal = Jadwal::query()->create($item);
                    $createdJadwalCount++;

                    for ($k = 1; $k <= $kursiTotal; $k++) {
                        $kursisBatch[] = [
                            'id_jadwal' => $jadwal->id_jadwal,
                            'nomor_kursi' => (string) $k,
                            'status' => 'Kosong',
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }

                if (!empty($kursisBatch)) {
                    foreach (array_chunk($kursisBatch, 500) as $chunk) {
                        Kursi::query()->insert($chunk);
                    }
                    $createdKursiCount += count($kursisBatch);
                }
            });
        }

        $pemesananAfter = Pemesanan::query()->count();
        if ($this->command) {
            $this->command->info("Selesai! Jadwal diedit: {$totalUpdated}, Jadwal baru ditambahkan: {$createdJadwalCount}, Kursi baru ditambahkan: {$createdKursiCount}.");
            $this->command->info("Verifikasi: Data Pemesanan tetap utuh ({$pemesananAfter} data pemesanan).");
        }
    }
}
