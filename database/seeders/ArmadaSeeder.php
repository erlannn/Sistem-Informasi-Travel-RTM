<?php

namespace Database\Seeders;

use App\Models\Armada;
use Illuminate\Database\Seeder;

class ArmadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Armada::create([
            'merk' => 'Toyota HiAce Premio',
            'warna' => 'Putih Metaflik',
            'status' => 'Tersedia',
        ]);

        Armada::create([
            'merk' => 'Isuzu Elf Long',
            'warna' => 'Hitam',
            'status' => 'Tersedia',
        ]);

        Armada::create([
            'merk' => 'Mercedes-Benz Sprinter',
            'warna' => 'Silver',
            'status' => 'Beroperasi',
        ]);
    }
}
