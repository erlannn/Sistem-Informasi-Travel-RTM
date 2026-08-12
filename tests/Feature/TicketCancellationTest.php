<?php

use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Pemesanan;
use App\Models\Penumpang;
use App\Models\Sopir;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

function createTestCancellationFixture(): object
{
    Role::firstOrCreate(['name' => 'Penumpang']);
    Role::firstOrCreate(['name' => 'Admin']);

    $email = 'penumpang_batal_' . uniqid() . '@gmail.com';

    /** @var User $user */
    $user = User::create([
        'name' => 'Test Penumpang Batal',
        'email' => $email,
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('Penumpang');

    /** @var Penumpang $penumpang */
    $penumpang = Penumpang::create([
        'nama' => 'Test Penumpang Batal',
        'email' => $email,
        'no_hp' => '081234567899',
        'alamat' => 'Sijunjung',
        'password' => bcrypt('password'),
    ]);

    /** @var Sopir $sopir */
    $sopir = Sopir::create([
        'nama' => 'Pak Supir Aktif',
        'no_hp' => '081122334455',
        'alamat' => 'Padang',
        'status' => 'Aktif',
    ]);

    /** @var Armada $armada */
    $armada = Armada::create([
        'merk' => 'Toyota Avanza',
        'warna' => 'Hitam',
        'kursi' => 6,
        'status' => 'Aktif',
    ]);

    /** @var Jadwal $jadwal */
    $jadwal = Jadwal::create([
        'id_armada' => $armada->id_armada,
        'id_sopir' => $sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->addDays(2)->toDateString(),
        'jam' => '08.00',
        'harga' => 80000.00,
        'bagi_hasil_sopir' => 30000.00,
    ]);

    /** @var Kursi $kursi */
    $kursi = Kursi::create([
        'id_jadwal' => $jadwal->id_jadwal,
        'nomor_kursi' => '1',
        'status' => 'Terisi',
    ]);

    /** @var Pemesanan $pemesanan */
    $pemesanan = Pemesanan::create([
        'id_penumpang' => $penumpang->id_penumpang,
        'id_jadwal' => $jadwal->id_jadwal,
        'id_kursi' => $kursi->id_kursi,
        'tanggal_pesan' => now()->toDateString(),
        'jumlah_penumpang' => 1,
        'total_bayar' => 80000.00,
        'metode_pembayaran' => 'Cash',
        'status_pembayaran' => 'Belum Bayar',
        'status_perjalanan' => 'Pending',
    ]);

    return (object) compact('user', 'penumpang', 'sopir', 'armada', 'jadwal', 'kursi', 'pemesanan');
}

test('passenger can cancel pending ticket and release seat', function () {
    $f = createTestCancellationFixture();

    $response = actingAs($f->user)
        ->post(route('penumpang.status.batal', $f->pemesanan->id_pemesanan));

    $response->assertRedirect(route('penumpang.status'));

    assertDatabaseHas('pemesanans', [
        'id_pemesanan' => $f->pemesanan->id_pemesanan,
        'status_perjalanan' => 'Batal',
    ]);

    assertDatabaseHas('kursis', [
        'id_kursi' => $f->kursi->id_kursi,
        'status' => 'Kosong',
    ]);
});

test('driver name remains intact after driver deactivation', function () {
    $f = createTestCancellationFixture();

    // Soft-deactivate driver
    $f->sopir->update(['status' => 'Tidak Aktif']);

    $response = actingAs($f->user)
        ->get(route('penumpang.status.detail', $f->pemesanan->id_pemesanan));

    $response->assertStatus(200);
    $response->assertSee('Pak Supir Aktif');
});
