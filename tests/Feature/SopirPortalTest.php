<?php

use App\Models\User;
use App\Models\Armada;
use App\Models\Sopir;
use App\Models\Penumpang;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Pemesanan;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Sopir']);

    // Create Driver User
    $this->driverUser = User::create([
        'name' => 'Agus Setiawan',
        'email' => 'agus@rtmtravel.com',
        'password' => Hash::make('password123'),
    ]);
    $this->driverUser->assignRole('Sopir');

    // Create Driver Profile
    $this->sopir = Sopir::create([
        'nama' => 'Agus Setiawan',
        'no_hp' => '082111222333',
        'alamat' => 'Jl. Pemuda No. 8, Jakarta',
        'gaji' => 4500000.00,
    ]);

    // Create Armada
    $this->armada = Armada::create([
        'merk' => 'Toyota HiAce Premio',
        'warna' => 'Silver',
        'status' => 'Aktif',
    ]);

    // Create Schedule
    $this->jadwal = Jadwal::create([
        'id_armada' => $this->armada->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->toDateString(),
        'jam' => '08:00:00',
        'harga' => 75000.00,
    ]);

    // Create Seat
    $this->kursi = Kursi::create([
        'id_jadwal' => $this->jadwal->id_jadwal,
        'nomor_kursi' => '1',
        'status' => 'Terisi',
    ]);

    // Create Passenger
    $this->penumpang = Penumpang::create([
        'nama' => 'Budi Santoso',
        'email' => 'budi@gmail.com',
        'password' => Hash::make('password123'),
        'no_hp' => '081299998888',
        'alamat' => 'Padang',
    ]);

    // Create Booking
    $this->pemesanan = Pemesanan::create([
        'id_penumpang' => $this->penumpang->id_penumpang,
        'id_jadwal' => $this->jadwal->id_jadwal,
        'id_kursi' => $this->kursi->id_kursi,
        'tanggal_pesan' => now()->toDateString(),
        'jumlah_penumpang' => 1,
        'status' => 'Lunas',
    ]);
});

test('driver can access dashboard and view statistics', function () {
    $response = $this->actingAs($this->driverUser)->get(route('sopir.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Agus Setiawan');
    $response->assertSee('Rp 4.500.000');
});

test('driver can view their assigned schedules', function () {
    $response = $this->actingAs($this->driverUser)->get(route('sopir.jadwal'));
    $response->assertStatus(200);
    $response->assertSee('Sijunjung');
    $response->assertSee('Padang');
});

test('driver can view details of a specific schedule', function () {
    $response = $this->actingAs($this->driverUser)->get(route('sopir.jadwal.detail', $this->jadwal->id_jadwal));
    $response->assertStatus(200);
    $response->assertSee('Sijunjung');
    $response->assertSee('Padang');
    $response->assertSee('Selesaikan Perjalanan');
});

test('driver can view manifest of a specific schedule', function () {
    $response = $this->actingAs($this->driverUser)->get(route('sopir.jadwal.penumpang', $this->jadwal->id_jadwal));
    $response->assertStatus(200);
    $response->assertSee('Budi Santoso');
    $response->assertSee('081299998888');
    $response->assertSee('KURSI');
});

test('driver can view global manifest', function () {
    $response = $this->actingAs($this->driverUser)->get(route('sopir.penumpang'));
    $response->assertStatus(200);
    $response->assertSee('Budi Santoso');
    $response->assertSee('Sijunjung');
});

test('driver can complete trip and check updated status and salary', function () {
    // 1. Post request to complete trip
    $response = $this->actingAs($this->driverUser)->post(route('sopir.jadwal.selesaikan', $this->jadwal->id_jadwal));
    $response->assertRedirect(route('sopir.jadwal.detail', $this->jadwal->id_jadwal));
    
    // 2. Assert booking is completed and seat is freed
    $this->assertDatabaseHas('pemesanans', [
        'id_pemesanan' => $this->pemesanan->id_pemesanan,
        'status' => 'Selesai',
    ]);
    
    $this->assertDatabaseHas('kursis', [
        'id_kursi' => $this->kursi->id_kursi,
        'status' => 'Tersedia',
    ]);

    // 3. Check Gaji slip reflects updated statistics
    $gajiResponse = $this->actingAs($this->driverUser)->get(route('sopir.gaji'));
    $gajiResponse->assertStatus(200);
    // Total Penumpang = 1, komisi = Rp 50.000, Gaji Pokok = Rp 4.500.000, Total Gaji = Rp 4.550.000
    $gajiResponse->assertSee('Rp 4.550.000');
    // Cash collected directly: 1 Passenger * Rp 75.000 ticket price = Rp 75.000
    $gajiResponse->assertSee('Rp 75.000');
});
