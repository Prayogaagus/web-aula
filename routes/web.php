<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Public\PemesananController;

// Route Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail-aula', [HomeController::class, 'detail'])->name('detail.aula');
Route::get('/jadwal', [HomeController::class, 'jadwal'])->name('jadwal');
Route::get('/kritik-saran', [HomeController::class, 'kritik'])->name('kritik');

// Route Pemesanan
Route::get('/pemesanan', [PemesananController::class, 'create'])->middleware('auth')->name('pemesanan');
Route::post('/pemesanan', [PemesananController::class, 'store'])->middleware('auth')->name('pemesanan.store');

// Route Login & Register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Daftarkan rute pembayaran agar dikenali oleh Laravel
Route::get('/pembayaran', function () {
    return view('public.pembayaran'); // Pastikan Anda memiliki file resources/views/public/pembayaran.blade.php
})->middleware('auth')->name('pembayaran');

Route::get('/pembayaran/qris', function () { return view('public.pembayaran-qris'); })->name('pembayaran.qris');
Route::get('/pembayaran/sukses', function () { return view('public.pembayaran-sukses'); })->name('pembayaran.sukses');

Route::get('/invoice', function () {
    return view('public.invoice'); // Tambahkan 'public.' di depannya
});

Route::get('/kritik-saran', function () {
    return view('public.kritik-saran');
});

Route::get('/notifikasi', function () {
    return view('public.notifikasi');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});