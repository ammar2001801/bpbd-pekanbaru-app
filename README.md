# Sistem Informasi Rekapitulasi Kejadian Bencana dan Pelaporan Harian Berbasis Web pada BPBD Kota Pekanbaru

Aplikasi web terintegrasi untuk Pusat Pengendalian Operasi Penanggulangan Bencana (**PUSDALOPS-PB**) Badan Penanggulangan Bencana Daerah (BPBD) Kota Pekanbaru. Sistem ini menggantikan proses pelaporan manual yang sebelumnya tercecer di grup WhatsApp dan lembar kerja Excel terpisah, menjadi satu sistem basis data terpusat dengan fitur input cepat, visualisasi spasial, grafik tren, serta ekspor rekapitulasi dan cetak laporan resmi PDF siap tanda tangan pimpinan.

---

## 📌 Ringkasan Proyek
- **Instansi**: BPBD Kota Pekanbaru (Pemerintah Kota Pekanbaru)
- **Unit Kerja**: Pusat Pengendalian Operasi Penanggulangan Bencana (PUSDALOPS-PB)
- **Tujuan Utama**: Mempercepat rekapitulasi harian, bulanan, dan tahunan kejadian bencana (Karhutla, banjir, pohon tumbang, evakuasi satwa liar, dll.) untuk diserahkan ke Kepala Pelaksana, Walikota Pekanbaru, dan BNPB.
- **Karakteristik**: Berbahasa Indonesia penuh, responsif (*mobile-friendly* untuk petugas lapangan), stabil, dan mudah dipasang di server kantor menggunakan XAMPP atau Laragon.

---

