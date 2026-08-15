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

    // Admin user
    $this->adminUser = User::create([
        'name' => 'Admin Travel',
        'email' => 'admin@rtm.com',
        'password' => Hash::make('password123'),
    ]);
    $this->adminUser->assignRole('Admin');

    // Driver user & profile
    $this->driverUser = User::create([
        'name' => 'Pak Joko Driver',
        'email' => 'joko@rtmtravel.com',
        'password' => Hash::make('password123'),
    ]);
    $this->driverUser->assignRole('Sopir');

    $this->sopir = Sopir::create([
        'nama' => 'Pak Joko Driver',
        'no_hp' => '081234567890',
        'alamat' => 'Sijunjung',
        'gaji' => 3000000.00,
    ]);

    // Passenger user & profile
    $this->passengerUser = User::create([
        'name' => 'Siti Penumpang',
        'email' => 'siti@gmail.com',
        'password' => Hash::make('password123'),
    ]);
    $this->passengerUser->assignRole('Penumpang');

    $this->penumpang = Penumpang::create([
        'nama' => 'Siti Penumpang',
        'email' => 'siti@gmail.com',
        'password' => Hash::make('password123'),
        'no_hp' => '081299998888',
        'alamat' => 'Padang',
    ]);

    // Armada & Schedule
    $this->armada = Armada::create([
        'merk' => 'Toyota HiAce Premio',
        'warna' => 'Silver',
        'status' => 'Aktif',
    ]);

    $this->jadwal = Jadwal::create([
        'id_armada' => $this->armada->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->addDays(1)->toDateString(),
        'jam' => '08:00:00',
        'harga' => 100000.00,
    ]);

    $this->kursi = Kursi::create([
        'id_jadwal' => $this->jadwal->id_jadwal,
        'nomor_kursi' => '1A',
        'status' => 'Kosong',
    ]);
});

test('full 4-stage post-paid cash workflow execution', function () {
    // TAHAP 1: Pemesanan Tiket Online oleh Penumpang
    $responseBooking = $this->actingAs($this->passengerUser)->post(route('penumpang.konfirmasi.store'), [
        'id_jadwal' => $this->jadwal->id_jadwal,
        'id_kursi' => $this->kursi->id_kursi,
    ]);

    $pemesanan = Pemesanan::latest('id_pemesanan')->first();
    expect($pemesanan)->not->toBeNull();
    expect($pemesanan->status_perjalanan)->toBe('Pending');
    expect($pemesanan->status_pembayaran)->toBe('Belum Bayar');
    expect((float)$pemesanan->total_bayar)->toBe(100000.00);
    expect($pemesanan->metode_pembayaran)->toBe('Cash');
    expect($pemesanan->is_setor_admin)->toBeFalse();
    expect($this->kursi->fresh()->status)->toBe('Terisi');

    // TAHAP 2: Penjemputan / Boarding oleh Supir (Naikkan Penumpang)
    $responseNaik = $this->actingAs($this->driverUser)->post(route('sopir.pemesanan.naik', $pemesanan->id_pemesanan));
    $responseNaik->assertRedirect();

    $pemesanan->refresh();
    expect($pemesanan->status_perjalanan)->toBe('Naik');
    expect($pemesanan->status_pembayaran)->toBe('Belum Bayar');

    // TAHAP 3: Tiba di Tujuan & Terima Uang Cash oleh Supir
    $responseCash = $this->actingAs($this->driverUser)->post(route('sopir.pemesanan.terima_cash', $pemesanan->id_pemesanan));
    $responseCash->assertRedirect();

    $pemesanan->refresh();
    expect($pemesanan->status_perjalanan)->toBe('Selesai');
    expect($pemesanan->status_pembayaran)->toBe('Lunas');
    expect($pemesanan->waktu_bayar)->not->toBeNull();
    expect($pemesanan->is_setor_admin)->toBeFalse();
    expect($this->kursi->fresh()->status)->toBe('Kosong');

    // TAHAP 4: Admin Rekonsiliasi & Verifikasi Setoran Uang Fisik dari Supir
    $responseSetoranView = $this->actingAs($this->adminUser)->get(route('admin.setoran.index'));
    $responseSetoranView->assertStatus(200);
    $responseSetoranView->assertSee('Rp 100.000');

    $responseVerifikasi = $this->actingAs($this->adminUser)->post(route('admin.setoran.verifikasi', $this->jadwal->id_jadwal));
    $responseVerifikasi->assertRedirect();

    $pemesanan->refresh();
    expect($pemesanan->is_setor_admin)->toBeTrue();
    expect($pemesanan->tanggal_setor)->not->toBeNull();
});

test('driver can handle passenger cancellation and free up seat', function () {
    $pemesanan = Pemesanan::create([
        'id_penumpang' => $this->penumpang->id_penumpang,
        'id_jadwal' => $this->jadwal->id_jadwal,
        'id_kursi' => $this->kursi->id_kursi,
        'tanggal_pesan' => now()->toDateString(),
        'jumlah_penumpang' => 1,
        'total_bayar' => 100000.00,
        'metode_pembayaran' => 'Cash',
        'status_pembayaran' => 'Belum Bayar',
        'status_perjalanan' => 'Pending',
    ]);
    $this->kursi->update(['status' => 'Terisi']);

    $responseCancel = $this->actingAs($this->driverUser)->post(route('sopir.pemesanan.batal', $pemesanan->id_pemesanan));
    $responseCancel->assertRedirect();

    $pemesanan->refresh();
    expect($pemesanan->status_perjalanan)->toBe('Batal');
    expect($this->kursi->fresh()->status)->toBe('Kosong');
});
