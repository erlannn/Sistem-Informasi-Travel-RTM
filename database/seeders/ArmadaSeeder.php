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
            ['merk' => 'Toyota Avanza'],
            [
                'warna' => 'Pink',
                'kursi' => 7,
                'status' => 'Aktif',
            ]
        );

        Armada::firstOrCreate(
            ['merk' => 'Daihatsu Xenia'],
            [
                'warna' => 'Khaki',
                'kursi' => 7,
                'status' => 'Aktif',
            ]
        );

        Armada::firstOrCreate(
            ['merk' => 'Toyota Calya'],
            [
                'warna' => 'Putih',
                'kursi' => 7,
                'status' => 'Aktif',
            ]
        );

        Armada::firstOrCreate(
            ['merk' => 'Toyota Calya'],
            [
                'warna' => 'Hitam',
                'kursi' => 7,
                'status' => 'Aktif',
            ]
        );

        Armada::firstOrCreate(
            ['merk' => 'Toyota Calya'],
            [
                'warna' => 'Grey',
                'kursi' => 7,
                'status' => 'Aktif',
            ]
        );

        Armada::firstOrCreate(
            ['merk' => 'Toyota Avanza'],
            [
                'warna' => 'Hitam',
                'kursi' => 7,
                'status' => 'Aktif',
            ]
        );

        Armada::firstOrCreate(
            ['merk' => 'Toyota Calya'],
            [
                'warna' => 'Merah Maroon',
                'kursi' => 7,
                'status' => 'Aktif',
            ]
        );

        Armada::firstOrCreate(
            ['merk' => 'Kijang Inova Reborn'],
            [
                'warna' => 'Putih',
                'kursi' => 7,
                'status' => 'Aktif',
            ]
        );
    }
}

