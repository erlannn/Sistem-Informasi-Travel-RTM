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

        $u1 = User::firstOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u1->hasRole('Penumpang')) {
            $u1->assignRole($rolePenumpang);
        }

        Penumpang::firstOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'nama' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 12, Bandung',
            ]
        );

        $u2 = User::firstOrCreate(
            ['email' => 'siti@gmail.com'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u2->hasRole('Penumpang')) {
            $u2->assignRole($rolePenumpang);
        }

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
