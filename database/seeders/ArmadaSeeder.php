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
        Armada::firstOrCreate(
            ['merk' => 'Toyota HiAce Premio'],
            [
                'warna' => 'Putih Metalik',
                'status' => 'Tersedia',
            ]
        );

        Armada::firstOrCreate(
            ['merk' => 'Isuzu Elf Long'],
            [
                'warna' => 'Hitam',
                'status' => 'Tersedia',
            ]
        );

        Armada::firstOrCreate(
            ['merk' => 'Mercedes-Benz Sprinter'],
            [
                'warna' => 'Silver',
                'status' => 'Beroperasi',
            ]
        );
    }
}
