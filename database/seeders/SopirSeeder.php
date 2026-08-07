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
            ['email' => 'agus@rtmtravel.com'],
            [
                'name' => 'Agus Setiawan',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u1->hasRole('Sopir')) {
            $u1->assignRole($roleSopir);
        }

        Sopir::firstOrCreate(
            ['nama' => 'Agus Setiawan'],
            [
                'no_hp' => '082111222333',
                'alamat' => 'Jl. Pemuda No. 8, Jakarta',
                'gaji' => 4500000.00,
            ]
        );

        $u2 = User::firstOrCreate(
            ['email' => 'joko@rtmtravel.com'],
            [
                'name' => 'Joko Widodo',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u2->hasRole('Sopir')) {
            $u2->assignRole($roleSopir);
        }

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
