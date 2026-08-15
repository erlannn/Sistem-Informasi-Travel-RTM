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
        'name' => 'Test Penumpang',
        'email' => 'penumpang_time_test@gmail.com',
        'password' => bcrypt('password'),
    ]);
    $this->passengerUser->assignRole('Penumpang');

    $this->penumpang = Penumpang::create([
        'nama' => 'Test Penumpang',
        'email' => 'penumpang_time_test@gmail.com',
        'no_hp' => '081234567890',
        'alamat' => 'Padang',
        'password' => bcrypt('password'),
    ]);

    $this->sopir = Sopir::create([
        'nama' => 'Driver Test',
        'no_hp' => '081122334455',
        'alamat' => 'Solok',
    ]);

    $this->armada = Armada::create([
        'merk' => 'Toyota HiAce Premio',
        'warna' => 'White',
        'status' => 'Aktif',
    ]);
});

test('past schedule today is recognized as isPast', function () {
    $pastJadwal = Jadwal::create([
        'id_armada' => $this->armada->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->toDateString(),
        'jam' => '05:00:00', // 5 AM today
        'harga' => 50000.00,
    ]);

    // Freeze time to 1 PM today
    $today1PM = \Carbon\Carbon::parse(now()->toDateString() . ' 13:00:00');
    \Carbon\Carbon::setTestNow($today1PM);

    expect($pastJadwal->isPast())->toBeTrue();

    \Carbon\Carbon::setTestNow(); // reset
});

test('future schedule today is not past', function () {
    // Freeze time to 1 PM today
    $today1PM = \Carbon\Carbon::parse(now()->toDateString() . ' 13:00:00');
    \Carbon\Carbon::setTestNow($today1PM);

    $futureJadwal = Jadwal::create([
        'id_armada' => $this->armada->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->toDateString(),
        'jam' => '17:00:00', // 5 PM today
        'harga' => 50000.00,
    ]);

    expect($futureJadwal->isPast())->toBeFalse();

    \Carbon\Carbon::setTestNow(); // reset
});

test('passenger cannot search or see 5 AM schedule when current time is 1 PM today', function () {
    // Freeze time to 1 PM today
    $today1PM = \Carbon\Carbon::parse(now()->toDateString() . ' 13:00:00');
    \Carbon\Carbon::setTestNow($today1PM);

    $pastJadwal = Jadwal::create([
        'id_armada' => $this->armada->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->toDateString(),
        'jam' => '05:00:00', // 5 AM today
        'harga' => 50000.00,
    ]);

    $futureJadwal = Jadwal::create([
        'id_armada' => $this->armada->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->toDateString(),
        'jam' => '17:00:00', // 5 PM today
        'harga' => 50000.00,
    ]);

    $response = actingAs($this->passengerUser)->get(route('penumpang.jadwal', ['tanggal' => now()->toDateString()]));

    $response->assertStatus(200);
    $response->assertSee('17.00'); // 5 PM should be visible
    $response->assertDontSee('05.00'); // 5 AM should NOT be visible

    \Carbon\Carbon::setTestNow(); // reset
});

test('passenger cannot select seat or book a past schedule today', function () {
    // Freeze time to 1 PM today
    $today1PM = \Carbon\Carbon::parse(now()->toDateString() . ' 13:00:00');
    \Carbon\Carbon::setTestNow($today1PM);

    $pastJadwal = Jadwal::create([
        'id_armada' => $this->armada->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->toDateString(),
        'jam' => '05:00:00', // 5 AM today
        'harga' => 50000.00,
    ]);

    $kursi = Kursi::create([
        'id_jadwal' => $pastJadwal->id_jadwal,
        'nomor_kursi' => '1',
        'status' => 'Kosong',
    ]);

    // Try to access pilih kursi
    $responsePilih = actingAs($this->passengerUser)->get(route('penumpang.pilih_kursi', $pastJadwal->id_jadwal));
    $responsePilih->assertRedirect(route('penumpang.jadwal'));
    $responsePilih->assertSessionHas('error');

    // Try to store booking for past schedule
    $responseStore = actingAs($this->passengerUser)->post(route('penumpang.konfirmasi.store'), [
        'id_jadwal' => $pastJadwal->id_jadwal,
        'id_kursi' => [$kursi->id_kursi],
    ]);
    $responseStore->assertRedirect(route('penumpang.jadwal'));
    $responseStore->assertSessionHas('error');

    // Verify no booking was created
    expect(Pemesanan::where('id_jadwal', $pastJadwal->id_jadwal)->count())->toBe(0);

    \Carbon\Carbon::setTestNow(); // reset
});
