<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Admin']);
    Role::firstOrCreate(['name' => 'Sopir']);
    Role::firstOrCreate(['name' => 'Penumpang']);
});

test('admin user can login and access admin dashboard', function () {
    $admin = User::create([
        'name' => 'Test Admin',
        'email' => 'admin_test@rtmtravel.com',
        'password' => Hash::make('password123'),
    ]);
    $admin->assignRole('Admin');

    $response = $this->post('/login', [
        'email' => 'admin_test@rtmtravel.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/admin/dashboard');
    $this->assertAuthenticatedAs($admin);
});

test('sopir user can login and access sopir dashboard', function () {
    $sopir = User::create([
        'name' => 'Test Sopir',
        'email' => 'sopir_test@rtmtravel.com',
        'password' => Hash::make('password123'),
    ]);
    $sopir->assignRole('Sopir');

    $response = $this->post('/login', [
        'email' => 'sopir_test@rtmtravel.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/sopir/dashboard');
    $this->assertAuthenticatedAs($sopir);
});

test('penumpang user can login and access penumpang dashboard', function () {
    $penumpang = User::create([
        'name' => 'Test Penumpang',
        'email' => 'penumpang_test@rtmtravel.com',
        'password' => Hash::make('password123'),
    ]);
    $penumpang->assignRole('Penumpang');

    $response = $this->post('/login', [
        'email' => 'penumpang_test@rtmtravel.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/penumpang/dashboard');
    $this->assertAuthenticatedAs($penumpang);
});
