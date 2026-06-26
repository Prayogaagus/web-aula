<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter kategori dari tab menu (?kategori=Pesanan)
        $filterKategori = $request->get('kategori', 'Semua');

        // Mengambil notifikasi HANYA milik user yang sedang login saat ini
        $query = auth()->user()->notifications();

        if ($filterKategori !== 'Semua') {
            $query->where('kategori', $filterKategori);
        }

        $notifications = $query->get();

        return view('public.notifikasi', compact('notifications', 'filterKategori'));
    }
}