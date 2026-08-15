<?php

namespace Database\Seeders;

use App\Models\Pemesanan;
use App\Models\Jadwal;
use App\Models\Penumpang;
use App\Models\Kursi;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penumpangs = Penumpang::all();
        $jadwals = Jadwal::with('kursis')->orderBy('tanggal', 'asc')->orderBy('jam', 'asc')->get();

        if ($penumpangs->isEmpty() || $jadwals->isEmpty()) {
            return;
        }

        Pemesanan::query()->delete();

        // 20 Passenger trip records
        $tripsData = [
            // Past Trips (Status: Selesai)
            [
                'offset_days' => -3,
                'metode' => 'Cash',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Selesai',
                'is_setor_admin' => true,
            ],
            [
                'offset_days' => -3,
                'metode' => 'Transfer',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Selesai',
                'is_setor_admin' => true,
            ],
            [
                'offset_days' => -2,
                'metode' => 'Cash',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Selesai',
                'is_setor_admin' => true,
            ],
            [
                'offset_days' => -2,
                'metode' => 'QRIS',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Selesai',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => -1,
                'metode' => 'Cash',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Selesai',
                'is_setor_admin' => true,
            ],
            [
                'offset_days' => -1,
                'metode' => 'Transfer',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Selesai',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => -1,
                'metode' => 'Cash',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Selesai',
                'is_setor_admin' => true,
            ],
            // Today Trips (Mix of Selesai, Naik, Pending)
            [
                'offset_days' => 0,
                'metode' => 'Cash',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Selesai',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 0,
                'metode' => 'Cash',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Naik',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 0,
                'metode' => 'Transfer',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Naik',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 0,
                'metode' => 'Cash',
                'status_pembayaran' => 'Belum Bayar',
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 0,
                'metode' => 'QRIS',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
            // Tomorrow & Future Trips (Mix of Pending, Batal)
            [
                'offset_days' => 1,
                'metode' => 'Cash',
                'status_pembayaran' => 'Belum Bayar',
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 1,
                'metode' => 'Transfer',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 1,
                'metode' => 'Cash',
                'status_pembayaran' => 'Belum Bayar',
                'status_perjalanan' => 'Batal',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 2,
                'metode' => 'QRIS',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 2,
                'metode' => 'Cash',
                'status_pembayaran' => 'Belum Bayar',
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 3,
                'metode' => 'Transfer',
                'status_pembayaran' => 'Lunas',
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 4,
                'metode' => 'Cash',
                'status_pembayaran' => 'Belum Bayar',
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 5,
                'metode' => 'Cash',
                'status_pembayaran' => 'Belum Bayar',
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
        ];

        $penumpangCount = $penumpangs->count();

        foreach ($tripsData as $i => $data) {
            $penumpang = $penumpangs[$i % $penumpangCount];
            $targetDate = Carbon::today()->addDays($data['offset_days'])->toDateString();

            // Find a schedule matching target date
            $jadwal = $jadwals->where('tanggal', $targetDate)->first();

            if (!$jadwal) {
                $jadwal = $jadwals[$i % $jadwals->count()];
            }

            // Find an unassigned seat for this schedule
            $assignedKursiIds = Pemesanan::where('id_jadwal', $jadwal->id_jadwal)
                ->whereNotNull('id_kursi')
                ->pluck('id_kursi')
                ->toArray();

            $kursi = Kursi::where('id_jadwal', $jadwal->id_jadwal)
                ->whereNotIn('id_kursi', $assignedKursiIds)
                ->first();

            // Fallback to any schedule with a free seat
            if (!$kursi) {
                foreach ($jadwals as $altJadwal) {
                    $assignedAlt = Pemesanan::where('id_jadwal', $altJadwal->id_jadwal)
                        ->whereNotNull('id_kursi')
                        ->pluck('id_kursi')
                        ->toArray();

                    $altKursi = Kursi::where('id_jadwal', $altJadwal->id_jadwal)
                        ->whereNotIn('id_kursi', $assignedAlt)
                        ->first();

                    if ($altKursi) {
                        $jadwal = $altJadwal;
                        $kursi = $altKursi;
                        break;
                    }
                }
            }

            $waktuBayar = $data['status_pembayaran'] === 'Lunas'
                ? Carbon::parse($jadwal->tanggal)->subHours(rand(1, 12))
                : null;

            $tanggalSetor = $data['is_setor_admin']
                ? Carbon::parse($jadwal->tanggal)->addHours(4)
                : null;

            Pemesanan::create([
                'id_penumpang' => $penumpang->id_penumpang,
                'id_jadwal' => $jadwal->id_jadwal,
                'id_kursi' => $kursi?->id_kursi,
                'tanggal_pesan' => Carbon::parse($jadwal->tanggal)->subDays(rand(0, 2))->toDateString(),
                'jumlah_penumpang' => 1,
                'total_bayar' => $jadwal->harga ?? 80000.00,
                'metode_pembayaran' => $data['metode'],
                'status_pembayaran' => $data['status_pembayaran'],
                'status_perjalanan' => $data['status_perjalanan'],
                'waktu_bayar' => $waktuBayar,
                'is_setor_admin' => $data['is_setor_admin'],
                'tanggal_setor' => $tanggalSetor,
            ]);

            // Update chair status based on trip status
            if ($kursi) {
                if ($data['status_perjalanan'] === 'Batal') {
                    $kursi->update(['status' => 'Kosong']);
                } else {
                    $kursi->update(['status' => 'Terisi']);
                }
            }
        }
    }
}
