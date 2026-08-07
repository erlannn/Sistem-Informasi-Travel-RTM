<?php

namespace Database\Seeders;

use App\Models\Kursi;
use Illuminate\Database\Seeder;

class KursiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kursi untuk Jadwal 1
        $kursiJadwal1 = ['1A', '1B', '2A', '2B', '3A', '3B'];
        foreach ($kursiJadwal1 as $nomor) {
            Kursi::create([
                'id_jadwal' => 1,
                'nomor_kursi' => $nomor,
                'status' => $nomor === '1A' ? 'Terisi' : 'Kosong',
            ]);
        }

        // Kursi untuk Jadwal 2
        $kursiJadwal2 = ['1A', '1B', '2A', '2B', '3A', '3B'];
        foreach ($kursiJadwal2 as $nomor) {
            Kursi::create([
                'id_jadwal' => 2,
                'nomor_kursi' => $nomor,
                'status' => 'Kosong',
            ]);
        }
    }
}
