<?php

namespace Database\Seeders;

use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Sopir;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Generates schedules for 1 month into the future.
     * Optimized using DB transactions and chunked bulk inserts for fast execution.
     */
    public function run(): void
    {
        $armadas = Armada::all();
        $sopirs = Sopir::all();

        if ($armadas->isEmpty() || $sopirs->isEmpty()) {
            return;
        }

        // Clean up previous schedules to prevent duplication
        Jadwal::query()->delete();

        // Standard routes with default market pricing and route-specific departure times
        $routes = [
            [
                'asal' => 'Sijunjung',
                'tujuan' => 'Padang',
                'harga' => 80000.00,
                'bagi_hasil_sopir' => 30000.00,
                'times' => ['05:00:00', '08:00:00', '10:00:00', '13:00:00', '17:00:00'],
            ],
            [
                'asal' => 'Sijunjung',
                'tujuan' => 'BIM',
                'harga' => 150000.00,
                'bagi_hasil_sopir' => 50000.00,
                'times' => ['05:00:00', '08:00:00', '10:00:00', '13:00:00', '17:00:00'],
            ],
            [
                'asal' => 'Padang',
                'tujuan' => 'Sijunjung',
                'harga' => 80000.00,
                'bagi_hasil_sopir' => 30000.00,
                'times' => ['09:00:00', '11:00:00', '13:00:00', '15:00:00', '17:00:00', '19:00:00'],
            ],
            [
                'asal' => 'BIM',
                'tujuan' => 'Sijunjung',
                'harga' => 150000.00,
                'bagi_hasil_sopir' => 50000.00,
                'times' => ['09:00:00', '11:00:00', '13:00:00', '15:00:00', '17:00:00', '19:00:00'],
            ],
            [
                'asal' => 'Sijunjung',
                'tujuan' => 'Solok',
                'harga' => 50000.00,
                'bagi_hasil_sopir' => 20000.00,
                'times' => ['08:00:00', '14:00:00'],
            ],
            [
                'asal' => 'Solok',
                'tujuan' => 'Sijunjung',
                'harga' => 50000.00,
                'bagi_hasil_sopir' => 20000.00,
                'times' => ['08:00:00', '14:00:00'],
            ],
            [
                'asal' => 'Padang',
                'tujuan' => 'Solok',
                'harga' => 60000.00,
                'bagi_hasil_sopir' => 25000.00,
                'times' => ['08:00:00', '14:00:00'],
            ],
            [
                'asal' => 'Solok',
                'tujuan' => 'Padang',
                'harga' => 60000.00,
                'bagi_hasil_sopir' => 25000.00,
                'times' => ['08:00:00', '14:00:00'],
            ],
            [
                'asal' => 'BIM',
                'tujuan' => 'Solok',
                'harga' => 70000.00,
                'bagi_hasil_sopir' => 30000.00,
                'times' => ['08:00:00', '14:00:00'],
            ],
            [
                'asal' => 'Solok',
                'tujuan' => 'BIM',
                'harga' => 70000.00,
                'bagi_hasil_sopir' => 30000.00,
                'times' => ['08:00:00', '14:00:00'],
            ],
        ];

        $armadaCount = $armadas->count();
        $sopirCount = $sopirs->count();
        $now = now();
        $armadaIndex = 0;
        $sopirIndex = 0;

        DB::transaction(function () use ($routes, $armadas, $sopirs, $armadaCount, $sopirCount, $now, &$armadaIndex, &$sopirIndex) {
            $allKursis = [];

            // Seed schedules for the next 30 days (0 = today up to 30 days ahead)
            for ($d = 0; $d <= 30; $d++) {
                $tanggal = Carbon::today()->addDays($d)->toDateString();

                foreach ($routes as $route) {
                    $times = $route['times'] ?? ['08:00:00', '14:00:00'];
                    foreach ($times as $jam) {
                        $armada = $armadas[$armadaIndex % $armadaCount];
                        $sopir = $sopirs[$sopirIndex % $sopirCount];

                        $jadwal = Jadwal::create([
                            'asal' => $route['asal'],
                            'tujuan' => $route['tujuan'],
                            'tanggal' => $tanggal,
                            'jam' => $jam,
                            'id_armada' => $armada->id_armada,
                            'id_sopir' => $sopir->id_sopir,
                            'harga' => $route['harga'],
                            'bagi_hasil_sopir' => $route['bagi_hasil_sopir'],
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);

                        $totalKursi = $armada->kursi ?? 6;
                        for ($k = 1; $k <= $totalKursi; $k++) {
                            $allKursis[] = [
                                'id_jadwal' => $jadwal->id_jadwal,
                                'nomor_kursi' => (string) $k,
                                'status' => 'Kosong',
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }

                        $armadaIndex++;
                        $sopirIndex++;
                    }
                }
            }

            // Chunk bulk insert for seats (500 per batch) for optimal speed and memory efficiency
            foreach (array_chunk($allKursis, 500) as $chunk) {
                Kursi::insert($chunk);
            }
        });
    }
}
