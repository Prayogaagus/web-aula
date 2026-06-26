<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Facility;
use App\Models\Notification; // Pastikan model ini sudah ada
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function create() 
    {
        $facilities = Facility::all(); 
        return view('public.form-pemesanan', compact('facilities')); 
    }

    public function store(Request $request) 
    {
        // 1. Validasi Input
        $request->validate([
            'paket'          => 'required|in:Paket Resepsi,Paket Instansi Pendidikan',
            'nama'           => 'required|string|max:255',
            'instansi'       => 'nullable|string|max:255',
            'telp'           => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required',
            'jenis_acara'    => 'required|string|max:255',
            'jumlah_peserta' => 'required|integer',
            'fasilitas'      => 'nullable|array',
            'catatan'        => 'nullable|string',
        ]);

        // 2. Logika Fasilitas
        $fasilitasDipilih = $request->has('fasilitas') ? implode(', ', $request->fasilitas) : '';
        
        if ($request->filled('fasilitas_lainnya')) {
            $fasilitasDipilih = empty($fasilitasDipilih) 
                ? $request->fasilitas_lainnya 
                : $fasilitasDipilih . ', ' . $request->fasilitas_lainnya;
        }

        // 3. Generate Kode Pemesanan
        $kodeUnik = 'AULA' . date('Ymd') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

        // 4. Simpan ke Tabel Pemesanan
        $pemesanan = Pemesanan::create([
            'user_id'        => Auth::id(),
            'paket'          => $request->paket,
            'kode_pemesanan' => $kodeUnik,
            'nama'           => $request->nama,
            'instansi'       => $request->instansi,
            'telp'           => $request->telp,
            'tanggal'        => $request->tanggal,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'jenis_acara'    => $request->jenis_acara,
            'jumlah_peserta' => $request->jumlah_peserta,
            'fasilitas'      => $fasilitasDipilih ?: null,
            'catatan'        => $request->catatan,
            'total'          => 8950000,
            'status'         => 'Menunggu Konfirmasi',
        ]);

        // 5. TAMBAHAN: Buat Notifikasi Otomatis
        Notification::create([
            'user_id' => Auth::id(),
            'tipe'    => 'pesanan_berhasil', // Sesuaikan dengan logika switch di view Anda
            'judul'   => 'Pesanan Berhasil Dibuat',
            'pesan'   => 'Pesanan Anda dengan kode ' . $kodeUnik . ' telah berhasil. Klik untuk melihat detail invoice.',
            'url'     => route('invoice', ['kode' => $kodeUnik]), // Menyimpan link tujuan
        ]);

        return redirect()->route('invoice', ['kode' => $kodeUnik])->with('success', 'Data pemesanan berhasil disimpan!');
    }

    public function showInvoice($kode)
    {
        $pemesanan = Pemesanan::where('kode_pemesanan', $kode)->with('user')->firstOrFail();

        $splitFasilitas = $pemesanan->fasilitas ? explode(', ', $pemesanan->fasilitas) : [];

        return view('public.invoice', compact('pemesanan', 'splitFasilitas'));
    }
}