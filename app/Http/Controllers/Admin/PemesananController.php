<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\User;
use App\Models\Facility; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class PemesananController extends Controller
{
    /**
     * 1. Menampilkan Semua Data
     */
    public function index(Request $request)
    {
        $query = Pemesanan::with('user');

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

    /**
     * 2. Menyimpan Pemesanan Baru (Sisi Admin)
     */
    public function store(Request $request)
    {
        // Validasi data input (total diubah menjadi nullable)
        $request->validate([
            'user_id'        => 'required|exists:users,id',
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
            'total'          => 'nullable|numeric|min:0', // Ubah jadi nullable agar tidak wajib diisi manual
            'status'         => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Selesai,Dibatalkan',
        ]);

        DB::transaction(function () use ($request) {
            $kodeUnik = 'AULA' . date('Ymd') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

            // LOGIKA OTOMATISASI HARGA BERDASARKAN PAKET
            $hargaFinal = $request->total;
            if (empty($hargaFinal)) {
                if ($request->paket === 'Paket Resepsi') {
                    $hargaFinal = 8950000;
                } elseif ($request->paket === 'Paket Instansi Pendidikan') {
                    $hargaFinal = 4500000;
                }
            }

            // Membuat ringkasan teks untuk kolom 'fasilitas'
            $arrFasilitasNama = [];
            if ($request->has('fasilitas')) {
                foreach ($request->fasilitas as $item) {
                    if (isset($item['id']) && isset($item['jumlah']) && $item['jumlah'] > 0) {
                        $fac = Facility::find($item['id']);
                        if ($fac) {
                            $arrFasilitasNama[] = $fac->nama_fasilitas . ' (' . $item['jumlah'] . ')';
                        }
                    }
                }
            }
            $textFasilitas = implode(', ', $arrFasilitasNama);

            // Simpan Data Induk Pemesanan
            $pemesanan = Pemesanan::create([
                'user_id'         => $request->user_id,
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
                'fasilitas'       => $textFasilitas,
                'catatan'         => $request->catatan,
                'total'           => $hargaFinal, // Menyimpan harga paket otomatis atau input manual
                'status'          => $request->status,
            ]);

            // Potong Stok Gudang & Sinkronisasi ke Pivot Table
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

                        $pemesanan->facilities()->attach($facility->id, ['jumlah_digunakan' => $item['jumlah']]);
                    }
                }
            }
        });

        return redirect()->back()->with('success', 'Pemesanan berhasil disimpan dan harga disesuaikan otomatis!');
    }

    /**
     * 3. Memperbarui Data (Sisi Admin)
     */
    public function update(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // Validasi data input (total diubah menjadi nullable)
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
            'total'          => 'nullable|numeric|min:0', // Ubah jadi nullable
            'status'         => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Selesai,Dibatalkan',
        ]);

        DB::transaction(function () use ($request, $pemesanan) {
            // LOGIKA OTOMATISASI HARGA SAAT EDIT DATA
            $hargaFinal = $request->total;
            if (empty($hargaFinal)) {
                if ($request->paket === 'Paket Resepsi') {
                    $hargaFinal = 8950000;
                } elseif ($request->paket === 'Paket Instansi Pendidikan') {
                    $hargaFinal = 4500000;
                }
            }

            // Kembalikan semua stok fasilitas lama terlebih dahulu
            foreach ($pemesanan->facilities as $oldFacility) {
                $oldFacility->jumlah += $oldFacility->pivot->jumlah_digunakan;
                $oldFacility->status = 'Tersedia';
                $oldFacility->save();
            }
            $pemesanan->facilities()->detach();

            // Hitung ulang pilihan fasilitas baru dari form edit
            $arrFasilitasNama = [];
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

                        $arrFasilitasNama[] = $facility->nama_fasilitas . ' (' . $item['jumlah'] . ')';
                        $pemesanan->facilities()->attach($facility->id, ['jumlah_digunakan' => $item['jumlah']]);
                    }
                }
            }
            $textFasilitas = implode(', ', $arrFasilitasNama);

            // Update data master pemesanan di database SQL
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
                'fasilitas'      => $textFasilitas, 
                'catatan'        => $request->catatan,
                'total'          => $hargaFinal, // Menyimpan harga baru hasil penyesuaian paket
                'status'         => $request->status,
            ]);
        });

        return redirect()->back()->with('success', 'Data pemesanan dan nominal harga berhasil diperbarui!');
    }

    /**
     * 4. Menghapus Data (Mengembalikan Stok)
     */
    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        
        DB::transaction(function () use ($pemesanan) {
            foreach ($pemesanan->facilities as $facility) {
                $jumlahKembali = $facility->pivot->jumlah_digunakan;
                $facility->jumlah += $jumlahKembali;
                $facility->status = 'Tersedia';
                $facility->save();
            }
            
            $pemesanan->facilities()->detach();
            $pemesanan->delete();
        });

        return redirect()->back()->with('success', 'Data berhasil dihapus dan stok dikembalikan!');
    }
}