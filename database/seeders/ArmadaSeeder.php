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
        $armadas = [
            ['merk' => 'Toyota Avanza', 'warna' => 'Pink', 'status' => 'Tersedia'],
            ['merk' => 'Daihatsu Xenia', 'warna' => 'Khaki', 'status' => 'Tersedia'],
            ['merk' => 'Toyota Calya', 'warna' => 'Putih', 'status' => 'Tersedia'],
            ['merk' => 'Toyota Calya', 'warna' => 'Hitam', 'status' => 'Tersedia'],
            ['merk' => 'Toyota Calya', 'warna' => 'Grey', 'status' => 'Tersedia'],
            ['merk' => 'Toyota Avanza', 'warna' => 'Hitam', 'status' => 'Tersedia'],
            ['merk' => 'Toyota Calya', 'warna' => 'Merah Maroon', 'status' => 'Tersedia'],
            ['merk' => 'Kijang Inova Reborn', 'warna' => 'Putih', 'status' => 'Tersedia'],
        ];

        foreach ($armadas as $data) {
            Armada::firstOrCreate(
                ['merk' => $data['merk'], 'warna' => $data['warna']],
                ['status' => $data['status']]
            );
        }
    }
}

