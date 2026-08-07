<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jadwal::create([
            'id_armada' => 1,
            'id_sopir' => 1,
            'asal' => 'Bandung',
            'tujuan' => 'Jakarta',
            'tanggal' => '2026-08-10',
            'jam' => '08:00:00',
            'harga' => 150000.00,
        ]);

        Jadwal::create([
            'id_armada' => 2,
            'id_sopir' => 2,
            'asal' => 'Jakarta',
            'tujuan' => 'Yogyakarta',
            'tanggal' => '2026-08-11',
            'jam' => '19:00:00',
            'harga' => 250000.00,
        ]);
    }
}
