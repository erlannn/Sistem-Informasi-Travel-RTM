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
     * Optimized for fast execution on remote/online databases.
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

        // 2 key routes with fixed prices
        $routes = [
            ['asal' => 'Sijunjung', 'tujuan' => 'Padang', 'harga' => 80000.00, 'bagi_hasil_sopir' => 30000.00],
            ['asal' => 'Padang', 'tujuan' => 'Sijunjung', 'harga' => 80000.00, 'bagi_hasil_sopir' => 30000.00],
        ];

        // 2 departure times per day
        $departureTimes = ['08:00:00', '14:00:00'];

        $armadaCount = $armadas->count();
        $sopirCount = $sopirs->count();
        $now = now();
        $armadaIndex = 0;
        $sopirIndex = 0;

        $allKursis = [];

        DB::transaction(function () use ($routes, $departureTimes, $armadas, $sopirs, $armadaCount, $sopirCount, $now, &$armadaIndex, &$sopirIndex, &$allKursis) {
            // Seed lightweight schedule set: Yesterday (-1), Today (0), Tomorrow (+1)
            for ($d = -1; $d <= 1; $d++) {
                $tanggal = Carbon::today()->addDays($d)->toDateString();

                foreach ($routes as $route) {
                    foreach ($departureTimes as $jam) {
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

                        $totalKursi = $armada->kursi ?? 7;
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

            // Bulk insert all seats in a single SQL query
            if (!empty($allKursis)) {
                Kursi::insert($allKursis);
            }
        });
    }
}
