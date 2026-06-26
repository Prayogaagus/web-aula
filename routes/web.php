<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Public\PemesananController;
use App\Http\Controllers\Admin\PemesananController as AdminPemesananController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\KritikSaranController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\UserController;

// Route Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail-aula', [HomeController::class, 'detail'])->name('detail.aula');
Route::get('/jadwal', [\App\Http\Controllers\Public\JadwalController::class, 'index'])->name('jadwal');

// Rute Tampilan Halaman Kritik Saran (GET) dan Proses Simpan Data (POST)
Route::get('/kritik-saran', [HomeController::class, 'kritik'])->name('kritik');
Route::post('/kritik-saran', [HomeController::class, 'storeKritik'])->name('kritik.store');

// Route Pemesanan
Route::get('/pemesanan', [PemesananController::class, 'create'])->middleware('auth')->name('pemesanan');
Route::post('/pemesanan', [PemesananController::class, 'store'])->middleware('auth')->name('pemesanan.store');

// Route Login, Register, & Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Route Akses Pengguna Terautentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
});

Route::get('/invoice/{kode}', [App\Http\Controllers\Public\PemesananController::class, 'showInvoice'])->name('invoice');

// Route Halaman Manajemen Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna');
    Route::post('/pengguna', [UserController::class, 'store'])->name('pengguna.store');
    Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/fasilitas', [FacilityController::class, 'index'])->name('fasilitas');
    Route::post('/fasilitas', [FacilityController::class, 'store'])->name('fasilitas.store');
    Route::put('/fasilitas/{id}', [FacilityController::class, 'update'])->name('fasilitas.update');
    Route::delete('/fasilitas/{id}', [FacilityController::class, 'destroy'])->name('fasilitas.destroy');

    Route::get('/kritik-saran', [KritikSaranController::class, 'index'])->name('kritik-saran');
    Route::patch('/kritik-saran/{id}/status', [KritikSaranController::class, 'updateStatus'])->name('kritik-saran.status');
    Route::delete('/kritik-saran/{id}', [KritikSaranController::class, 'destroy'])->name('kritik-saran.destroy');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // CRUD Kelola Pemesanan Aula Sisi Admin
    Route::get('/pemesanan', [AdminPemesananController::class, 'index'])->name('pemesanan');
    Route::post('/pemesanan/store', [AdminPemesananController::class, 'store'])->name('pemesanan.store');
    Route::put('/pemesanan/{id}', [AdminPemesananController::class, 'update'])->name('pemesanan.update');
    Route::delete('/pemesanan/{id}', [AdminPemesananController::class, 'destroy'])->name('pemesanan.destroy');
});