<?php

namespace Database\Seeders;

use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Sopir;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalTambahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Safely generates additional schedules without truncating or deleting existing schedules and bookings.
     */
    public function run(): void
    {
        $armadas = Armada::all();
        $sopirs = Sopir::all();

        if ($armadas->isEmpty() || $sopirs->isEmpty()) {
            $this->command->warn('Data Armada atau Sopir kosong. Harap jalankan ArmadaSeeder dan SopirSeeder terlebih dahulu.');
            return;
        }

        // Standard routes with default pricing
        $routes = [
            ['asal' => 'Sijunjung', 'tujuan' => 'Padang', 'harga' => 80000.00, 'bagi_hasil_sopir' => 30000.00],
            ['asal' => 'Padang', 'tujuan' => 'Sijunjung', 'harga' => 80000.00, 'bagi_hasil_sopir' => 30000.00],
            ['asal' => 'Sijunjung', 'tujuan' => 'Solok', 'harga' => 50000.00, 'bagi_hasil_sopir' => 20000.00],
            ['asal' => 'Solok', 'tujuan' => 'Sijunjung', 'harga' => 50000.00, 'bagi_hasil_sopir' => 20000.00],
            ['asal' => 'Sijunjung', 'tujuan' => 'BIM', 'harga' => 150000.00, 'bagi_hasil_sopir' => 50000.00],
            ['asal' => 'BIM', 'tujuan' => 'Sijunjung', 'harga' => 150000.00, 'bagi_hasil_sopir' => 50000.00],
            ['asal' => 'Padang', 'tujuan' => 'Solok', 'harga' => 60000.00, 'bagi_hasil_sopir' => 25000.00],
            ['asal' => 'Solok', 'tujuan' => 'Padang', 'harga' => 60000.00, 'bagi_hasil_sopir' => 25000.00],
            ['asal' => 'BIM', 'tujuan' => 'Solok', 'harga' => 70000.00, 'bagi_hasil_sopir' => 30000.00],
            ['asal' => 'Solok', 'tujuan' => 'BIM', 'harga' => 70000.00, 'bagi_hasil_sopir' => 30000.00],
        ];

        // Additional departure times (e.g. 09:00 and 13:00)
        $departureTimes = ['09:00:00', '13:00:00'];

        $armadaCount = $armadas->count();
        $sopirCount = $sopirs->count();
        $now = now();
        $armadaIndex = 0;
        $sopirIndex = 0;

        $totalJadwalBaru = 0;

        DB::transaction(function () use ($routes, $departureTimes, $armadas, $sopirs, $armadaCount, $sopirCount, $now, &$armadaIndex, &$sopirIndex, &$totalJadwalBaru) {
            $allKursis = [];

            // Seed additional schedules for the next 30 days
            for ($d = 0; $d <= 30; $d++) {
                $tanggal = Carbon::today()->addDays($d)->toDateString();

                foreach ($routes as $route) {
                    foreach ($departureTimes as $jam) {
                        $armada = $armadas[$armadaIndex % $armadaCount];
                        $sopir = $sopirs[$sopirIndex % $sopirCount];

                        // Prevent duplicate schedule entry
                        $exists = Jadwal::where('asal', $route['asal'])
                            ->where('tujuan', $route['tujuan'])
                            ->where('tanggal', $tanggal)
                            ->where('jam', $jam)
                            ->where('id_armada', $armada->id_armada)
                            ->exists();

                        if (!$exists) {
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

                            $totalJadwalBaru++;
                        }

                        $armadaIndex++;
                        $sopirIndex++;
                    }
                }
            }

            // Chunk bulk insert for seats (500 per batch)
            foreach (array_chunk($allKursis, 500) as $chunk) {
                Kursi::insert($chunk);
            }
        });

        $this->command->info("Berhasil menambahkan {$totalJadwalBaru} jadwal baru beserta kursinya tanpa mengubah/menghapus data pemesanan yang ada.");
    }
}
