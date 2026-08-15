<?php

namespace Database\Seeders;

use App\Models\Penumpang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PenumpangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePenumpang = Role::firstOrCreate(['name' => 'Penumpang']);

        $penumpangs = [
            ['nama' => 'Budi Santoso', 'email' => 'budi@gmail.com', 'no_hp' => '081234567890', 'alamat' => 'Jl. Merdeka No. 12, Bandung'],
            ['nama' => 'Siti Nurhaliza', 'email' => 'siti@gmail.com', 'no_hp' => '089876543210', 'alamat' => 'Jl. Malioboro No. 45, Yogyakarta'],
            ['nama' => 'Andi Pratama', 'email' => 'andi@gmail.com', 'no_hp' => '081399887766', 'alamat' => 'Jl. Sudirman No. 88, Jakarta'],
            ['nama' => 'Rina Wijaya', 'email' => 'rina@gmail.com', 'no_hp' => '085211223344', 'alamat' => 'Jl. Ahmad Yani No. 15, Padang'],
            ['nama' => 'Dewi Lestari', 'email' => 'dewi@gmail.com', 'no_hp' => '087855667788', 'alamat' => 'Jl. Gajah Mada No. 3, Solok'],
            ['nama' => 'Agus Setiawan', 'email' => 'agus@gmail.com', 'no_hp' => '081244556677', 'alamat' => 'Jl. Khatib Sulaiman No. 20, Padang'],
            ['nama' => 'Maya Putri', 'email' => 'maya@gmail.com', 'no_hp' => '082133445566', 'alamat' => 'Jl. Hamka No. 4, Sijunjung'],
            ['nama' => 'Doni Kurniawan', 'email' => 'doni@gmail.com', 'no_hp' => '083811223344', 'alamat' => 'Jl. Veteran No. 10, Bukittinggi'],
            ['nama' => 'Eka Rahmawati', 'email' => 'eka@gmail.com', 'no_hp' => '085799887766', 'alamat' => 'Jl. Diponegoro No. 5, Sawahlunto'],
            ['nama' => 'Fajar Nugraha', 'email' => 'fajar@gmail.com', 'no_hp' => '081900112233', 'alamat' => 'Jl. Pemuda No. 17, Payakumbuh'],
            ['nama' => 'Gita Gutawa', 'email' => 'gita@gmail.com', 'no_hp' => '082266778899', 'alamat' => 'Jl. Imam Bonjol No. 9, Solok'],
            ['nama' => 'Hendra Saputra', 'email' => 'hendra@gmail.com', 'no_hp' => '081377889900', 'alamat' => 'Jl. Proklamasi No. 2, Sijunjung'],
            ['nama' => 'Indah Permata', 'email' => 'indah@gmail.com', 'no_hp' => '085344556677', 'alamat' => 'Jl. Raya Indarung No. 50, Padang'],
            ['nama' => 'Joko Widodo', 'email' => 'joko@gmail.com', 'no_hp' => '081122334455', 'alamat' => 'Jl. Main Street No. 1, Pariaman'],
            ['nama' => 'Kartika Sari', 'email' => 'kartika@gmail.com', 'no_hp' => '088211335577', 'alamat' => 'Jl. Bypass No. 100, Padang'],
        ];

        foreach ($penumpangs as $p) {
            $user = User::firstOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['nama'],
                    'password' => Hash::make('password123'),
                ]
            );
            if (!$user->hasRole('Penumpang')) {
                $user->assignRole($rolePenumpang);
            }

            Penumpang::firstOrCreate(
                ['email' => $p['email']],
                [
                    'nama' => $p['nama'],
                    'password' => Hash::make('password123'),
                    'no_hp' => $p['no_hp'],
                    'alamat' => $p['alamat'],
                ]
            );
        }
    }
}
