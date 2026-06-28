<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\User;
use App\Models\Facility; 
use App\Models\Notification; // 1. IMPORT MODEL NOTIFIKASI DI SINI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with(['user', 'facilities']); // Pastikan load relationship facilities

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhere('jenis_acara', 'like', "%{$search}%")
                  ->orWhere('kode_pemesanan', 'like', "%{$search}%");
            });
        }

        $pemesanans = $query->latest()->paginate(10)->withQueryString();
        $users = User::where('role', 'penyewa')->get(); 
        $facilities = Facility::all(); 

        return view('admin.pemesanan', compact('pemesanans', 'users', 'facilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'paket'          => 'required|in:Paket Resepsi,Paket Instansi Pendidikan',
            'nama'           => 'required|string|max:255',
            'telp'           => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required',
            'jenis_acara'    => 'required|string|max:255',
            'jumlah_peserta' => 'required|integer|min:1',
            'fasilitas'      => 'nullable|array', 
            'total'          => 'nullable|numeric|min:0', 
            'status'         => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Selesai,Dibatalkan',
        ]);

        DB::transaction(function () use ($request) {
            $kodeUnik = 'AULA' . date('Ymd') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            $hargaFinal = $request->total ?: ($request->paket === 'Paket Resepsi' ? 8950000 : 4500000);

            $arrFasilitasNama = [];
            $fasilitasSync = [];

            // Loop array fasilitas
            if ($request->has('fasilitas')) {
                foreach ($request->fasilitas as $item) {
                    if (isset($item['id']) && isset($item['jumlah']) && $item['jumlah'] > 0) {
                        $facility = Facility::find($item['id']);
                        
                        if ($facility && $facility->jumlah >= $item['jumlah']) {
                            $facility->jumlah -= $item['jumlah'];
                            if ($facility->jumlah < 1) $facility->status = 'Tidak Tersedia';
                            $facility->save();

                            $arrFasilitasNama[] = $facility->nama_fasilitas . ' (' . $item['jumlah'] . ')';
                            $fasilitasSync[$facility->id] = ['jumlah_digunakan' => $item['jumlah']];
                        }
                    }
                }
            }

            $pemesanan = Pemesanan::create([
                'user_id'        => $request->user_id,
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
                'fasilitas'      => implode(', ', $arrFasilitasNama),
                'catatan'        => $request->catatan,
                'total'          => $hargaFinal, 
                'status'         => $request->status,
            ]);

            if (!empty($fasilitasSync)) {
                $pemesanan->facilities()->attach($fasilitasSync);
            }

            // 2. LOGIKA BARU: Kirim Notifikasi Awal saat Admin Membuat Pesanan Baru
            $tipeNotif = $request->status === 'Dikonfirmasi' ? 'pesanan_berhasil' : 'pembayaran_tertunda';
            Notification::create([
                'user_id'   => $request->user_id,
                'judul'     => 'Pesanan Aula Berhasil Dicatat',
                'pesan'     => 'Pesanan Anda dengan kode ' . $kodeUnik . ' telah dimasukkan oleh Admin. Status saat ini: ' . $request->status . '.',
                'tipe'      => $tipeNotif,
                'kategori'  => 'Pesanan',
                'is_read'   => false,
                'url'       => route('invoice', ['kode' => $kodeUnik]), // Mengarah langsung ke Invoice client
            ]);
        });

        return redirect()->back()->with('success', 'Pemesanan berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        $request->validate([
            'paket'          => 'required|in:Paket Resepsi,Paket Instansi Pendidikan',
            'nama'           => 'required|string|max:255',
            'telp'           => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required',
            'jenis_acara'    => 'required|string|max:255',
            'jumlah_peserta' => 'required|integer|min:1',
            'fasilitas'      => 'nullable|array',
            'total'          => 'nullable|numeric|min:0',
            'status'         => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Selesai,Dibatalkan',
        ]);

        DB::transaction(function () use ($request, $pemesanan) {
            // 1. KEMBALIKAN STOK LAMA
            foreach ($pemesanan->facilities as $old) {
                $old->jumlah += $old->pivot->jumlah_digunakan;
                $old->status = 'Tersedia';
                $old->save();
            }
            $pemesanan->facilities()->detach();

            // 2. HITUNG ULANG FASILITAS BARU
            $arrFasilitasNama = [];
            $fasilitasSync = [];

            if ($request->has('fasilitas')) {
                foreach ($request->fasilitas as $item) {
                    if (isset($item['id']) && isset($item['jumlah']) && $item['jumlah'] > 0) {
                        $facility = Facility::find($item['id']);
                        
                        if ($facility && $facility->jumlah >= $item['jumlah']) {
                            $facility->jumlah -= $item['jumlah'];
                            if ($facility->jumlah < 1) $facility->status = 'Tidak Tersedia';
                            $facility->save();

                            $arrFasilitasNama[] = $facility->nama_fasilitas . ' (' . $item['jumlah'] . ')';
                            $fasilitasSync[$facility->id] = ['jumlah_digunakan' => $item['jumlah']];
                        }
                    }
                }
            }

            $pemesanan->update([
                'paket'          => $request->paket,
                'nama'           => $request->nama,
                'instansi'       => $request->instansi,
                'telp'           => $request->telp,
                'tanggal'        => $request->tanggal,
                'jam_mulai'      => $request->jam_mulai,
                'jam_selesai'    => $request->jam_selesai,
                'jenis_acara'    => $request->jenis_acara,
                'jumlah_peserta' => $request->jumlah_peserta,
                'fasilitas'      => implode(', ', $arrFasilitasNama),
                'catatan'        => $request->catatan,
                'total'          => $request->total ?: $pemesanan->total,
                'status'         => $request->status,
            ]);

            if (!empty($fasilitasSync)) {
                $pemesanan->facilities()->attach($fasilitasSync);
            }

            // 3. LOGIKA BARU: Otomatis Buat Notifikasi Real-time Berdasarkan Perubahan Status oleh Admin
            $judulNotif = 'Pembaruan Status Pesanan';
            $isiPesan = 'Pesanan Anda dengan kode ' . $pemesanan->kode_pemesanan . ' saat ini berstatus: ' . $request->status . '.';
            $tipeNotif = 'pembayaran_tertunda';
            $kategoriNotif = 'Pesanan';

            switch ($request->status) {
                case 'Dikonfirmasi':
                    $judulNotif = 'Pesanan Anda Telah Dikonfirmasi!';
                    $isiPesan = 'Selamat, pesanan aula dengan kode ' . $pemesanan->kode_pemesanan . ' telah dikonfirmasi oleh Admin.';
                    $tipeNotif = 'pesanan_berhasil'; // Memicu ikon centang hijau di Blade klien
                    break;
                case 'Selesai':
                    $judulNotif = 'Acara Telah Selesai';
                    $isiPesan = 'Terima kasih telah menggunakan layanan aula kami untuk kode pesanan ' . $pemesanan->kode_pemesanan . '.';
                    $tipeNotif = 'verifikasi_dokumen'; 
                    $kategoriNotif = 'Pembaruan'; // Pindah tab ke Pembaruan jika diinginkan
                    break;
                case 'Dibatalkan':
                    $judulNotif = 'Pesanan Aula Dibatalkan';
                    $isiPesan = 'Mohon maaf, pesanan Anda dengan kode ' . $pemesanan->kode_pemesanan . ' telah dibatalkan oleh pihak pengelola.';
                    $tipeNotif = 'pembayaran_tertunda'; // Tetap amber/bisa disesuaikan
                    break;
            }

            Notification::create([
                'user_id'   => $pemesanan->user_id, // Mengarah ke user penyewa terkait
                'judul'     => $judulNotif,
                'pesan'     => $isiPesan,
                'tipe'      => $tipeNotif,
                'kategori'  => $kategoriNotif,
                'is_read'   => false,
                'url'       => route('invoice', ['kode' => $pemesanan->kode_pemesanan]), // Klik langsung ke invoice
            ]);
        });

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        
        DB::transaction(function () use ($pemesanan) {
            foreach ($pemesanan->facilities as $facility) {
                $facility->jumlah += $facility->pivot->jumlah_digunakan;
                $facility->status = 'Tersedia';
                $facility->save();
            }
            $pemesanan->facilities()->detach();
            $pemesanan->delete();
        });

        return redirect()->back()->with('success', 'Data dihapus!');
    }
}