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
            ['email' => 'Nanda@rtmtravel.com'],
            [
                'name' => 'Nanda',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u3->hasRole('Sopir')) {
            $u3->assignRole($roleSopir);
        }

        Sopir::firstOrCreate(
            ['nama' => 'Nanda'],
            [
                'no_hp' => '085374074741',
                'alamat' => 'Nagari Sijunjung',
            ]
        );

        $u4 = User::firstOrCreate(
            ['email' => 'Eri@rtmtravel.com'],
            [
                'name' => 'Eri',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u4->hasRole('Sopir')) {
            $u4->assignRole($roleSopir);
        }

        Sopir::firstOrCreate(
            ['nama' => 'Eri'],
            [
                'no_hp' => '085376155659',
                'alamat' => 'Nagari Pematang Panjang',
            ]
        );


        $u5 = User::firstOrCreate(
            ['email' => 'Tomy@rtmtravel.com'],
            [
                'name' => 'Tomy',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u5->hasRole('Sopir')) {
            $u5->assignRole($roleSopir);
        }

        Sopir::firstOrCreate(
            ['nama' => 'Tomy'],
            [
                'no_hp' => '082391157508',
                'alamat' => 'Nagari Sijunjung',
            ]
        );

        $u6 = User::firstOrCreate(
            ['email' => 'Fahmi@rtmtravel.com'],
            [
                'name' => 'Fahmi',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u6->hasRole('Sopir')) {
            $u6->assignRole($roleSopir);
        }

        Sopir::firstOrCreate(
            ['nama' => 'Fahmi'],
            [
                'no_hp' => '082387359942',
                'alamat' => 'Nagari Sijunjung',
            ]
        );

        $u7 = User::firstOrCreate(
            ['email' => 'Yoga@rtmtravel.com'],
            [
                'name' => 'Yoga',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u7->hasRole('Sopir')) {
            $u7->assignRole($roleSopir);
        }

        Sopir::firstOrCreate(
            ['nama' => 'Yoga'],
            [
                'no_hp' => '082283632616',
                'alamat' => 'Nagari Sijunjung',
            ]
        );

        $u8 = User::firstOrCreate(
            ['email' => 'Puji@rtmtravel.com'],
            [
                'name' => 'Puji',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$u8->hasRole('Sopir')) {
            $u8->assignRole($roleSopir);
        }

        Sopir::firstOrCreate(
            ['nama' => 'Puji'],
            [
                'no_hp' => '085263008933',
                'alamat' => 'Nagari Muaro',
            ]
        );
    }
}
