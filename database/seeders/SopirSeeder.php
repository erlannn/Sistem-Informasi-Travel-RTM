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

        $u1 = User::firstOrCreate(
            ['email' => 'Ongki@rtmtravel.com'],
            [
                'name' => 'Ongki',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u1->hasRole('Sopir')) {
            $u1->assignRole($roleSopir);
        }

        Sopir::firstOrCreate(
            ['nama' => 'Ongki'],
            [
                'no_hp' => '085191083409',
                'alamat' => 'Nagari Pematang Panjang',
            ]
        );

        $u2 = User::firstOrCreate(
            ['email' => 'Raffi@rtmtravel.com'],
            [
                'name' => 'Raffi',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u2->hasRole('Sopir')) {
            $u2->assignRole($roleSopir);
        }

        Sopir::firstOrCreate(
            ['nama' => 'Raffi'],
            [
                'no_hp' => '081224165509',
                'alamat' => 'Nagari Pematang Panjang',
            ]
        );

        $u3 = User::firstOrCreate(
            ['email' => 'joko@rtmtravel.com'],
            [
                'name' => 'Joko Widodo',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u3->hasRole('Sopir')) {
            $u3->assignRole($roleSopir);
        }
    }
}
