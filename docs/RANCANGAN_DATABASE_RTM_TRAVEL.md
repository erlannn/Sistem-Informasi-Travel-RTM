# Rancangan Database & Migration RTM Travel (Laravel 13)

Dokumen ini berisi spesifikasi skema database, skrip SQL penyesuaian, serta migration **Laravel 13** untuk aplikasi **RTM Travel**. Perubahan difokuskan pada pemisahan status pembayaran dan perjalanan pada tabel `pemesanans` tanpa mengubah tabel-tabel pendukung lainnya (`users`, `admins`, `sopirs`, `penumpangs`, `armadas`, `jadwals`, `kursis`).

---

## 1. Skema Database Keseluruhan (`rtm_db`)

```
+------------------+         +------------------+         +------------------+
|     armadas      |         |      sopirs      |         |    penumpangs    |
+------------------+         +------------------+         +------------------+
| id_armada (PK)   |         | id_sopir (PK)    |         | id_penumpang(PK) |
| merk             |         | nama             |         | nama             |
| warna            |         | no_hp            |         | email            |
| status           |         | alamat           |         | no_hp            |
+--------+---------+         | gaji             |         +--------+---------+
         |                   +--------+---------+                  |
         |                            |                            |
         +-------------+--------------+                            |
                       |                                           |
                       v                                           |
            +--------------------+                                 |
            |      jadwals       |<--------------------------------+
            +--------------------+                                 |
            | id_jadwal (PK)     |                                 |
            | id_armada (FK)     |                                 |
            | id_sopir (FK)      |                                 |
            | asal, tujuan       |                                 |
            | tanggal, jam, harga|                                 |
            +----------+---------+                                 |
                       |                                           |
                       +----------------------+                    |
                       |                      |                    |
                       v                      v                    |
            +--------------------+  +--------------------+         |
            |       kursis       |  |     pemesanans     |<--------+
            +--------------------+  +--------------------+
            | id_kursi (PK)      |  | id_pemesanan (PK)  |
            | id_jadwal (FK)     |  | id_penumpang (FK)  |
            | nomor_kursi        |  | id_jadwal (FK)     |
            | status             |  | id_kursi (FK)      |
            +--------------------+  | tanggal_pesan      |
                                    | jumlah_penumpang   |
                                    | total_bayar        | <--- [BARU]
                                    | metode_pembayaran  | <--- [BARU]
                                    | status_pembayaran  | <--- [BARU]
                                    | status_perjalanan  | <--- [BARU]
                                    | waktu_bayar        | <--- [BARU]
                                    | is_setor_admin     | <--- [BARU]
                                    | tanggal_setor      | <--- [BARU]
                                    +--------------------+
```

---

## 2. Struktur Tabel `pemesanans` (Terperinci)

| Nama Kolom | Tipe Data | Nullable | Default | Keterangan |
| :--- | :--- | :--- | :--- | :--- |
| `id_pemesanan` | `BIGINT UNSIGNED` | NO | AUTO_INCREMENT | Primary Key |
| `id_penumpang` | `BIGINT UNSIGNED` | NO | - | Foreign Key ke `penumpangs.id_penumpang` |
| `id_jadwal` | `BIGINT UNSIGNED` | NO | - | Foreign Key ke `jadwals.id_jadwal` |
| `id_kursi` | `BIGINT UNSIGNED` | YES | NULL | Foreign Key ke `kursis.id_kursi` |
| `tanggal_pesan` | `DATE` | NO | - | Tanggal pemesanan dibuat |
| `jumlah_penumpang`| `INT` | NO | `1` | Jumlah tiket yang dipesan |
| **`total_bayar`** | `DECIMAL(12,2)` | NO | `0.00` | Calculated: `jadwals.harga * jumlah_penumpang` |
| **`metode_pembayaran`**| `VARCHAR(50)`| NO | `'Cash'` | Metode bayar (Diisi `'Cash'`) |
| **`status_pembayaran`**| `ENUM` | NO | `'Belum Bayar'` | Option: `'Belum Bayar'`, `'Lunas'` |
| **`status_perjalanan`**| `ENUM` | NO | `'Pending'` | Option: `'Pending'`, `'Naik'`, `'Selesai'`, `'Batal'` |
| **`waktu_bayar`** | `TIMESTAMP` | YES | NULL | Waktu ketika supir menerima bayar cash |
| **`is_setor_admin`** | `TINYINT(1)` / `BOOLEAN` | NO | `0` (`false`) | Penanda supir telah menyerahkan kas ke admin |
| **`tanggal_setor`** | `TIMESTAMP` | YES | NULL | Waktu verifikasi setoran oleh admin |
| `created_at` | `TIMESTAMP` | YES | NULL | Timestamp Laravel |
| `updated_at` | `TIMESTAMP` | YES | NULL | Timestamp Laravel |

