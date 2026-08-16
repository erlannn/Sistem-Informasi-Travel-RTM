<?php

namespace Database\Seeders;

use App\Models\Sopir;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SopirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleSopir = Role::firstOrCreate(['name' => 'Sopir']);
        $passwordHash = Hash::make('password123');

        $sopirs = [
            ['nama' => 'Ongki', 'email' => 'Ongki@rtmtravel.com', 'no_hp' => '085191083409', 'alamat' => 'Nagari Pematang Panjang'],
            ['nama' => 'Raffi', 'email' => 'Raffi@rtmtravel.com', 'no_hp' => '081224165509', 'alamat' => 'Nagari Pematang Panjang'],
            ['nama' => 'Nanda', 'email' => 'Nanda@rtmtravel.com', 'no_hp' => '085374074741', 'alamat' => 'Nagari Sijunjung'],
            ['nama' => 'Eri', 'email' => 'Eri@rtmtravel.com', 'no_hp' => '085376155659', 'alamat' => 'Nagari Pematang Panjang'],
            ['nama' => 'Tomy', 'email' => 'Tomy@rtmtravel.com', 'no_hp' => '082391157508', 'alamat' => 'Nagari Sijunjung'],
            ['nama' => 'Fahmi', 'email' => 'Fahmi@rtmtravel.com', 'no_hp' => '082387359942', 'alamat' => 'Nagari Sijunjung'],
            ['nama' => 'Yoga', 'email' => 'Yoga@rtmtravel.com', 'no_hp' => '082283632616', 'alamat' => 'Nagari Sijunjung'],
            ['nama' => 'Puji', 'email' => 'Puji@rtmtravel.com', 'no_hp' => '085263008933', 'alamat' => 'Nagari Muaro'],
        ];

        foreach ($sopirs as $s) {
            $user = User::firstOrCreate(
                ['email' => $s['email']],
                [
                    'name' => $s['nama'],
                    'password' => $passwordHash,
                ]
            );
            if (!$user->hasRole('Sopir')) {
                $user->assignRole($roleSopir);
            }

            Sopir::firstOrCreate(
                ['nama' => $s['nama']],
                [
                    'no_hp' => $s['no_hp'],
                    'alamat' => $s['alamat'],
                ]
            );
        }
    }
}
