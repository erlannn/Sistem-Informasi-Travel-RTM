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

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

function createAdminUser(): User
{
    Role::firstOrCreate(['name' => 'Admin']);
    Role::firstOrCreate(['name' => 'Sopir']);
    Role::firstOrCreate(['name' => 'Penumpang']);

    /** @var User $admin */
    $admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admin_' . uniqid() . '@rtm.com',
        'password' => Hash::make('password123'),
    ]);
    $admin->assignRole('Admin');

    return $admin;
}

test('admin can perform full CRUD on armada', function () {
    $admin = createAdminUser();

    // 1. Create (Store)
    $response = actingAs($admin)->post(route('admin.armada.store'), [
        'merk' => 'Toyota HiAce Premio Test',
        'warna' => 'Hitam',
        'kursi' => 6,
        'status' => 'Aktif',
    ]);
    $response->assertRedirect(route('admin.armada.index'));
    assertDatabaseHas('armadas', ['merk' => 'Toyota HiAce Premio Test', 'kursi' => 6]);

    /** @var Armada $armada */
    $armada = Armada::where('merk', '=', 'Toyota HiAce Premio Test', 'and')->first();

    // 2. Update
    $response = actingAs($admin)->put(route('admin.armada.update', $armada->id_armada), [
        'merk' => 'Toyota HiAce Premio Updated',
        'warna' => 'Putih',
        'kursi' => 8,
        'status' => 'Perbaikan',
    ]);
    $response->assertRedirect(route('admin.armada.index'));
    assertDatabaseHas('armadas', ['id_armada' => $armada->id_armada, 'merk' => 'Toyota HiAce Premio Updated', 'kursi' => 8]);

    // 3. Delete (Destroy)
    $response = actingAs($admin)->delete(route('admin.armada.destroy', $armada->id_armada));
    $response->assertRedirect(route('admin.armada.index'));
    assertDatabaseMissing('armadas', ['id_armada' => $armada->id_armada]);
});

test('admin can perform full CRUD on sopir', function () {
    $admin = createAdminUser();

    // 1. Create
    $response = actingAs($admin)->post(route('admin.sopir.store'), [
        'nama' => 'Pak Joko Driver Test',
        'no_hp' => '081234567890',
        'alamat' => 'Sijunjung',
    ]);
    $response->assertRedirect(route('admin.sopir.index'));
    assertDatabaseHas('sopirs', ['nama' => 'Pak Joko Driver Test']);

    /** @var Sopir $sopir */
    $sopir = Sopir::where('nama', '=', 'Pak Joko Driver Test', 'and')->first();

    // 2. Update
    $response = actingAs($admin)->put(route('admin.sopir.update', $sopir->id_sopir), [
        'nama' => 'Pak Joko Driver Updated',
        'no_hp' => '081299998888',
        'alamat' => 'Padang',
        'status' => 'Aktif',
    ]);
    $response->assertRedirect(route('admin.sopir.index'));
    assertDatabaseHas('sopirs', ['id_sopir' => $sopir->id_sopir, 'nama' => 'Pak Joko Driver Updated', 'status' => 'Aktif']);

    // 3. Deactivate (soft delete via destroy route)
    $response = actingAs($admin)->delete(route('admin.sopir.destroy', $sopir->id_sopir));
    $response->assertRedirect(route('admin.sopir.index'));
    assertDatabaseHas('sopirs', ['id_sopir' => $sopir->id_sopir, 'status' => 'Tidak Aktif']);
});

test('admin can perform full CRUD on penumpang', function () {
    $admin = createAdminUser();

    // 1. Create
    $response = actingAs($admin)->post(route('admin.penumpang.store'), [
        'nama' => 'Budi Penumpang Test',
        'email' => 'budi_test@gmail.com',
        'no_hp' => '081122334455',
        'alamat' => 'Jl. Merdeka Sijunjung',
        'password' => 'secret123',
    ]);
    $response->assertRedirect(route('admin.penumpang.index'));
    assertDatabaseHas('penumpangs', ['email' => 'budi_test@gmail.com']);
    assertDatabaseHas('users', ['email' => 'budi_test@gmail.com']);

    /** @var Penumpang $penumpang */
    $penumpang = Penumpang::where('email', '=', 'budi_test@gmail.com', 'and')->first();

    // 2. Update
    $response = actingAs($admin)->put(route('admin.penumpang.update', $penumpang->id_penumpang), [
        'nama' => 'Budi Penumpang Updated',
        'email' => 'budi_test@gmail.com', // keep same email
        'no_hp' => '081122339999',
        'alamat' => 'Jl. Sudirman Padang',
        'password' => '', // empty password
    ]);
    $response->assertRedirect(route('admin.penumpang.index'));
    assertDatabaseHas('penumpangs', ['id_penumpang' => $penumpang->id_penumpang, 'nama' => 'Budi Penumpang Updated']);

    // 3. Delete
    $response = actingAs($admin)->delete(route('admin.penumpang.destroy', $penumpang->id_penumpang));
    $response->assertRedirect(route('admin.penumpang.index'));
    assertDatabaseMissing('penumpangs', ['id_penumpang' => $penumpang->id_penumpang]);
    assertDatabaseMissing('users', ['email' => 'budi_test@gmail.com']);
});

