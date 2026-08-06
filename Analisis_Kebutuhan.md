content = """# Analisis Kebutuhan Sistem: CV RTM (Format AI Agent)

**Sistem:** Sistem Informasi Pemesanan Tiket Travel CV RTM  
**Deskripsi:** Dokumen ini disusun dengan struktur *Agent-centric* agar mudah diproses, di-parsing, dan diimplementasikan oleh AI Agent (seperti framework Antigravity, AutoGPT, atau agent berbasis LLM lainnya). Kebutuhan sistem dipetakan menjadi **Peran Agen (Agent Roles)** dan **Fungsi/Tools (Actions)**.

---

## 1. Konfigurasi Agen: Pengguna (User Agent)
**Peran:** Menangani interaksi otomatis dengan pelanggan travel dan memproses permintaan layanan.
**Tools / Functions yang Diperlukan:**
- `register_account(user_data)`: Mendaftarkan akun baru ke dalam sistem.
- `login_user(credentials)`: Melakukan otentikasi masuk sistem.
- `search_schedule(criteria)`: Mencari informasi jadwal perjalanan berdasarkan rute dan tanggal.
- `view_trip_details(trip_id)`: Menampilkan rincian perjalanan secara spesifik.
- `get_cbf_recommendation(user_preferences)`: Menghasilkan rekomendasi jadwal menggunakan algoritma *Content-Based Filtering*.
- `book_ticket(trip_id, user_id, seat_data)`: Memproses transaksi pemesanan tiket.
- `send_package(package_details)`: Memproses input layanan pengiriman paket.
- `rent_vehicle(vehicle_id, rental_dates)`: Memproses reservasi penyewaan kendaraan.
- `check_booking_status(booking_id)`: Memeriksa dan memantau status pemesanan secara *real-time*.

---

## 2. Konfigurasi Agen: Admin (Admin Agent)
**Peran:** Mengelola operasional *backend*, master data sistem, dan mengawasi aktivitas secara keseluruhan.
**Tools / Functions yang Diperlukan:**
- `login_admin(credentials)`: Melakukan otentikasi otorisasi tingkat admin.
- `manage_schedule(action, schedule_data)`: Melakukan aksi CRUD (Create, Read, Update, Delete) pada jadwal perjalanan.
- `manage_vehicle(action, vehicle_data)`: Mengelola inventaris kendaraan.
- `manage_ticket_booking(action, booking_data)`: Memvalidasi dan mengelola data pemesanan tiket.
- `manage_package(action, package_data)`: Mengelola status dan data pengiriman paket.
- `manage_rental(action, rental_data)`: Mengelola persetujuan penyewaan kendaraan.
- `manage_customer(action, customer_data)`: Mengelola basis data pelanggan.
- `manage_driver_salary(action, salary_data)`: Menghitung dan mendistribusikan data gaji sopir.
- `generate_system_report(date_range)`: Menarik data analitik dan laporan sistem.

---

## 3. Konfigurasi Agen: Sopir (Driver Agent)
**Peran:** Menyediakan informasi operasional untuk memandu tugas sopir di lapangan.
**Tools / Functions yang Diperlukan:**
- `login_driver(credentials)`: Melakukan otentikasi akses khusus sopir.
- `view_assigned_schedule(driver_id)`: Menarik data jadwal keberangkatan yang ditugaskan kepada sopir.
- `view_passenger_list(trip_id)`: Menampilkan *manifest* atau data penumpang per perjalanan.
- `view_package_list(trip_id)`: Menampilkan daftar muatan paket yang harus diantar.
- `view_salary_info(driver_id)`: Menampilkan informasi riwayat dan rincian gaji.

---

## 4. Metadata JSON (Machine-Readable Format)
*Blok JSON di bawah ini dapat di-parsing langsung oleh AI Agent untuk mendefinisikan *capabilities* masing-masing aktor.*

```json
{
  "system_name": "CV_RTM_Travel_System",
  "version": "1.0",
  "agents": {
    "user_agent": {
      "role": "Customer interactions and service requests",
      "allowed_intents": [
        "register", "login", "search_schedule", "view_details", 
        "get_recommendation_cbf", "book_ticket", "send_package", 
        "rent_vehicle", "track_status"
      ]
    },
    "admin_agent": {
      "role": "Backend administration and data management",
      "allowed_intents": [
        "login", "manage_schedules", "manage_vehicles", "manage_bookings", 
        "manage_packages", "manage_rentals", "manage_customers", 
        "manage_salaries", "view_reports"
      ]
    },
    "driver_agent": {
      "role": "Driver operational guidance and tracking",
      "allowed_intents": [
        "login", "view_schedule", "view_passengers", 
        "view_packages", "view_salary"
      ]
    }
  }
}