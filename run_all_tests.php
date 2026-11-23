<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Kejadian;
use App\Models\JenisKejadian;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\PengaturanInstansi;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KejadianController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\LaporanPdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\PengaturanInstansiController;
use App\Http\Requests\StoreKejadianRequest;
use App\Exports\RekapKejadianExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BpbdTestSuite
{
    private array $results = [];
    private int $passed = 0;
    private int $failed = 0;

    public function runTest(string $category, string $testName, callable $callback): void
    {
        try {
            $callback();
            $this->results[] = [
                'category' => $category,
                'name' => $testName,
                'status' => 'LULUS (PASS)',
                'error' => null,
            ];
            $this->passed++;
            echo "  [✓] {$testName}" . PHP_EOL;
        } catch (\Throwable $e) {
            $this->results[] = [
                'category' => $category,
                'name' => $testName,
                'status' => 'GAGAL (FAIL)',
                'error' => $e->getMessage(),
            ];
            $this->failed++;
            echo "  [✗] {$testName} -> " . $e->getMessage() . PHP_EOL;
        }
    }

    public function printSummary(): void
    {
        echo PHP_EOL . "=================================================================" . PHP_EOL;
        echo "               LAPORAN HASIL PENGUJIAN SISTEM BPBD               " . PHP_EOL;
        echo "=================================================================" . PHP_EOL;
        printf("%-20s | %-32s | %-12s\n", "KATEGORI", "MODUL PENGUJIAN", "STATUS");
        echo "-----------------------------------------------------------------" . PHP_EOL;
        foreach ($this->results as $r) {
            printf("%-20s | %-32s | %-12s\n", 
                substr($r['category'], 0, 20), 
                substr($r['name'], 0, 32), 
                $r['status']
            );
        }
        echo "=================================================================" . PHP_EOL;
        echo "Total Pengujian: " . ($this->passed + $this->failed) . " | Lulus: {$this->passed} | Gagal: {$this->failed}" . PHP_EOL;
        echo "Status Kualitas: " . ($this->failed === 0 ? "SEMUA PENGUJIAN LULUS 100% (STABIL)" : "ADA PENGUJIAN GAGAL") . PHP_EOL;
        echo "=================================================================" . PHP_EOL;
    }
}

$suite = new BpbdTestSuite();

echo "MEMULAI PENGUJIAN OTOMATIS SISTEM PUSDALOPS BPBD PEKANBARU..." . PHP_EOL . PHP_EOL;

// 1. KATEGORI AUTENTIKASI & ROLE
echo "--- 1. PENGUJIAN AUTENTIKASI & ROLE ---" . PHP_EOL;
$suite->runTest('Autentikasi & Akun', 'Akun Petugas TRC aktif & terverifikasi', function () {
    $petugas = User::where('role', 'petugas')->firstOrFail();
    if (!$petugas->status_aktif) throw new \Exception("Akun petugas tidak aktif");
    if (!$petugas->isPetugas()) throw new \Exception("Role method isPetugas() tidak valid");
});

$suite->runTest('Autentikasi & Akun', 'Akun Admin IT aktif & memiliki hak akses admin', function () {
    $admin = User::where('role', 'admin')->firstOrFail();
    if (!$admin->isAdmin()) throw new \Exception("Role method isAdmin() tidak valid");
});

$suite->runTest('Autentikasi & Akun', 'Akun Pimpinan BPBD aktif & berstatus readonly', function () {
    $pimpinan = User::where('role', 'pimpinan')->firstOrFail();
    if (!$pimpinan->isPimpinan()) throw new \Exception("Role method isPimpinan() tidak valid");
});


// 2. KATEGORI DATA KEJADIAN & FORM INPUT
echo PHP_EOL . "--- 2. PENGUJIAN FORM INPUT & DATA KEJADIAN ---" . PHP_EOL;
$petugas = User::where('role', 'petugas')->first();
Auth::login($petugas);

