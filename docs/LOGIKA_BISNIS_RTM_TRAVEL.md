# Logika Bisnis & Alur Kerja RTM Travel (Laravel 13)

Dokumen ini berisi spesifikasi logika bisnis dan alur kerja (*business logic workflow*) untuk sistem **RTM Travel** berbasis **Laravel 13**. Logika bisnis difokuskan pada model pembayaran **Cash Saat Sampai Tujuan (*Post-paid Cash*)** serta mekanisme rekonsiliasi setoran uang fisik dari Supir ke Admin.

---

## 1. Actor & User Roles

| Role | Deskripsi Hak Akses & Tanggung Jawab |
| :--- | :--- |
| **Admin** | Kelola data master (Armada, Jadwal, Sopir, Kursi), pantau status perjalanan, dan lakukan **Verifikasi Setoran Kas** dari supir. |
| **Sopir** | Melihat jadwal perjalanan hari ini, melakukan **Boarding** (penumpang naik), menerima uang tunai saat tiba di tujuan, serta menyetorkan uang kas ke Admin. |
| **Penumpang** | Memilih rute/jadwal travel, memilih kursi, melakukan pemesanan tiket dengan status *Unpaid*, dan membayar cash di lokasi tujuan. |

---

## 2. Alur Logika Bisnis Utama (*Workflow*)

```
[Penumpang] Pesan Tiket Online
       │
       ▼
(status_perjalanan: 'Pending', status_pembayaran: 'Belum Bayar')
       │
       ▼
[Supir] Penjemputan / Naik Mobil (Boarding)
       │
       ▼
(status_perjalanan: 'Naik', status_pembayaran: 'Belum Bayar')
       │
       ▼
[Supir] Tiba di Tujuan + Terima Uang Cash
       │
       ▼
(status_perjalanan: 'Selesai', status_pembayaran: 'Lunas', waktu_bayar: timestamp)
       │
       ▼
[Admin] Terima & Verifikasi Setoran Uang Fisik dari Supir
       │
       ▼
(is_setor_admin: true, tanggal_setor: timestamp)
```

### Detail Tahapan:

### Tahap 1: Pemesanan Tiket oleh Penumpang
1. Penumpang memilih `id_jadwal`, `id_kursi`, dan menentukan `jumlah_penumpang`.
2. Sistem secara otomatis mengalkulasi total bayar:
   $$\\text{total\\_bayar} = \\text{jadwals.harga} \\times \\text{jumlah\\_penumpang}$$
3. Pesanan disimpan dengan state awal:
   * `status_perjalanan` = `'Pending'`
   * `status_pembayaran` = `'Belum Bayar'`
   * `metode_pembayaran` = `'Cash'`
4. Status pada tabel `kursis` diperbarui menjadi `'Terisi'`.

### Tahap 2: Penjemputan & Boarding oleh Supir
1. Supir membuka dashboard "Perjalanan Hari Ini".
2. Saat penumpang naik ke armada di titik jemput, Supir menekan tombol **"Naikkan Penumpang"**.
3. Sistem memperbarui state pesanan:
   * `status_perjalanan` = `'Naik'`
   * `status_pembayaran` tetap `'Belum Bayar'`

### Tahap 3: Pelunasan di Tempat Tujuan oleh Supir
1. Saat tiba di lokasi tujuan, Penumpang menyerahkan uang tunai sesuai `total_bayar`.
2. Supir menekan tombol **"Selesai & Terima Cash"**.
3. Sistem memperbarui state pesanan:
   * `status_perjalanan` = `'Selesai'`
   * `status_pembayaran` = `'Lunas'`
   * `waktu_bayar` = `now()`

### Tahap 4: Rekonsiliasi & Setoran Kas ke Admin
1. Di akhir perjalanan/shift, Supir membawa uang tunai fisik ke Admin/Kasir travel.
2. Admin membuka menu **"Rekap Setoran Perjalanan"**. Total uang yang harus disetorkan dihitung dengan rumus:
   $$\\text{Total Setoran Wajib} = \\sum \\text{pemesanans.total\\_bayar} \\quad \\text{dimana } \\texttt{status\\_pembayaran} = \\text{'Lunas'} \\text{ \\& } \\texttt{is\\_setor\\_admin} = \\text{false}$$
