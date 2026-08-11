<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use App\Models\Kursi;
use Illuminate\Database\Seeder;

class KursiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jadwal1 = Jadwal::first();
        $jadwal2 = Jadwal::skip(1)->first() ?? $jadwal1;

        if ($jadwal1) {
            $armada1Seats = $jadwal1->armada->kursi ?? 5;
            for ($i = 1; $i <= $armada1Seats; $i++) {
                $nomor = (string) $i;
                Kursi::firstOrCreate(
                    [
                        'id_jadwal' => $jadwal1->id_jadwal,
                        'nomor_kursi' => $nomor,
                    ],
                    [
                        'status' => $i === 1 ? 'Terisi' : 'Kosong',
                    ]
                );
            }
        }

        if ($jadwal2 && $jadwal2->id_jadwal !== $jadwal1?->id_jadwal) {
            $armada2Seats = $jadwal2->armada->kursi ?? 3;
            for ($i = 1; $i <= $armada2Seats; $i++) {
                $nomor = (string) $i;
                Kursi::firstOrCreate(
                    [
                        'id_jadwal' => $jadwal2->id_jadwal,
                        'nomor_kursi' => $nomor,
                    ],
                    [
                        'status' => 'Kosong',
                    ]
                );
            }
        }
    }
}
