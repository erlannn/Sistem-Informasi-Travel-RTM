<?php

namespace Database\Seeders;

use App\Models\Penumpang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenumpangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penumpang::firstOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'nama' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 12, Bandung',
            ]
        );

        Penumpang::firstOrCreate(
            ['email' => 'siti@gmail.com'],
            [
                'nama' => 'Siti Nurhaliza',
                'password' => Hash::make('password123'),
                'no_hp' => '089876543210',
                'alamat' => 'Jl. Malioboro No. 45, Yogyakarta',
            ]
        );
    }
}
