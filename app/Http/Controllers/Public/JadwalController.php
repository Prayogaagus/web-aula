<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // 1. Kunci waktu HANYA pada bulan dan tahun saat ini
        $date = Carbon::now()->startOfMonth();
        $year = $date->year;
        $month = $date->month;

        // 2. Ambil data pemesanan yang berstatus 'Dikonfirmasi' atau 'Selesai' di bulan ini
        $bookings = Pemesanan::whereIn('status', ['Dikonfirmasi', 'Selesai'])
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get()
            ->keyBy(function ($item) {
                // Jadikan tanggal (hanya angkanya) sebagai key
                return Carbon::parse($item->tanggal)->format('j');
            });

        return view('public.jadwal', compact('date', 'bookings'));
    }
}