---

## 3. Eksekusi Langsung SQL (phpMyAdmin / Direct Query)

Jika Anda ingin langsung meng-update database yang sudah berjalan tanpa menjalankan migration Laravel:

```sql
-- Jalankan query ini di phpMyAdmin pada database rtm_db
ALTER TABLE `pemesanans`
  ADD COLUMN `total_bayar` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `jumlah_penumpang`,
  ADD COLUMN `metode_pembayaran` VARCHAR(50) NOT NULL DEFAULT 'Cash' AFTER `total_bayar`,
  ADD COLUMN `status_pembayaran` ENUM('Belum Bayar', 'Lunas') NOT NULL DEFAULT 'Belum Bayar' AFTER `metode_pembayaran`,
  ADD COLUMN `status_perjalanan` ENUM('Pending', 'Naik', 'Selesai', 'Batal') NOT NULL DEFAULT 'Pending' AFTER `status_pembayaran`,
  ADD COLUMN `waktu_bayar` TIMESTAMP NULL DEFAULT NULL AFTER `status_perjalanan`,
  ADD COLUMN `is_setor_admin` TINYINT(1) NOT NULL DEFAULT 0 AFTER `waktu_bayar`,
  ADD COLUMN `tanggal_setor` TIMESTAMP NULL DEFAULT NULL AFTER `is_setor_admin`,
  DROP COLUMN `status`;
```

---

## 4. File Migration Laravel 13

Buat file migration baru di folder `database/migrations/` dengan nama misal `2026_08_08_000001_update_pemesanans_payment_structure.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            // Hapus kolom status lama yang tercampur
            if (Schema::hasColumn('pemesanans', 'status')) {
                $table->dropColumn('status');
            }

            // Tambahkan struktur kolom baru
            $table->decimal('total_bayar', 12, 2)->default(0.00)->after('jumlah_penumpang');
            $table->string('metode_pembayaran', 50)->default('Cash')->after('total_bayar');
            $table->enum('status_pembayaran', ['Belum Bayar', 'Lunas'])->default('Belum Bayar')->after('metode_pembayaran');
            $table->enum('status_perjalanan', ['Pending', 'Naik', 'Selesai', 'Batal'])->default('Pending')->after('status_pembayaran');
            $table->timestamp('waktu_bayar')->nullable()->after('status_perjalanan');
            $table->boolean('is_setor_admin')->default(false)->after('waktu_bayar');
            $table->timestamp('tanggal_setor')->nullable()->after('is_setor_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->string('status')->default('Pending')->after('jumlah_penumpang');

            $table->dropColumn([
                'total_bayar',
                'metode_pembayaran',
                'status_pembayaran',
                'status_perjalanan',
                'waktu_bayar',
                'is_setor_admin',
                'tanggal_setor',
            ]);
        });
    }
};
```

---

## 5. Model Eloquent Laravel 13 (`App\Models\Pemesanan.php`)

Sesuaikan model Eloquent `Pemesanan` agar kolom-kolom baru dapat diisi (*fillable*) dan dikonversi tipe datanya (*casts*):

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans';
    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'id_penumpang',
        'id_jadwal',
        'id_kursi',
        'tanggal_pesan',
        'jumlah_penumpang',
        'total_bayar',
        'metode_pembayaran',
        'status_pembayaran',
        'status_perjalanan',
        'waktu_bayar',
        'is_setor_admin',
        'tanggal_setor',
    ];

    protected $casts = [
        'tanggal_pesan' => 'date',
        'waktu_bayar' => 'datetime',
        'tanggal_setor' => 'datetime',
        'is_setor_admin' => 'boolean',
        'total_bayar' => 'decimal:2',
    ];

    // Relasi ke Penumpang
    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class, 'id_penumpang', 'id_penumpang');
    }

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    // Relasi ke Kursi
    public function kursi()
    {
        return $this->belongsTo(Kursi::class, 'id_kursi', 'id_kursi');
    }
}
```