test('admin can management jadwal and status/deletion of pemesanan', function () {
    $admin = createAdminUser();

    $armada = Armada::create(['merk' => 'Toyota HiAce', 'warna' => 'Silver', 'kursi' => 6, 'status' => 'Aktif']);
    $sopir = Sopir::create(['nama' => 'Pak Budi', 'no_hp' => '081234567890', 'alamat' => 'Padang']);
    $penumpang = Penumpang::create(['nama' => 'Siti', 'email' => 'siti@test.com', 'password' => Hash::make('secret'), 'no_hp' => '0812999', 'alamat' => 'Padang']);

    // 1. Store Jadwal
    $response = actingAs($admin)->post(route('admin.jadwal.store'), [
        'id_armada' => $armada->id_armada,
        'id_sopir' => $sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Padang',
        'tanggal' => now()->addDays(2)->toDateString(),
        'jam' => '08:00',
        'harga' => 120000,
        'bagi_hasil_sopir' => 30000,
    ]);
    $response->assertRedirect(route('admin.jadwal.index'));
    assertDatabaseHas('jadwals', ['asal' => 'Sijunjung', 'tujuan' => 'Padang']);

    /** @var Jadwal $jadwal */
    $jadwal = Jadwal::where('asal', '=', 'Sijunjung', 'and')->first();
    expect(Kursi::where('id_jadwal', '=', $jadwal->id_jadwal, 'and')->get())->toHaveCount(6);

    /** @var Kursi $kursi */
    $kursi = Kursi::where('id_jadwal', '=', $jadwal->id_jadwal, 'and')->first();

    // 2. Create Pemesanan (simulating booking created by Penumpang)
    /** @var Pemesanan $pemesanan */
    $pemesanan = Pemesanan::create([
        'id_penumpang' => $penumpang->id_penumpang,
        'id_jadwal' => $jadwal->id_jadwal,
        'id_kursi' => $kursi->id_kursi,
        'tanggal_pesan' => now()->toDateString(),
        'jumlah_penumpang' => 1,
        'total_bayar' => 120000,
        'status_pembayaran' => 'Belum Bayar',
        'status_perjalanan' => 'Pending',
    ]);
    $kursi->update(['status' => 'Terisi']);

    // 3. Update Status Pemesanan by Admin
    $response = actingAs($admin)->patch(route('admin.pemesanan.update_status', $pemesanan->id_pemesanan), [
        'status_perjalanan' => 'Selesai',
    ]);
    $response->assertRedirect(route('admin.pemesanan.index'));
    assertDatabaseHas('pemesanans', ['id_pemesanan' => $pemesanan->id_pemesanan, 'status_perjalanan' => 'Selesai', 'status_pembayaran' => 'Lunas']);

    // 4. Delete Pemesanan by Admin
    $response = actingAs($admin)->delete(route('admin.pemesanan.destroy', $pemesanan->id_pemesanan));
    $response->assertRedirect(route('admin.pemesanan.index'));
    assertDatabaseMissing('pemesanans', ['id_pemesanan' => $pemesanan->id_pemesanan]);

    // 5. Update Jadwal
    $response = actingAs($admin)->put(route('admin.jadwal.update', $jadwal->id_jadwal), [
        'id_armada' => $armada->id_armada,
        'id_sopir' => $sopir->id_sopir,
        'asal' => 'Sijunjung',
        'tujuan' => 'Solok',
        'tanggal' => now()->addDays(3)->toDateString(),
        'jam' => '10:00',
    ]);
    $response->assertRedirect(route('admin.jadwal.index'));
    assertDatabaseHas('jadwals', ['id_jadwal' => $jadwal->id_jadwal, 'tujuan' => 'Solok']);

    // 6. Delete Jadwal
    $response = actingAs($admin)->delete(route('admin.jadwal.destroy', $jadwal->id_jadwal));
    $response->assertRedirect(route('admin.jadwal.index'));
    assertDatabaseMissing('jadwals', ['id_jadwal' => $jadwal->id_jadwal]);
});
