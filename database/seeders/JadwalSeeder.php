<?php

namespace Database\Seeders;

use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Sopir;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $armadas = Armada::all();
        $sopirs = Sopir::all();

        if ($armadas->isEmpty() || $sopirs->isEmpty()) {
            return;
        }

        // Define 6 fixed routes with prices and driver shares
        $routes = [
            // From Sijunjung
            ['asal' => 'Sijunjung', 'tujuan' => 'Solok', 'harga' => 50000.00, 'bagi_hasil_sopir' => 20000.00],
            ['asal' => 'Sijunjung', 'tujuan' => 'Padang', 'harga' => 80000.00, 'bagi_hasil_sopir' => 30000.00],
            ['asal' => 'Sijunjung', 'tujuan' => 'BIM', 'harga' => 150000.00, 'bagi_hasil_sopir' => 50000.00],
            
            // To Sijunjung
            ['asal' => 'Solok', 'tujuan' => 'Sijunjung', 'harga' => 50000.00, 'bagi_hasil_sopir' => 20000.00],
            ['asal' => 'Padang', 'tujuan' => 'Sijunjung', 'harga' => 80000.00, 'bagi_hasil_sopir' => 30000.00],
            ['asal' => 'BIM', 'tujuan' => 'Sijunjung', 'harga' => 150000.00, 'bagi_hasil_sopir' => 50000.00],
        ];

        // Departure times
        $timesFromSijunjung = ['05:00:00', '08:00:00', '10:00:00', '13:00:00', '17:00:00'];
        $timesToSijunjung = ['09:00:00', '11:00:00', '13:00:00', '15:00:00', '17:00:00', '19:00:00'];

        $armadaIndex = 0;
        $sopirIndex = 0;

        // Seed schedules for 7 days starting today
        for ($d = 0; $d < 7; $d++) {
            $tanggal = Carbon::today()->addDays($d)->toDateString();

            foreach ($routes as $r) {
                $times = ($r['asal'] === 'Sijunjung') ? $timesFromSijunjung : $timesToSijunjung;

                foreach ($times as $jam) {
                    $armada = $armadas[$armadaIndex % $armadas->count()];
                    $sopir = $sopirs[$sopirIndex % $sopirs->count()];

                    $jadwal = Jadwal::firstOrCreate(
                        [
                            'asal' => $r['asal'],
                            'tujuan' => $r['tujuan'],
                            'tanggal' => $tanggal,
                            'jam' => $jam,
                        ],
                        [
                            'id_armada' => $armada->id_armada,
                            'id_sopir' => $sopir->id_sopir,
                            'harga' => $r['harga'],
                            'bagi_hasil_sopir' => $r['bagi_hasil_sopir'],
                        ]
                    );

                    // Auto-generate seats for each schedule if not existing
                    if ($jadwal->wasRecentlyCreated || $jadwal->kursis()->count() === 0) {
                        $totalKursi = $armada->kursi ?? 7;
                        for ($k = 1; $k <= $totalKursi; $k++) {
                            Kursi::firstOrCreate([
                                'id_jadwal' => $jadwal->id_jadwal,
                                'nomor_kursi' => (string) $k,
                            ], [
                                'status' => 'Tersedia',
                            ]);
                        }
                    }

                    $armadaIndex++;
                    $sopirIndex++;
                }
            }
        }
    }
}
