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
    Role::firstOrCreate(['name' => 'Admin']);
    Role::firstOrCreate(['name' => 'Sopir']);
    Role::firstOrCreate(['name' => 'Penumpang']);

    $this->admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admin@rtm.com',
        'password' => Hash::make('password123'),
    ]);
    $this->admin->assignRole('Admin');
});

test('admin can perform full CRUD on armada', function () {
    // 1. Create (Store)
    $response = $this->actingAs($this->admin)->post(route('admin.armada.store'), [
        'merk' => 'Toyota HiAce Premio Test',
        'warna' => 'Hitam',
        'status' => 'Aktif',
    ]);
    $response->assertRedirect(route('admin.armada.index'));
    $this->assertDatabaseHas('armadas', ['merk' => 'Toyota HiAce Premio Test']);

    $armada = Armada::where('merk', 'Toyota HiAce Premio Test')->first();

    // 2. Update
    $response = $this->actingAs($this->admin)->put(route('admin.armada.update', $armada->id_armada), [
        'merk' => 'Toyota HiAce Premio Updated',
        'warna' => 'Putih',
        'status' => 'Perbaikan',
    ]);
    $response->assertRedirect(route('admin.armada.index'));
    $this->assertDatabaseHas('armadas', ['id_armada' => $armada->id_armada, 'merk' => 'Toyota HiAce Premio Updated']);

    // 3. Delete (Destroy)
    $response = $this->actingAs($this->admin)->delete(route('admin.armada.destroy', $armada->id_armada));
    $response->assertRedirect(route('admin.armada.index'));
    $this->assertDatabaseMissing('armadas', ['id_armada' => $armada->id_armada]);
});

test('admin can perform full CRUD on sopir', function () {
    // 1. Create
    $response = $this->actingAs($this->admin)->post(route('admin.sopir.store'), [
        'nama' => 'Pak Joko Driver Test',
        'no_hp' => '081234567890',
        'alamat' => 'Sijunjung',
        'gaji' => 3000000,
    ]);
    $response->assertRedirect(route('admin.sopir.index'));
    $this->assertDatabaseHas('sopirs', ['nama' => 'Pak Joko Driver Test']);

    $sopir = Sopir::where('nama', 'Pak Joko Driver Test')->first();

    // 2. Update
    $response = $this->actingAs($this->admin)->put(route('admin.sopir.update', $sopir->id_sopir), [
        'nama' => 'Pak Joko Driver Updated',
        'no_hp' => '081299998888',
        'alamat' => 'Padang',
        'gaji' => 3500000,
    ]);
    $response->assertRedirect(route('admin.sopir.index'));
    $this->assertDatabaseHas('sopirs', ['id_sopir' => $sopir->id_sopir, 'nama' => 'Pak Joko Driver Updated']);

    // 3. Delete
    $response = $this->actingAs($this->admin)->delete(route('admin.sopir.destroy', $sopir->id_sopir));
    $response->assertRedirect(route('admin.sopir.index'));
    $this->assertDatabaseMissing('sopirs', ['id_sopir' => $sopir->id_sopir]);
});

test('admin can perform full CRUD on penumpang', function () {
    // 1. Create
    $response = $this->actingAs($this->admin)->post(route('admin.penumpang.store'), [
        'nama' => 'Budi Penumpang Test',
        'email' => 'budi_test@gmail.com',
        'no_hp' => '081122334455',
        'alamat' => 'Jl. Merdeka Sijunjung',
        'password' => 'secret123',
    ]);
    $response->assertRedirect(route('admin.penumpang.index'));
    $this->assertDatabaseHas('penumpangs', ['email' => 'budi_test@gmail.com']);
    $this->assertDatabaseHas('users', ['email' => 'budi_test@gmail.com']);

    $penumpang = Penumpang::where('email', 'budi_test@gmail.com')->first();

    // 2. Update
    $response = $this->actingAs($this->admin)->put(route('admin.penumpang.update', $penumpang->id_penumpang), [
        'nama' => 'Budi Penumpang Updated',
        'email' => 'budi_test@gmail.com', // keep same email
        'no_hp' => '081122339999',
        'alamat' => 'Jl. Sudirman Padang',
        'password' => '', // empty password
    ]);
    $response->assertRedirect(route('admin.penumpang.index'));
    $this->assertDatabaseHas('penumpangs', ['id_penumpang' => $penumpang->id_penumpang, 'nama' => 'Budi Penumpang Updated']);

    // 3. Delete
    $response = $this->actingAs($this->admin)->delete(route('admin.penumpang.destroy', $penumpang->id_penumpang));
    $response->assertRedirect(route('admin.penumpang.index'));
    $this->assertDatabaseMissing('penumpangs', ['id_penumpang' => $penumpang->id_penumpang]);
    $this->assertDatabaseMissing('users', ['email' => 'budi_test@gmail.com']);
});