## 🛠️ Tech Stack & Pustaka
- **Backend Framework**: [Laravel 11](https://laravel.com/) (PHP 8.2+) dengan arsitektur Model-View-Controller (MVC)
- **Database**: SQLite (aktif *out-of-the-box* untuk pengujian lokal) & kompatibel penuh dengan **MySQL (XAMPP / Laragon)**
- **Autentikasi & UI**: Laravel Breeze (Blade) + [Tailwind CSS](https://tailwindcss.com/) bertema instansi pemerintah (BPBD Navy `#0F172A` & Emergency Orange `#EA580C`)
- **Peta Digital & Geospasial**: [Leaflet.js](https://leafletjs.com/) + OpenStreetMap dengan fitur **Pilih Titik Koordinat Klik Peta** dan **📍 Gunakan Lokasi Saya (GPS)**
- **Grafik & Visualisasi**: [Chart.js](https://www.chartjs.org/) (Tren Garis Bulanan, Peringkat Batang Kecamatan, Donut Komposisi Kejadian)
- **Cetak Laporan PDF**: [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) (Lembar Kejadian Tunggal A4 Portrait & Rekapitulasi Berkala A4 Landscape lengkap dengan Kop Surat Pemko & Blok Tanda Tangan)
- **Ekspor Excel**: [maatwebsite/excel](https://maatwebsite.nl/) (PhpSpreadsheet native styling, formula `=SUM()`, Kop Dinas, dan Matriks 15 Kecamatan)

---

## 👥 Role & Hak Akses Pengguna

| Role | Akun Default | Password | Hak Akses Utama |
|---|---|---|---|
| **Admin IT** | `admin@bpbd-pekanbaru.go.id` | `password` | Kelola seluruh pengguna, master data bencana & wilayah, pengaturan kop surat & pimpinan, serta seluruh data kejadian. |
| **Petugas TRC** | `petugas@bpbd-pekanbaru.go.id` | `password` | Input laporan kejadian baru, unggah dokumentasi foto, edit laporan miliknya, lihat rekapitulasi, serta cetak laporan PDF/Excel. |
| **Pimpinan** | `pimpinan@bpbd-pekanbaru.go.id` | `password` | *Read-only*: Akses dashboard eksekutif, grafik tren, peta sebaran, rekapitulasi periode, dan unduh laporan PDF/Excel siap tanda tangan. |

> **Catatan**: Halaman login dilengkapi tombol **1-Klik Kredensial Demo** sehingga penguji dapat langsung berpindah antar role tanpa mengetik manual.

---

## 🚀 Panduan Instalasi & Menjalankan Aplikasi

Aplikasi ini dapat dijalankan menggunakan **Laragon** atau **XAMPP** di sistem operasi Windows.

### 1. Prasyarat Sistem
- Windows 10 atau 11
- PHP 8.2 atau lebih baru dengan ekstensi: `pdo_sqlite`, `pdo_mysql`, `mbstring`, `gd`, `fileinfo`, `zip`
- Composer (manajer dependensi PHP)
- Node.js (v18+) & NPM

### 2. Langkah Instalasi (Local Setup)

1. **Buka terminal (PowerShell atau Git Bash) di direktori aplikasi**:
   ```bash
   cd "C:\Users\ASUS\.gemini\antigravity\scratch\bpbd-pekanbaru-app"
   ```

2. **Pastikan PHP dan Composer terdeteksi**:
   *Jika menggunakan Laragon, tambahkan PHP ke path sementara:*
   ```powershell
   $env:PATH = "C:\laragon\bin\php\php-8.3.30-nts-Win32-vs16-x64;C:\laragon\bin\nodejs\node-v22.22.2-win-x64;" + $env:PATH
   ```

3. **Salin file konfigurasi lingkungan**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Basis Data**:
   - **Opsi A (SQLite — Paling Cepat & Instan)**:
     Secara bawaan `.env` sudah terkonfigurasi menggunakan SQLite (`database/database.sqlite`), sehingga tidak memerlukan MySQL terpisah.
   - **Opsi B (MySQL via XAMPP / Laragon)**:
     Buka MySQL di XAMPP/Laragon, buat database bernama `bpbd_pekanbaru`, lalu ubah di file `.env`:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=bpbd_pekanbaru
     DB_USERNAME=root
     DB_PASSWORD=
     ```

5. **Jalankan Migrasi & Seeder Data Awal**:
   Perintah ini akan membuat seluruh tabel, 3 akun pengguna, master data 15 kecamatan & kelurahan resmi Pemko Pekanbaru, 8 jenis kejadian bencana, 12 instansi mitra, serta 25 data kejadian realistis:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Buat Symlink Storage (untuk upload foto dokumentasi)**:
   ```bash
   php artisan storage:link
   ```

7. **Kompilasi Aset Frontend (Tailwind CSS & JavaScript)**:
   ```bash
   npm run build
   ```

8. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Aplikasi siap diakses melalui browser di alamat: **http://127.0.0.1:8000**

---

## 🧪 Pengujian Otomatis Sistem (Test Suite)

Aplikasi dilengkapi suite pengujian otomatis yang menguji seluruh fungsionalitas kunci secara terpadu:
```bash
php run_all_tests.php
```

Modul yang diuji meliputi:
1. `Autentikasi & Akun`: Verifikasi role Admin, Petugas TRC, dan Pimpinan.
2. `Kejadian Bencana`: Generator nomor registrasi bulanan (`BPBD-PKU/YYYY/MM/XXXX`), form request validation, dan view detail.
3. `Dashboard Eksekutif`: 4 kartu metrik, 12 bulan tren Chart.js, dan 25+ titik peta sebaran Leaflet.
4. `Rekapitulasi`: Matriks silang 15 Kecamatan x 8 Jenis Kejadian.
5. `Ekspor Excel`: Validasi binary XLSX PhpSpreadsheet formula `=SUM()`.
6. `Cetak PDF Resmi`: Render Lembar Kejadian Tunggal (A4 Portrait) dan Rekapitulasi (A4 Landscape) DomPDF.
7. `Administrasi Admin`: Sinkronisasi pengaturan instansi ke PDF dan proteksi self-deletion akun admin.

---

## 📂 Struktur Direktori Utama

```
bpbd-pekanbaru-app/
├── app/
│   ├── Exports/
│   │   └── RekapKejadianExport.php         # Handler ekspor Excel native PhpSpreadsheet
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php      # Metrik, grafik Chart.js, peta sebaran
│   │   │   ├── KejadianController.php       # Form input, upload foto, tabel data & detail
│   │   │   ├── LaporanPdfController.php     # Cetak PDF Lembar Tunggal & Rekapitulasi
│   │   │   ├── MasterDataController.php     # CRUD Jenis Kejadian, Instansi, Wilayah
│   │   │   ├── PengaturanInstansiController.php # Kop surat, pejabat penandatangan, logo
│   │   │   ├── RekapController.php          # Rekap Harian/Bulanan/Tahunan & cross-tab matrix
│   │   │   └── UserController.php           # CRUD Pengguna & proteksi akun
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php           # Guard verifikasi role (admin, petugas, pimpinan)
│   │   └── Requests/
│   │       ├── StoreKejadianRequest.php     # Validasi Form Input Kejadian (Bahasa Indonesia)
│   │       └── UpdateKejadianRequest.php    # Validasi Edit Kejadian
│   └── Models/
│       ├── Kejadian.php                     # Model kejadian + generator nomor laporan
│       ├── FotoKejadian.php                 # Relasi multi-foto dokumentasi
│       ├── JenisKejadian.php                # Master klasifikasi bencana & warna penanda
│       ├── Kecamatan.php                    # 15 Kecamatan resmi Kota Pekanbaru
│       ├── Kelurahan.php                    # Kelurahan dependent dropdown
│       ├── InstansiPendukung.php            # Stakeholder / Mitra operasi PB
│       ├── PengaturanInstansi.php           # Kop dinas, nama Kalaksa, NIP, alamat
│       └── User.php                         # Akun sistem & status aktif
├── database/
│   ├── migrations/                          # Skema tabel database lengkap dengan FK & Index
│   └── seeders/                             # Data awal: User, Wilayah, Master, 25 Kejadian Dummy
├── resources/
│   └── views/
│       ├── admin/                           # Tampilan Manajemen User, Master Data, Pengaturan
│       ├── kejadian/                        # Form Tambah, Edit, Detail, Tabel Index
│       ├── laporan/                         # Pusat Cetak Dokumen PDF
│       ├── pdf/                             # Template DomPDF (A4 Portrait & Landscape)
│       └── rekap/                           # Halaman Rekapitulasi & Matriks Silang
├── routes/
│   └── web.php                              # Daftar route terproteksi role & middleware
├── DOKUMENTASI_MAGANG.md                    # Laporan teknis magang, ERD Mermaid & matriks route
├── README.md                                # Panduan instalasi dan dokumentasi umum
└── run_all_tests.php                        # Script automated testing sistem
```

---

## 🏛️ Hak Cipta & Lisensi
Dikembangkan untuk keperluan operasional **Badan Penanggulangan Bencana Daerah (BPBD) Kota Pekanbaru** sebagai bagian dari Proyek Magang Sistem Informasi.
Bebas dimodifikasi dan dikembangkan lebih lanjut untuk kemaslahatan mitigasi dan kesiapsiagaan bencana daerah.
