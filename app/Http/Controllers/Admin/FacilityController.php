<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Facility::query();

        if ($request->filled('search')) {
            $query->where('nama_fasilitas', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $facilities = $query->latest()->get();

        return view('admin.fasilitas', compact('facilities')); // sesuaikan dengan nama view Anda
    }

    // 1. FUNGSI SIMPAN DATA (TAMBAH BARU)
    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'kategori'       => 'required|string',
            'harga'          => 'required|integer|min:0', // Validasi Harga Wajib Angka
            'jumlah'         => 'required|integer|min:0',
        ]);

        // Otomatis menentukan status awal berdasarkan jumlah stok
        $status = ($request->jumlah > 0) ? 'Tersedia' : 'Tidak Tersedia';

        Facility::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'kategori'       => $request->kategori,
            'harga'          => $request->harga, // Pastikan harga disimpan
            'jumlah'         => $request->jumlah,
            'status'         => $status,
        ]);

        return redirect()->back()->with('success', 'Fasilitas baru berhasil ditambahkan beserta harganya!');
    }

    // 2. FUNGSI UPDATE DATA (EDIT)
    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'kategori'       => 'required|string',
            'harga'          => 'required|integer|min:0', // Validasi Harga Wajib Angka
            'jumlah'         => 'required|integer|min:0',
            'status'         => 'required|in:Tersedia,Tidak Tersedia',
        ]);

        // Jika jumlah diubah menjadi 0, paksa status jadi Tidak Tersedia secara otomatis
        $statusFinal = ($request->jumlah == 0) ? 'Tidak Tersedia' : $request->status;

        $facility->update([
            'nama_fasilitas' => $request->nama_fasilitas,
            'kategori'       => $request->kategori,
            'harga'          => $request->harga, // Pastikan harga ikut ter-update
            'jumlah'         => $request->jumlah,
            'status'         => $statusFinal,
        ]);

        return redirect()->back()->with('success', 'Data fasilitas dan harga sewa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();

        return redirect()->back()->with('success', 'Fasilitas berhasil dihapus!');
    }
}