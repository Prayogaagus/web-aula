<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter kategori dari tab menu (?kategori=Pesanan)
        $filterKategori = $request->get('kategori', 'Semua');

        // UBAH BARIS INI: Panggil fungsi relasi baru yang tidak bentrok
        $query = auth()->user()->customNotifications();

        if ($filterKategori !== 'Semua') {
            $query->where('kategori', $filterKategori);
        }

        $notifications = $query->get();

        return view('public.notifikasi', compact('notifications', 'filterKategori'));
    }
}