<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Utama / Beranda
     */
    public function index()
    {
        // Untuk tahap awal, kita langsung return view (tampilan).
        // Kedepannya, di sini kita akan mengambil data ketersediaan aula dari database.
        return view('public.home');
    }

    /**
     * Menampilkan Halaman Form Login (Masuk)
     */
    public function login()
    {
        return view('public.login');
    }

    /**
     * Menampilkan Halaman Form Register (Daftar)
     */
    public function register()
    {
        return view('public.register');
    }

    public function detail()
    {
    return view('public.detail');
    }
    public function jadwal()
    {
    return view('public.jadwal');
    }
    public function kritik()
{
    return view('public.kritik');
}
}