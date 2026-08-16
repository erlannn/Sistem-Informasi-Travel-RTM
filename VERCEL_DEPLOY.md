# Panduan Deployment ke Vercel (Staging / Testing)

Dokumen ini berisi panduan langkah demi langkah untuk melakukan hosting dan testing project **Sistem-Informasi-Travel-RTM** pada Vercel.

---

## 1. Prasyarat

- Akun **Vercel** ([vercel.com](https://vercel.com/))
- Node.js & npm (sudah terinstall di komputer lokal)
- Git repository (GitHub / GitLab / Bitbucket)

---

## 2. Persiapan Project & Build Assets

Sebelum me-deploy, pastikan asset frontend (Tailwind CSS & JavaScript) sudah di-build:

```bash
# Build assets untuk produksi
npm run build
```

---

## 3. Deployment Menggunakan Vercel CLI (Metode Tercepat)

### A. Install Vercel CLI & Login
```bash
npm install -g vercel
vercel login
```

### B. Deploy ke Staging / Production
Jalankan perintah berikut pada root folder project:

```bash
vercel --prod
```

Ikuti petunjuk interaktif pada terminal:
- **Set up and deploy?** `Y`
- **Which scope?** Pilih akun Vercel Anda
- **Link to existing project?** `N`
- **What's your project's name?** `sistem-informasi-travel-rtm` (atau nama pilihan Anda)
- **In which directory is your code located?** `./`

---

## 4. Konfigurasi Environment Variables di Vercel Dashboard

Buka dashboard project Anda di **Vercel** (`https://vercel.com/dashboard`), masuk ke **Settings > Environment Variables**, dan tambahkan variabel berikut:

| Key | Value | Catatan |
|---|---|---|
| `APP_NAME` | `Sistem-Informasi-Travel-RTM` | |
| `APP_ENV` | `production` | |
| `APP_KEY` | `base64:iQfugxaAWMFUNtU0D15dtYpb5w8d6VyPbqXB1D/i4Og=` | Ambil dari `.env` lokal |
| `APP_DEBUG` | `false` | |
| `APP_URL` | `https://nama-project-anda.vercel.app` | Sesuaikan URL Vercel |
| `DB_CONNECTION` | `mysql` | |
| `DB_HOST` | `wxmkyo.h.filess.io` | Host filess.io |
| `DB_PORT` | `61032` | Port filess.io |
| `DB_DATABASE` | `rtm_db_mineralson` | |
| `DB_USERNAME` | `rtm_db_mineralson` | |
| `DB_PASSWORD` | `d86d20ae40d53c3111a58ee166c07480784a3a5f` | |
| `SESSION_DRIVER` | `database` | Database session persistent |
| `CACHE_STORE` | `database` | Database cache persistent |
| `LOG_CHANNEL` | `errorlog` | Hindari log file lokal |

---

## 5. Fitur Caching Browser

Project ini sudah dilengkapi dengan middleware **ETag & Cache-Control**. 
- Gambar statis (logo, hero, armada) disimpan di cache browser pengguna selama **30 hari**.
- Halaman web menggunakan **ETag revalidation**: Jika data di server/database tidak berubah, browser pengguna akan menggunakan data cache (HTTP `304 Not Modified`) tanpa mendownload ulang konten dari server.

---

## 6. Fitur Cetak PDF

Aplikasi ini menggunakan engine **DomPDF** (pure PHP) untuk cetak tiket penumpang dan rekap setoran kas admin. Fitur cetak PDF **100% kompatibel dan berjalan lancar** di Vercel Serverless.
