<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KejadianController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\LaporanPdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\PengaturanInstansiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Root redirect
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authenticated Routes (Semua Role: Admin, Petugas, Pimpinan)
Route::middleware(['auth', 'role:admin,petugas,pimpinan'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Kejadian (Melihat data, detail & halaman sukses)
    Route::get('/kejadian', [KejadianController::class, 'index'])->name('kejadian.index');
    Route::get('/kejadian/detail/{id}', [KejadianController::class, 'show'])->name('kejadian.show');
    Route::get('/kejadian/sukses/{id}', [KejadianController::class, 'success'])->name('kejadian.success');

    // Rekapitulasi & Ekspor
    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap.index');
    Route::get('/rekap/excel', [RekapController::class, 'exportExcel'])->name('rekap.excel');

    // Menu & Cetak PDF Laporan
    Route::get('/laporan/pdf', [LaporanPdfController::class, 'menu'])->name('laporan.pdf-menu');
    Route::get('/laporan/pdf/kejadian/{id}', [LaporanPdfController::class, 'singlePdf'])->name('laporan.pdf-single');
    Route::get('/laporan/pdf/rekap', [LaporanPdfController::class, 'rekapPdf'])->name('laporan.pdf-rekap');

    // Profil Akun
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Petugas & Admin Routes (Input, Edit, & Hapus Laporan)
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/kejadian/tambah', [KejadianController::class, 'create'])->name('kejadian.create');
    Route::post('/kejadian', [KejadianController::class, 'store'])->name('kejadian.store');
    Route::get('/kejadian/edit/{id}', [KejadianController::class, 'edit'])->name('kejadian.edit');
    Route::put('/kejadian/{id}', [KejadianController::class, 'update'])->name('kejadian.update');
    Route::delete('/kejadian/{id}', [KejadianController::class, 'destroy'])->name('kejadian.destroy');
    Route::delete('/kejadian/foto/{id}', [KejadianController::class, 'hapusFoto'])->name('kejadian.foto.destroy');
});

// Admin Only Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Manajemen Pengguna
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Master Data
    Route::get('/master', [MasterDataController::class, 'index'])->name('master.index');
    Route::post('/master/jenis', [MasterDataController::class, 'storeJenis'])->name('master.jenis.store');
    Route::put('/master/jenis/{id}', [MasterDataController::class, 'updateJenis'])->name('master.jenis.update');
    Route::delete('/master/jenis/{id}', [MasterDataController::class, 'destroyJenis'])->name('master.jenis.destroy');

    Route::post('/master/instansi', [MasterDataController::class, 'storeInstansi'])->name('master.instansi.store');
    Route::put('/master/instansi/{id}', [MasterDataController::class, 'updateInstansi'])->name('master.instansi.update');
    Route::delete('/master/instansi/{id}', [MasterDataController::class, 'destroyInstansi'])->name('master.instansi.destroy');

    Route::post('/master/kelurahan', [MasterDataController::class, 'storeKelurahan'])->name('master.kelurahan.store');
    Route::delete('/master/kelurahan/{id}', [MasterDataController::class, 'destroyKelurahan'])->name('master.kelurahan.destroy');

    // Pengaturan Instansi
    Route::get('/pengaturan', [PengaturanInstansiController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [PengaturanInstansiController::class, 'update'])->name('pengaturan.update');
});

require __DIR__.'/auth.php';
