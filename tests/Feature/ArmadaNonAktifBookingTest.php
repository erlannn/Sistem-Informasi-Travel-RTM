<?php

use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Pemesanan;
use App\Models\Penumpang;
use App\Models\Sopir;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use function Pest\Laravel\actingAs;

uses(DatabaseTransactions::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Penumpang']);

    $this->passengerUser = User::create([
        'name' => 'Test Penumpang Armada',
        'email' => 'penumpang_armada_test@gmail.com',
        'password' => bcrypt('password'),
    ]);
    $this->passengerUser->assignRole('Penumpang');

    $this->penumpang = Penumpang::create([
        'nama' => 'Test Penumpang Armada',
        'email' => 'penumpang_armada_test@gmail.com',
        'no_hp' => '081234567899',
        'alamat' => 'Padang',
        'password' => bcrypt('password'),
    ]);

    $this->sopir = Sopir::create([
        'nama' => 'Driver Active',
        'no_hp' => '081122334466',
        'alamat' => 'Solok',
        'status' => 'Aktif',
    ]);

    $this->inactiveArmada = Armada::create([
        'merk' => 'Kijang Innova Reborn Inactive',
        'warna' => 'Hitam',
        'status' => 'Non-Aktif',
    ]);

    $this->activeArmada = Armada::create([
        'merk' => 'Toyota HiAce Active',
        'warna' => 'Putih',
        'status' => 'Aktif',
    ]);
});

test('passenger cannot see schedule with non-active armada in search list', function () {
    $inactiveJadwal = Jadwal::create([
        'id_armada' => $this->inactiveArmada->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->addDays(2)->toDateString(),
        'jam' => '08:00:00',
        'harga' => 80000.00,
    ]);

    $activeJadwal = Jadwal::create([
        'id_armada' => $this->activeArmada->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->addDays(2)->toDateString(),
        'jam' => '10:00:00',
        'harga' => 80000.00,
    ]);

    $response = actingAs($this->passengerUser)->get(route('penumpang.jadwal'));

    $response->assertStatus(200);
    $response->assertDontSee('Kijang Innova Reborn Inactive');
    $response->assertSee('Toyota HiAce Active');
});

test('passenger cannot book seat for schedule with non-active armada', function () {
    $inactiveJadwal = Jadwal::create([
        'id_armada' => $this->inactiveArmada->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->addDays(2)->toDateString(),
        'jam' => '08:00:00',
        'harga' => 80000.00,
    ]);

    $kursi = Kursi::create([
        'id_jadwal' => $inactiveJadwal->id_jadwal,
        'nomor_kursi' => '1',
        'status' => 'Tersedia',
    ]);

    // Try selecting seat for non-active armada schedule
    $responsePilih = actingAs($this->passengerUser)->get(route('penumpang.pilih_kursi', $inactiveJadwal->id_jadwal));
    $responsePilih->assertRedirect(route('penumpang.jadwal'));
    $responsePilih->assertSessionHas('error');

    // Try booking non-active armada schedule
    $responseStore = actingAs($this->passengerUser)->post(route('penumpang.konfirmasi.store'), [
        'id_jadwal' => $inactiveJadwal->id_jadwal,
        'id_kursi' => [$kursi->id_kursi],
    ]);
    $responseStore->assertRedirect(route('penumpang.jadwal'));
    $responseStore->assertSessionHas('error');

    expect(Pemesanan::where('id_jadwal', $inactiveJadwal->id_jadwal)->count())->toBe(0);
});
