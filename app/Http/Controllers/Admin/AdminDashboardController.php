<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pemesanan;
use App\Models\KritikSaran; 
use Illuminate\Http\Request; // Pastikan ini di-import
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    // Tambahkan Request $request di sini
    public function index(Request $request)
    {
        // 1. Statistik
        $totalPengguna = User::count();
        $penggunaHariIni = User::whereDate('created_at', Carbon::today())->count();
        $totalPemesanan = Pemesanan::count();
        $totalPendapatan = Pemesanan::where('status', 'selesai')->sum('total'); 
        $menungguVerifikasi = Pemesanan::where('status', 'Menunggu Konfirmasi')->count();
        
        // 2. Ambil data aktivitas untuk dashboard
        $pemesanan = Pemesanan::latest()->take(3)->get();
        $users = User::latest()->take(3)->get();
        $kritik = KritikSaran::latest()->take(3)->get();

        $aktivitasTerbaru = $pemesanan->concat($users)->concat($kritik)
                                       ->sortByDesc('created_at')
                                       ->take(5);

        // 3. Logic Sorting untuk Widget Recent Pemesanan
        // Mengambil input dari select option (default ke 'terbaru')
        $sort = $request->get('sort', 'terbaru');
        $direction = ($sort === 'terlama') ? 'asc' : 'desc';

        $recentPemesanan = Pemesanan::orderBy('created_at', $direction)->take(5)->get();

        // 4. Kirim ke view
        return view('admin.dashboard', compact(
            'totalPengguna', 
            'penggunaHariIni', 
            'totalPemesanan', 
            'totalPendapatan',
            'aktivitasTerbaru', 
            'menungguVerifikasi', 
            'recentPemesanan'
        ));
    }
}