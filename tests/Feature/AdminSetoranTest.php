<?php

use App\Models\User;
use App\Models\Armada;
use App\Models\Sopir;
use App\Models\Jadwal;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use function Pest\Laravel\actingAs;

uses(DatabaseTransactions::class);

function getAdminUserForSetoranTest(): User
{
    Role::firstOrCreate(['name' => 'Admin']);

    /** @var User $admin */
    $admin = User::create([
        'name' => 'Admin Setoran',
        'email' => 'admin_setoran_' . uniqid() . '@rtm.com',
        'password' => Hash::make('password123'),
    ]);
    $admin->assignRole('Admin');

    return $admin;
}

test('admin setoran index page renders with paginated data', function () {
    $admin = getAdminUserForSetoranTest();

    $armada = Armada::create([
        'merk' => 'Innova Reborn Setoran',
        'warna' => 'Hitam',
        'kursi' => 7,
        'status' => 'Aktif'
    ]);
    $sopirUser = User::create([
        'name' => 'Sopir Setoran',
        'email' => 'sopir_setoran_' . uniqid() . '@rtm.com',
        'password' => Hash::make('password')
    ]);
    $sopir = Sopir::create([
        'id_user' => $sopirUser->id,
        'nama' => 'Sopir Setoran',
        'no_hp' => '081234567890',
        'alamat' => 'Padang'
    ]);

    // Create 15 Jadwal items to test pagination (10 per page)
    for ($i = 1; $i <= 15; $i++) {
        Jadwal::create([
            'asal' => 'Padang',
            'tujuan' => 'Sijunjung',
            'tanggal' => now()->addDays($i)->format('Y-m-d'),
            'jam' => '08:00',
            'harga' => 80000,
            'id_armada' => $armada->id_armada,
            'id_sopir' => $sopir->id_sopir,
            'bagi_hasil_sopir' => 15000,
        ]);
    }

    $response = actingAs($admin)->get(route('admin.setoran.index'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.setoran.index');
    $response->assertViewHas('rekapJadwal');
    $response->assertSee('Cetak Laporan PDF');

    $rekapJadwal = $response->viewData('rekapJadwal');
    expect($rekapJadwal->count())->toBe(10);
    expect($rekapJadwal->total())->toBeGreaterThanOrEqual(15);
});

test('admin setoran pdf report route renders clean spatie pdf output', function () {
    $admin = getAdminUserForSetoranTest();

    $response = actingAs($admin)->get(route('admin.setoran.pdf'));

    $response->assertStatus(200);
});
