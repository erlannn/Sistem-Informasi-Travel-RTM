<?php

namespace Database\Seeders;

use App\Models\Pemesanan;
use Illuminate\Database\Seeder;

class PemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pemesanan::firstOrCreate(
            [
                'id_penumpang' => 1,
                'id_jadwal' => 1,
                'id_kursi' => 1,
            ],
            [
                'tanggal_pesan' => '2026-08-06',
                'jumlah_penumpang' => 1,
                'status' => 'Lunas',
            ]
        );
    }
}
