<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Penumpang;
use App\Models\Sopir;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create Permissions
        $permissions = [
            // Admin permissions (CRUD on all tables)
            'manage_admins',
            'manage_penumpangs',
            'manage_sopirs',
            'manage_armadas',
            'manage_jadwals',
            'manage_kursis',
            'manage_pemesanans',
            'view_reports',

            // Penumpang permissions
            'view_jadwals',
            'create_pemesanan',
            'view_own_pemesanan',
            'cancel_own_pemesanan',

            // Sopir permissions
            'view_assigned_jadwal',
            'view_passenger_list',
            'view_own_salary',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 2. Create Roles & Give Permissions
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleAdmin->syncPermissions($permissions); // Admin gets all permissions

        $rolePenumpang = Role::firstOrCreate(['name' => 'Penumpang']);
        $rolePenumpang->syncPermissions([
            'view_jadwals',
            'create_pemesanan',
            'view_own_pemesanan',
            'cancel_own_pemesanan',
        ]);

        $roleSopir = Role::firstOrCreate(['name' => 'Sopir']);
        $roleSopir->syncPermissions([
            'view_assigned_jadwal',
            'view_passenger_list',
            'view_own_salary',
        ]);

        // 3. Create Default Admin User
        $userAdmin = User::firstOrCreate(
            ['email' => 'admin@rtmtravel.com'],
            [
                'name' => 'Administrator CV RTM',
                'password' => Hash::make('password123'),
            ]
        );
        $userAdmin->assignRole($roleAdmin);

        // 4. Create Default Penumpang Users
        $userPenumpang1 = User::firstOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
            ]
        );
        $userPenumpang1->assignRole($rolePenumpang);

        $userPenumpang2 = User::firstOrCreate(
            ['email' => 'siti@gmail.com'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password123'),
            ]
        );
        $userPenumpang2->assignRole($rolePenumpang);

        // 5. Create Default Sopir Users
        $userSopir1 = User::firstOrCreate(
            ['email' => 'agus@rtmtravel.com'],
            [
                'name' => 'Agus Setiawan',
                'password' => Hash::make('password123'),
            ]
        );
        $userSopir1->assignRole($roleSopir);

        $userSopir2 = User::firstOrCreate(
            ['email' => 'joko@rtmtravel.com'],
            [
                'name' => 'Joko Widodo',
                'password' => Hash::make('password123'),
            ]
        );
        $userSopir2->assignRole($roleSopir);
    }
}
