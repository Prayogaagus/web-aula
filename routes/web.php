<?php

use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;

// Cukup definisikan satu rute utama dengan satu nama yang konsisten
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute autentikasi dan detail tetap aman di bawahnya
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/register', [HomeController::class, 'register'])->name('register');
Route::get('/detail-aula', [HomeController::class, 'detail'])->name('detail.aula');
Route::get('/jadwal', [HomeController::class, 'jadwal'])->name('jadwal');
Route::get('/kritik-saran', [HomeController::class, 'kritik'])->name('kritik');