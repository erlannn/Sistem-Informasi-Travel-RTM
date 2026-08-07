<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);

        $userAdmin = User::firstOrCreate(
            ['email' => 'admin@rtmtravel.com'],
            [
                'name' => 'Administrator CV RTM',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$userAdmin->hasRole('Admin')) {
            $userAdmin->assignRole($roleAdmin);
        }

        Admin::firstOrCreate(
            ['email' => 'admin@rtmtravel.com'],
            [
                'nama' => 'Administrator CV RTM',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
