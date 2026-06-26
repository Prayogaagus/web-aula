<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KritikSaran; // 1. Import Model KritikSaran
use Illuminate\Support\Facades\Auth; // 2. Import Facade Auth

class HomeController extends Controller
{
    public function index()
    {
        return view('public.home');
    }

    public function login()
    {
        return view('public.login');
    }

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

    /**
     * Menampilkan Halaman Kritik & Saran dan Mengambil Data dari SQL
     */
    public function kritik()
    {
        // Ambil data kritik saran terbaru beserta data user terkait (Eager Loading)
        $feedbacks = KritikSaran::with('user')->latest()->get();

        // Kirim variabel $feedbacks ke dalam file Blade
        return view('public.kritik-saran', compact('feedbacks'));
    }

    /**
     * Memproses dan Menyimpan Data Kritik & Saran ke SQL
     */
    public function storeKritik(Request $request)
    {
        // Pastikan pengguna sudah login terlebih dahulu
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengirim masukan.');
        }

        // Validasi input (nama & email dihapus dari validasi karena sudah melekat di user_id)
        $request->validate([
            'instansi' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'jenis_masukan' => 'required|string|in:Kritik,Saran,Apresiasi,Lainnya',
            'pesan' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Perintah untuk memasukkan data ke dalam database SQL
        KritikSaran::create([
            'user_id'    => Auth::id(), // Mengambil ID dari user yang sedang login
            'instansi'   => $request->instansi,
            'no_telepon' => $request->no_telepon,
            'jenis'      => $request->jenis_masukan, // Memetakan 'jenis_masukan' ke kolom 'jenis'
            'pesan'      => $request->pesan,
            'rating'     => $request->rating,
            // 'status' otomatis terisi oleh default nilai di database (misal: 'Pending' atau 'Tersedia')
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Kritik dan saran Anda berhasil dikirim.');
    }
}