3. Admin memverifikasi jumlah uang tunai dan menekan tombol **"Verifikasi Setoran"**.
4. Sistem memperbarui state pesanan:
   * `is_setor_admin` = `true`
   * `tanggal_setor` = `now()`

---

## 3. Penanganan Pembatalan & No-Show

Jika penumpang tidak datang saat penjemputan (*No-Show*) atau membatalkan perjalanan:
1. Supir/Admin menekan tombol **"Batalkan Pesanan"**.
2. State pesanan diperbarui:
   * `status_perjalanan` = `'Batal'`
   * `status_pembayaran` = `'Belum Bayar'`
3. Sistem secara otomatis mengembalikan status kursi terkait pada tabel `kursis` menjadi `'Kosong'`.

---

## 4. Contoh Implementasi Controller (Laravel 13)

### Pemesanan Controller (Penumpang)
```php
namespace App\Http\Controllers\Penumpang;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Jadwal;
use App\Models\Kursi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jadwal' => 'required|exists:jadwals,id_jadwal',
            'id_kursi' => 'required|exists:kursis,id_kursi',
            'jumlah_penumpang' => 'required|integer|min:1',
        ]);

        $jadwal = Jadwal::findOrFail($validated['id_jadwal']);
        $totalBayar = $jadwal->harga * $validated['jumlah_penumpang'];

        $pemesanan = Pemesanan::create([
            'id_penumpang' => Auth::id(),
            'id_jadwal' => $validated['id_jadwal'],
            'id_kursi' => $validated['id_kursi'],
            'tanggal_pesan' => now()->toDateString(),
            'jumlah_penumpang' => $validated['jumlah_penumpang'],
            'total_bayar' => $totalBayar,
            'metode_pembayaran' => 'Cash',
            'status_pembayaran' => 'Belum Bayar',
            'status_perjalanan' => 'Pending',
        ]);

        Kursi::where('id_kursi', $validated['id_kursi'])->update(['status' => 'Terisi']);

        return redirect()->route('penumpang.status')
            ->with('success', 'Tiket berhasil dipesan. Pembayaran dilakukan secara cash saat sampai di tujuan.');
    }
}
```

### Sopir Controller (Eksekusi Boarding & Cash)
```php
namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Kursi;
use Illuminate\Http\Request;

class SopirPemesananController extends Controller
{
    // Aksi 1: Penumpang naik mobil
    public function penumpangNaik($id_pemesanan)
    {
        $pemesanan = Pemesanan::findOrFail($id_pemesanan);
        $pemesanan->update([
            'status_perjalanan' => 'Naik',
        ]);

        return back()->with('success', 'Status penumpang diperbarui: Naik ke armada.');
    }

    // Aksi 2: Sampai tujuan dan terima pembayaran cash
    public function terimaBayarCash($id_pemesanan)
    {
        $pemesanan = Pemesanan::findOrFail($id_pemesanan);
        
        $pemesanan->update([
            'status_perjalanan' => 'Selesai',
            'status_pembayaran' => 'Lunas',
            'waktu_bayar' => now(),
        ]);

        return back()->with('success', 'Pembayaran cash diterima dan perjalanan selesai.');
    }

    // Aksi 3: Penumpang Batal / No-Show
    public function batalkanPesanan($id_pemesanan)
    {
        $pemesanan = Pemesanan::findOrFail($id_pemesanan);
        
        if ($pemesanan->id_kursi) {
            Kursi::where('id_kursi', $pemesanan->id_kursi)->update(['status' => 'Kosong']);
        }

        $pemesanan->update([
            'status_perjalanan' => 'Batal',
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan dan kursi dilepaskan.');
    }
}
```

### Admin Setoran Controller (Verifikasi Kas)
```php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class AdminSetoranController extends Controller
{
    public function verifikasiSetoran($id_jadwal)
    {
        Pemesanan::where('id_jadwal', $id_jadwal)
            ->where('status_pembayaran', 'Lunas')
            ->where('is_setor_admin', false)
            ->update([
                'is_setor_admin' => true,
                'tanggal_setor' => now(),
            ]);

        return back()->with('success', 'Setoran kas dari supir berhasil diverifikasi.');
    }
}
```