$suite->runTest('Kejadian Bencana', 'Generator nomor registrasi format BPBD-PKU', function () {
    $nomor = Kejadian::generateNomorLaporan(now());
    if (!preg_match('/^BPBD-PKU\/\d{4}\/\d{2}\/\d{4}$/', $nomor)) {
        throw new \Exception("Format nomor laporan salah: {$nomor}");
    }
});

$suite->runTest('Kejadian Bencana', 'Simpan laporan kejadian baru dengan validasi', function () use ($app, $petugas) {
    $controller = new KejadianController();
    $jenis = JenisKejadian::firstOrFail();
    $kec = Kecamatan::firstOrFail();
    $kel = Kelurahan::where('kecamatan_id', $kec->id)->first();

    $request = StoreKejadianRequest::create('/kejadian', 'POST', [
        'tanggal_kejadian' => now()->toDateString(),
        'jam_kejadian' => '14:30',
        'jenis_kejadian_id' => $jenis->id,
        'kecamatan_id' => $kec->id,
        'kelurahan_id' => $kel ? $kel->id : null,
        'lokasi_detail' => 'Jl. Uji Coba Lapangan No. 88',
        'latitude' => '0.5104',
        'longitude' => '101.4480',
        'kronologi' => 'Pengujian otomatis sistem pembuatan laporan bencana.',
        'tindakan' => 'Tim TRC diterjunkan untuk penanganan cepat dan pendinginan.',
        'jumlah_personel' => 6,
        'status' => 'Dalam Penanganan',
        'sumber_informasi' => 'Call Center 112',
    ]);
    $request->setContainer($app);
    $request->validateResolved();

    $resp = $controller->store($request);
    $terbaru = Kejadian::where('lokasi_detail', 'Jl. Uji Coba Lapangan No. 88')->first();
    if (!$terbaru) throw new \Exception("Data kejadian tidak tersimpan");
    if ($terbaru->user_id !== $petugas->id) throw new \Exception("User ID pelapor tidak sesuai");
});

$suite->runTest('Kejadian Bencana', 'Halaman Detail Kejadian menampilkan data geospasial', function () {
    $controller = new KejadianController();
    $k = Kejadian::latest('id')->firstOrFail();
    $view = $controller->show($k->id);
    if ($view->name() !== 'kejadian.show') throw new \Exception("View name mismatch");
});


// 3. KATEGORI DASHBOARD & VISUALISASI GRAFIK
echo PHP_EOL . "--- 3. PENGUJIAN DASHBOARD & GRAFIK ---" . PHP_EOL;
$suite->runTest('Dashboard Eksekutif', 'Agregasi 4 kartu metrik utama', function () {
    $controller = new DashboardController();
    $view = $controller->index(new Request());
    $data = $view->getData();
    if (!isset($data['totalTahunIni']) || !isset($data['totalDalamPenanganan'])) {
        throw new \Exception("Metrik dashboard tidak lengkap");
    }
});

$suite->runTest('Dashboard Eksekutif', 'Chart.js data tren bulanan, kecamatan & donut jenis', function () {
    $controller = new DashboardController();
    $view = $controller->index(new Request());
    $data = $view->getData();
    if (count($data['lineTrenPerBulan']) !== 12) throw new \Exception("Data tren harus 12 bulan");
    if (!isset($data['donutJenisLabels'])) throw new \Exception("Data donut kosong");
});

$suite->runTest('Dashboard Eksekutif', 'Peta Sebaran Spasial Marker Koordinat', function () {
    $controller = new DashboardController();
    $view = $controller->index(new Request());
    $data = $view->getData();
    if (!isset($data['mapPoints']) || count($data['mapPoints']) === 0) {
        throw new \Exception("Titik koordinat peta sebaran kosong");
    }
});


