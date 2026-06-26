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
    // 1. Menampilkan Semua Data & Kirim List Fasilitas ke View
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

    // 2. Menyimpan Pemesanan Baru (Sisi Admin)
    public function store(Request $request)
    {
        // 1. Validasi - Ditambahkan 'paket'
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'paket'          => 'required|in:Paket Resepsi,Paket Instansi Pendidikan', // Validasi Paket
            'nama'           => 'required|string|max:255',
            'instansi'       => 'nullable|string|max:255',
            'telp'           => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required',
            'jenis_acara'    => 'required|string|max:255',
            'jumlah_peserta' => 'required|integer|min:1',
            'catatan'        => 'nullable|string',
            'total'          => 'required|numeric|min:0',
            'status'         => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Selesai,Dibatalkan',
        ]);

        // 2. Database Transaction
        DB::transaction(function () use ($request) {
            
            $kodeUnik = 'AULA' . date('Ymd') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

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

            // Simpan Data Induk - Ditambahkan 'paket'
            Pemesanan::create([
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
                'fasilitas'      => $textFasilitas,
                'catatan'        => $request->catatan,
                'total'          => $request->total,
                'status'         => $request->status,
            ]);

            // (Logika fasilitas pivot tetap sama)
            // ... (kode pivot attachment Anda) ...
        });

        return redirect()->back()->with('success', 'Pemesanan berhasil disimpan!');
    }

    // 3. Memperbarui Data (Sisi Admin)
    public function update(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // Validasi - Ditambahkan 'paket'
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
            'total'          => 'required|numeric|min:0',
            'status'         => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Selesai,Dibatalkan',
        ]);

        // Gunakan hanya field yang valid untuk update agar lebih aman
        $pemesanan->update($request->only([
            'paket', 'nama', 'instansi', 'telp', 'tanggal', 
            'jam_mulai', 'jam_selesai', 'jenis_acara', 'jumlah_peserta', 
            'catatan', 'total', 'status'
        ]));

        return redirect()->back()->with('success', 'Data pemesanan berhasil diperbarui!');
    }

    // 4. Menghapus Data (Tetap sama)
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

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}