<?php

namespace Database\Seeders;

use App\Models\Sopir;
use Illuminate\Database\Seeder;

class SopirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sopir::firstOrCreate(
            ['nama' => 'Agus Setiawan'],
            [
                'no_hp' => '082111222333',
                'alamat' => 'Jl. Pemuda No. 8, Jakarta',
                'gaji' => 4500000.00,
            ]
        );

        Sopir::firstOrCreate(
            ['nama' => 'Joko Widodo'],
            [
                'no_hp' => '082333444555',
                'alamat' => 'Jl. Ahmad Yani No. 20, Semarang',
                'gaji' => 4800000.00,
            ]
        );
    }
}
