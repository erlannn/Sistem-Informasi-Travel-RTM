<?php

namespace Database\Seeders;

use App\Models\Pemesanan;
use App\Models\Jadwal;
use App\Models\Penumpang;
use App\Models\Kursi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Fast, lightweight batch insertion for online database environments.
     */
    public function run(): void
    {
        $penumpangs = Penumpang::all();
        $jadwals = Jadwal::with('kursis')->orderBy('tanggal', 'asc')->orderBy('jam', 'asc')->get();

        if ($penumpangs->isEmpty() || $jadwals->isEmpty()) {
            return;
        }

        Pemesanan::query()->delete();

        // 8 representative bookings covering all key statuses
        $tripsData = [
            // Yesterday (-1) - Selesai & Lunas
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
            // Today (0) - Mix of Selesai, Naik, Pending
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
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
            [
                'offset_days' => 0,
                'metode' => 'Cash',
                'status_pembayaran' => 'Belum Bayar',
                'status_perjalanan' => 'Pending',
                'is_setor_admin' => false,
            ],
            // Tomorrow (+1) - Pending & Batal
            [
                'offset_days' => 1,
                'metode' => 'QRIS',
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
        ];

        $penumpangCount = $penumpangs->count();
        $now = now();
        $assignedSeatIds = [];
        $terisiSeatIds = [];
        $pemesananBatch = [];

        DB::transaction(function () use ($tripsData, $penumpangs, $jadwals, $penumpangCount, $now, &$assignedSeatIds, &$terisiSeatIds, &$pemesananBatch) {
            foreach ($tripsData as $i => $data) {
                $penumpang = $penumpangs[$i % $penumpangCount];
                $targetDate = Carbon::today()->addDays($data['offset_days'])->toDateString();

                // Pick schedule matching target date or fallback
                $jadwal = $jadwals->firstWhere('tanggal', $targetDate) ?? $jadwals[$i % $jadwals->count()];

                // Find unassigned seat from the schedule's pre-loaded seats
                $kursi = $jadwal->kursis->first(function ($k) use ($assignedSeatIds) {
                    return !in_array($k->id_kursi, $assignedSeatIds);
                });

                if ($kursi) {
                    $assignedSeatIds[] = $kursi->id_kursi;
                    if ($data['status_perjalanan'] !== 'Batal') {
                        $terisiSeatIds[] = $kursi->id_kursi;
                    }
                }

                $waktuBayar = $data['status_pembayaran'] === 'Lunas'
                    ? Carbon::parse($jadwal->tanggal)->subHours(rand(1, 12))
                    : null;

                $tanggalSetor = $data['is_setor_admin']
                    ? Carbon::parse($jadwal->tanggal)->addHours(4)
                    : null;

                $pemesananBatch[] = [
                    'id_penumpang' => $penumpang->id_penumpang,
                    'id_jadwal' => $jadwal->id_jadwal,
                    'id_kursi' => $kursi?->id_kursi,
                    'tanggal_pesan' => Carbon::parse($jadwal->tanggal)->subDays(rand(0, 1))->toDateString(),
                    'jumlah_penumpang' => 1,
                    'total_bayar' => $jadwal->harga ?? 80000.00,
                    'metode_pembayaran' => $data['metode'],
                    'status_pembayaran' => $data['status_pembayaran'],
                    'status_perjalanan' => $data['status_perjalanan'],
                    'waktu_bayar' => $waktuBayar,
                    'is_setor_admin' => $data['is_setor_admin'],
                    'tanggal_setor' => $tanggalSetor,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Bulk insert pemesanan records in 1 query
            if (!empty($pemesananBatch)) {
                Pemesanan::insert($pemesananBatch);
            }

            // Bulk update occupied seats status in 1 query
            if (!empty($terisiSeatIds)) {
                Kursi::whereIn('id_kursi', $terisiSeatIds)->update(['status' => 'Terisi']);
            }
        });
    }
}
