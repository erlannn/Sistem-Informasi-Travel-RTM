<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@rtmtravel.com'],
            [
                'nama' => 'Administrator CV RTM',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