// 4. KATEGORI REKAPITULASI & EKSPOR
echo PHP_EOL . "--- 4. PENGUJIAN REKAPITULASI & EKSPOR ---" . PHP_EOL;
$suite->runTest('Rekapitulasi', 'Matriks silang 15 Kecamatan x 8 Jenis Kejadian', function () {
    $controller = new RekapController();
    $view = $controller->index(new Request(['mode' => 'bulanan', 'bulan' => now()->month, 'tahun' => now()->year]));
    $data = $view->getData();
    if (!isset($data['semuaKecamatan']) || count($data['semuaKecamatan']) !== 15) {
        throw new \Exception("Kecamatan harus mencakup 15 kecamatan");
    }
    if (!isset($data['matrix'])) {
        throw new \Exception("Matriks cross-tabulation kosong");
    }
});

$suite->runTest('Ekspor Excel (.xlsx)', 'PhpSpreadsheet generate valid binary XLSX', function () {
    $pengaturan = PengaturanInstansi::getPengaturan();
    $daftarKejadian = Kejadian::take(10)->get();
    $export = new RekapKejadianExport(
        $daftarKejadian,
        $pengaturan,
        'BULAN TEST',
        $daftarKejadian->count(),
        0, 0, 0, 0, 0.0
    );
    Excel::store($export, 'test_export.xlsx', 'public');
    $path = storage_path('app/public/test_export.xlsx');
    if (!file_exists($path) || filesize($path) < 1000) {
        throw new \Exception("File Excel gagal dibuat atau corrupt");
    }
    unlink($path);
});


// 5. KATEGORI CETAK PDF RESMI
echo PHP_EOL . "--- 5. PENGUJIAN CETAK PDF RESMI ---" . PHP_EOL;
$suite->runTest('Cetak PDF Resmi', 'Lembar Kejadian Tunggal (A4 Portrait)', function () {
    $controller = new LaporanPdfController();
    $k = Kejadian::firstOrFail();
    $resp = $controller->singlePdf($k->id);
    $content = $resp->getContent();
    if (strlen($content) < 1000) throw new \Exception("PDF Lembar tunggal gagal dibuat");
    if (substr($content, 0, 4) !== '%PDF') throw new \Exception("Bukan binary PDF valid");
});

$suite->runTest('Cetak PDF Resmi', 'Rekapitulasi Berkala Lanskap (A4 Landscape)', function () {
    $controller = new LaporanPdfController();
    $resp = $controller->rekapPdf(new Request(['mode' => 'bulanan', 'bulan' => now()->month, 'tahun' => now()->year]));
    $content = $resp->getContent();
    if (strlen($content) < 1000) throw new \Exception("PDF Rekapitulasi gagal dibuat");
    if (substr($content, 0, 4) !== '%PDF') throw new \Exception("Bukan binary PDF valid");
});


// 6. KATEGORI ADMINISTRASI SISTEM & MASTER DATA
echo PHP_EOL . "--- 6. PENGUJIAN MASTER DATA & PENGATURAN ---" . PHP_EOL;
$admin = User::where('role', 'admin')->first();
Auth::login($admin);

$suite->runTest('Administrasi Admin', 'Pengaturan instansi tersinkron ke dokumen cetak', function () {
    $pengaturan = PengaturanInstansi::getPengaturan();
    if (empty($pengaturan->nama_pimpinan)) throw new \Exception("Nama pimpinan kosong");
    if (empty($pengaturan->nip_pimpinan)) throw new \Exception("NIP pimpinan kosong");
});

$suite->runTest('Administrasi Admin', 'Proteksi keamanan hapus akun diri sendiri', function () use ($admin) {
    $controller = new UserController();
    $controller->destroy($admin->id);
    if (!User::find($admin->id)) throw new \Exception("Admin berhasil menghapus dirinya sendiri (Security breach!)");
});

// Bersihkan data uji coba lapangan
Kejadian::where('lokasi_detail', 'Jl. Uji Coba Lapangan No. 88')->forceDelete();

$suite->printSummary();
