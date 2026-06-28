<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Facility; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function create() 
    {
        // Hanya memunculkan fasilitas yang stoknya di atas 0
        $facilities = Facility::where('jumlah', '>', 0)->get(); 
        return view('public.form-pemesanan', compact('facilities')); 
    }

    public function store(Request $request) 
{
    $request->validate([
        'paket'          => 'required|in:Paket Resepsi,Paket Instansi Pendidikan',
        'nama'           => 'required|string|max:255',
        'instansi'       => 'nullable|string|max:255',
        'telp'           => 'required|string|max:255',
        'tanggal'        => 'required|date',
        'jam_mulai'      => 'required',
        'jam_selesai'    => 'required',
        'jenis_acara'    => 'required|string|max:255',
        'jumlah_peserta' => 'required|integer|min:1',
        'catatan'        => 'nullable|string',
    ]);

    $kodeUnik = 'AULA' . date('Ymd') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

    $pemesanan = DB::transaction(function () use ($request, $kodeUnik) {
        
        // 1. Tentukan Harga Dasar Paket Pilihan
        $hargaPaket = ($request->paket === 'Paket Resepsi') ? 8950000 : 4500000;
        $totalBiayaFasilitas = 0;
        $arrFasilitasNama = [];

        // 2. Hitung Fasilitas Tambahan Sesuai Kuantitas Pilihan User
        if ($request->has('fasilitas')) {
            foreach ($request->fasilitas as $item) {
                if (isset($item['id']) && isset($item['jumlah']) && $item['jumlah'] > 0) {
                    $facility = Facility::find($item['id']);
                    // Validasi pengaman stok dari sisi server
                    if ($facility && $facility->jumlah >= $item['jumlah']) {
                        $totalBiayaFasilitas += $facility->harga * $item['jumlah'];
                        $arrFasilitasNama[] = $facility->nama_fasilitas . ' (' . $item['jumlah'] . ')';
                    }
                }
            }
        }

        // Tambahkan text fasilitas kustom "Lainnya" jika diisi
        if ($request->filled('fasilitas_lainnya')) {
            $arrFasilitasNama[] = 'Kebutuhan Khusus: ' . $request->fasilitas_lainnya;
        }

        $totalAkhir = $hargaPaket + $totalBiayaFasilitas;
        $textFasilitas = implode(', ', $arrFasilitasNama);

        // 3. Masukkan Data ke SQL Tabel Pemesanan Utama
        $newPemesanan = Pemesanan::create([
            'user_id'         => Auth::id(),
            'paket'           => $request->paket,
            'kode_pemesanan'  => $kodeUnik,
            'nama'            => $request->nama,
            'instansi'        => $request->instansi,
            'telp'            => $request->telp,
            'tanggal'         => $request->tanggal,
            'jam_mulai'       => $request->jam_mulai,
            'jam_selesai'     => $request->jam_selesai,
            'jenis_acara'     => $request->jenis_acara,
            'jumlah_peserta'  => $request->jumlah_peserta,
            'fasilitas'       => $textFasilitas ?: null,
            'catatan'         => $request->catatan,
            'total'           => $totalAkhir, 
            'status'          => 'Menunggu Konfirmasi',
        ]);

        // 4. Potong Stok Gudang & Hubungkan Relasi Banyak-ke-Banyak (Pivot)
        if ($request->has('fasilitas')) {
            foreach ($request->fasilitas as $item) {
                if (!isset($item['id']) || !isset($item['jumlah']) || $item['jumlah'] <= 0) continue;

                $facility = Facility::find($item['id']);
                if ($facility && $facility->jumlah >= $item['jumlah']) {
                    $facility->jumlah -= $item['jumlah'];
                    if ($facility->jumlah < 1) {
                        $facility->status = 'Tidak Tersedia';
                    }
                    $facility->save();

                    $newPemesanan->facilities()->attach($facility->id, ['jumlah_digunakan' => $item['jumlah']]);
                }
            }
        }

        return $newPemesanan;
    });

    return redirect()->route('invoice', ['kode' => $pemesanan->kode_pemesanan])->with('success', 'Pemesanan berhasil diajukan!');
}

    public function showInvoice($kode)
    {
        $pemesanan = Pemesanan::where('kode_pemesanan', $kode)->with('user')->firstOrFail();
        $splitFasilitas = $pemesanan->fasilitas ? explode(', ', $pemesanan->fasilitas) : [];

        return view('public.invoice', compact('pemesanan', 'splitFasilitas'));
    }
}