test('admin can perform full CRUD on jadwal and pemesanan', function () {
    $armada = Armada::create(['merk' => 'Toyota HiAce', 'warna' => 'Silver', 'status' => 'Aktif']);
    $sopir = Sopir::create(['nama' => 'Pak Budi', 'no_hp' => '081234567890', 'alamat' => 'Padang', 'gaji' => 2500000]);
    $penumpang = Penumpang::create(['nama' => 'Siti', 'email' => 'siti@test.com', 'password' => Hash::make('secret'), 'no_hp' => '0812999', 'alamat' => 'Padang']);

    // 1. Store Jadwal
    $response = $this->actingAs($this->admin)->post(route('admin.jadwal.store'), [
        'id_armada' => $armada->id_armada,
        'id_sopir' => $sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->addDays(2)->toDateString(),
        'jam' => '08:00',
        'harga' => 120000,
    ]);
    $response->assertRedirect(route('admin.jadwal.index'));
    $this->assertDatabaseHas('jadwals', ['asal' => 'Sijunjung', 'tujuan' => 'Padang']);

    $jadwal = Jadwal::where('asal', 'Sijunjung')->first();
    $this->assertCount(6, Kursi::where('id_jadwal', $jadwal->id_jadwal)->get());

    $kursi = Kursi::where('id_jadwal', $jadwal->id_jadwal)->first();

    // 2. Store Pemesanan
    $response = $this->actingAs($this->admin)->post(route('admin.pemesanan.store'), [
        'id_penumpang' => $penumpang->id_penumpang,
        'id_jadwal' => $jadwal->id_jadwal,
        'id_kursi' => $kursi->id_kursi,
        'status' => 'Lunas',
    ]);
    $response->assertRedirect(route('admin.pemesanan.index'));
    $this->assertDatabaseHas('pemesanans', ['id_penumpang' => $penumpang->id_penumpang, 'id_kursi' => $kursi->id_kursi]);
    $this->assertEquals('Terisi', $kursi->fresh()->status);

    $pemesanan = Pemesanan::where('id_penumpang', $penumpang->id_penumpang)->first();

    // 3. Update Pemesanan
    $response = $this->actingAs($this->admin)->put(route('admin.pemesanan.update', $pemesanan->id_pemesanan), [
        'id_penumpang' => $penumpang->id_penumpang,
        'id_jadwal' => $jadwal->id_jadwal,
        'id_kursi' => $kursi->id_kursi,
        'status' => 'Batal',
    ]);
    $response->assertRedirect(route('admin.pemesanan.index'));
    $this->assertDatabaseHas('pemesanans', ['id_pemesanan' => $pemesanan->id_pemesanan, 'status' => 'Batal']);
    $this->assertEquals('Tersedia', $kursi->fresh()->status);

    // 4. Delete Pemesanan
    $response = $this->actingAs($this->admin)->delete(route('admin.pemesanan.destroy', $pemesanan->id_pemesanan));
    $response->assertRedirect(route('admin.pemesanan.index'));
    $this->assertDatabaseMissing('pemesanans', ['id_pemesanan' => $pemesanan->id_pemesanan]);

    // 5. Update Jadwal
    $response = $this->actingAs($this->admin)->put(route('admin.jadwal.update', $jadwal->id_jadwal), [
        'id_armada' => $armada->id_armada,
        'id_sopir' => $sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Bukittinggi',
        'tanggal' => now()->addDays(3)->toDateString(),
        'jam' => '10:00',
        'harga' => 130000,
    ]);
    $response->assertRedirect(route('admin.jadwal.index'));
    $this->assertDatabaseHas('jadwals', ['id_jadwal' => $jadwal->id_jadwal, 'tujuan' => 'Bukittinggi']);

    // 6. Delete Jadwal
    $response = $this->actingAs($this->admin)->delete(route('admin.jadwal.destroy', $jadwal->id_jadwal));
    $response->assertRedirect(route('admin.jadwal.index'));
    $this->assertDatabaseMissing('jadwals', ['id_jadwal' => $jadwal->id_jadwal]);
});
