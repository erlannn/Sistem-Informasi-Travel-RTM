<?php

use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Pemesanan;
use App\Models\Penumpang;
use App\Models\Sopir;
use App\Models\User;
use App\Services\ContentBasedFilteringService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use function Pest\Laravel\actingAs;

uses(DatabaseTransactions::class);

/**
 * @property Sopir $sopir
 * @property Armada $armadaHiace
 * @property Armada $armadaElf
 */

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Penumpang']);
    Role::firstOrCreate(['name' => 'Sopir']);

    // Setup Driver & Armada
    $this->sopir = Sopir::create([
        'nama' => 'Pak Budi Sopir',
        'no_hp' => '081234567811',
        'alamat' => 'Solok',
        'bagi_hasil_sopir' => 50000.00,
    ]);

    $this->armadaHiace = Armada::create([
        'merk' => 'Toyota Hiace Premio',
        'warna' => 'White',
        'kursi' => 10,
        'status' => 'Aktif',
    ]);

    $this->armadaElf = Armada::create([
        'merk' => 'Isuzu Elf Long',
        'warna' => 'Silver',
        'kursi' => 12,
        'status' => 'Aktif',
    ]);
});

test('new passenger user with no booking history receives empty CBF recommendations', function () {
    /** @var TestCase $this */
    $newUser = User::create([
        'name' => 'Penumpang Baru',
        'email' => 'newuser@rtm.com',
        'password' => Hash::make('password123'),
    ]);
    $newUser->assignRole('Penumpang');

    $penumpang = Penumpang::create([
        'nama' => 'Penumpang Baru',
        'email' => 'newuser@rtm.com',
        'password' => Hash::make('password123'),
        'no_hp' => '081234111222',
        'alamat' => 'Padang',
    ]);

    // Create candidate future schedule
    Jadwal::create([
        'id_armada' => $this->armadaHiace->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Padang',
        'tujuan' => 'Sijunjung',
        'tanggal' => now()->addDays(2)->toDateString(),
        'jam' => '08:00:00',
        'harga' => 120000.00,
    ]);

    $cbfService = new ContentBasedFilteringService();
    $recommendations = $cbfService->getRecommendations($penumpang);

    expect($recommendations)->toBeEmpty();

    // Verify view rendering for new user
    $responseDashboard = actingAs($newUser)->get(route('penumpang.dashboard'));
    $responseDashboard->assertStatus(200);
    $responseDashboard->assertSee('Belum Ada Rekomendasi Jadwal');

    $responseBeranda = actingAs($newUser)->get(route('penumpang.beranda'));
    $responseBeranda->assertStatus(200);
    $responseBeranda->assertSee('Lakukan pemesanan pertama Anda');
});

test('passenger with booking history receives recommendations ranked by CBF similarity', function () {
    $user = User::create([
        'name' => 'Budi Penumpang Setia',
        'email' => 'budi.setia@rtm.com',
        'password' => Hash::make('password123'),
    ]);
    $user->assignRole('Penumpang');

    $penumpang = Penumpang::create([
        'nama' => 'Budi Penumpang Setia',
        'email' => 'budi.setia@rtm.com',
        'password' => Hash::make('password123'),
        'no_hp' => '081234999888',
        'alamat' => 'Padang',
    ]);

    // History Schedule: Padang -> Sijunjung, Hiace Premio, Jam 08:00, Rp 120.000
    $pastJadwal = Jadwal::create([
        'id_armada' => $this->armadaHiace->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Padang',
        'tujuan' => 'Sijunjung',
        'tanggal' => now()->subDays(5)->toDateString(),
        'jam' => '08:00:00',
        'harga' => 120000.00,
    ]);

    $kursiPast = Kursi::create([
        'id_jadwal' => $pastJadwal->id_jadwal,
        'nomor_kursi' => '1A',
        'status' => 'Terisi',
    ]);

    Pemesanan::create([
        'id_penumpang' => $penumpang->id_penumpang,
        'id_jadwal' => $pastJadwal->id_jadwal,
        'id_kursi' => $kursiPast->id_kursi,
        'tanggal_pesan' => now()->subDays(5)->toDateString(),
        'jumlah_penumpang' => 1,
        'total_bayar' => 120000.00,
        'metode_pembayaran' => 'Cash',
        'status_pembayaran' => 'Lunas',
        'status_perjalanan' => 'Selesai',
    ]);

    // Future Candidate 1: Exact route Padang -> Sijunjung (High match)
    $candidateHigh = Jadwal::create([
        'id_armada' => $this->armadaHiace->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Padang',
        'tujuan' => 'Sijunjung',
        'tanggal' => now()->addDays(1)->toDateString(),
        'jam' => '08:30:00',
        'harga' => 120000.00,
    ]);

    // Future Candidate 2: Different route Solok -> BIM (Lower match)
    $candidateLow = Jadwal::create([
        'id_armada' => $this->armadaElf->id_armada,
        'id_sopir' => $this->sopir->id_sopir,
        'asal' => 'Solok',
        'tujuan' => 'BIM',
        'tanggal' => now()->addDays(1)->toDateString(),
        'jam' => '16:00:00',
        'harga' => 200000.00,
    ]);

    $cbfService = new ContentBasedFilteringService();
    $recommendations = $cbfService->getRecommendations($penumpang);

    expect($recommendations)->not->toBeEmpty();
    expect($recommendations->first()->id_jadwal)->toBe($candidateHigh->id_jadwal);
    expect($recommendations->first()->cbf_score)->toBeGreaterThan($recommendations->last()->cbf_score);

    // Verify web response
    $response = actingAs($user)->get(route('penumpang.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Berdasarkan Histori Pemesanan');
    $response->assertSee('Cocok');
});
