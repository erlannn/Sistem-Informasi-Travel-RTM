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

function getTestSopir(): Sopir
{
    Role::firstOrCreate(['name' => 'Penumpang']);
    Role::firstOrCreate(['name' => 'Sopir']);

    return Sopir::firstOrCreate(
        ['nama' => 'Pak Budi Sopir'],
        [
            'no_hp' => '081234567811',
            'alamat' => 'Solok',
            'bagi_hasil_sopir' => 50000.00,
        ]
    );
}

function getTestArmadaHiace(): Armada
{
    return Armada::firstOrCreate(
        ['merk' => 'Toyota Hiace Premio'],
        [
            'warna' => 'White',
            'kursi' => 10,
            'status' => 'Aktif',
        ]
    );
}

function getTestArmadaElf(): Armada
{
    return Armada::firstOrCreate(
        ['merk' => 'Isuzu Elf Long'],
        [
            'warna' => 'Silver',
            'kursi' => 12,
            'status' => 'Aktif',
        ]
    );
}

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Penumpang']);
    Role::firstOrCreate(['name' => 'Sopir']);
});

test('new passenger user with no booking history receives empty CBF recommendations', function () {
    $sopir = getTestSopir();
    $armadaHiace = getTestArmadaHiace();

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
        'id_armada' => $armadaHiace->id_armada,
        'id_sopir' => $sopir->id_sopir,
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
    $sopir = getTestSopir();
    $armadaHiace = getTestArmadaHiace();
    $armadaElf = getTestArmadaElf();

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
        'id_armada' => $armadaHiace->id_armada,
        'id_sopir' => $sopir->id_sopir,
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
        'id_armada' => $armadaHiace->id_armada,
        'id_sopir' => $sopir->id_sopir,
        'asal' => 'Padang',
        'tujuan' => 'Sijunjung',
        'tanggal' => now()->addDays(1)->toDateString(),
        'jam' => '08:30:00',
        'harga' => 120000.00,
    ]);

    // Future Candidate 2: Different route Solok -> BIM (Lower match)
    $candidateLow = Jadwal::create([
        'id_armada' => $armadaElf->id_armada,
        'id_sopir' => $sopir->id_sopir,
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
    $response->assertSee('Rekomendasi Jadwal');
    $response->assertSee('Cocok');
});

test('passenger with 3 bookings on same route and 8 on different routes receives CBF recommendations', function () {
    $sopir = getTestSopir();
    $armadaHiace = getTestArmadaHiace();
    $armadaElf = getTestArmadaElf();

    $user = User::create([
        'name' => 'Vira Penumpang Aktif',
        'email' => 'vira.aktif@rtm.com',
        'password' => Hash::make('password123'),
    ]);
    $user->assignRole('Penumpang');

    $penumpang = Penumpang::create([
        'nama' => 'Vira Penumpang Aktif',
        'email' => 'vira.aktif@rtm.com',
        'password' => Hash::make('password123'),
        'no_hp' => '081299998888',
        'alamat' => 'Padang',
    ]);

    // 3 Past bookings: Padang -> Sijunjung at 08:00
    for ($i = 0; $i < 3; $i++) {
        $j = Jadwal::create([
            'id_armada' => $armadaHiace->id_armada,
            'id_sopir' => $sopir->id_sopir,
            'asal' => 'Padang',
            'tujuan' => 'Sijunjung',
            'tanggal' => now()->subDays(10 + $i)->toDateString(),
            'jam' => '08:00:00',
            'harga' => 120000.00,
        ]);
        $k = Kursi::create(['id_jadwal' => $j->id_jadwal, 'nomor_kursi' => '1A', 'status' => 'Terisi']);
        Pemesanan::create([
            'id_penumpang' => $penumpang->id_penumpang,
            'id_jadwal' => $j->id_jadwal,
            'id_kursi' => $k->id_kursi,
            'tanggal_pesan' => now()->subDays(10 + $i)->toDateString(),
            'jumlah_penumpang' => 1,
            'total_bayar' => 120000.00,
            'metode_pembayaran' => 'Cash',
            'status_pembayaran' => 'Lunas',
            'status_perjalanan' => 'Selesai',
        ]);
    }

    // 8 Past bookings: Other routes (e.g. Solok -> BIM at 10:00)
    for ($i = 0; $i < 8; $i++) {
        $j = Jadwal::create([
            'id_armada' => $armadaElf->id_armada,
            'id_sopir' => $sopir->id_sopir,
            'asal' => 'Solok',
            'tujuan' => 'BIM',
            'tanggal' => now()->subDays(20 + $i)->toDateString(),
            'jam' => '10:00:00',
            'harga' => 150000.00,
        ]);
        $k = Kursi::create(['id_jadwal' => $j->id_jadwal, 'nomor_kursi' => '1B', 'status' => 'Terisi']);
        Pemesanan::create([
            'id_penumpang' => $penumpang->id_penumpang,
            'id_jadwal' => $j->id_jadwal,
            'id_kursi' => $k->id_kursi,
            'tanggal_pesan' => now()->subDays(20 + $i)->toDateString(),
            'jumlah_penumpang' => 1,
            'total_bayar' => 150000.00,
            'metode_pembayaran' => 'Cash',
            'status_pembayaran' => 'Lunas',
            'status_perjalanan' => 'Selesai',
        ]);
    }

    // Future candidate: Padang -> Sijunjung at 08:00
    $candidate = Jadwal::create([
        'id_armada' => $armadaHiace->id_armada,
        'id_sopir' => $sopir->id_sopir,
        'asal' => 'Padang',
        'tujuan' => 'Sijunjung',
        'tanggal' => now()->addDays(2)->toDateString(),
        'jam' => '08:00:00',
        'harga' => 120000.00,
    ]);

    $cbfService = new ContentBasedFilteringService();
    $recommendations = $cbfService->getRecommendations($penumpang);

    expect($recommendations)->not->toBeEmpty();
    expect($recommendations->pluck('id_jadwal'))->toContain($candidate->id_jadwal);

    $matched = $recommendations->firstWhere('id_jadwal', $candidate->id_jadwal);
    expect($matched->match_percentage)->toBeGreaterThanOrEqual(40);

    // Verify Beranda page displays the recommendation
    $response = actingAs($user)->get(route('penumpang.beranda'));
    $response->assertStatus(200);
    $response->assertSee('Rekomendasi Jadwal');
    $response->assertSee('Padang');
    $response->assertSee('Sijunjung');
    $response->assertSee('% Cocok');
});

