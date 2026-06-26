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

        // Fitur Pencarian (Sudah diperbaiki dengan Grouping Clause)
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama_fasilitas', 'like', '%' . $request->search . '%')
                  ->orWhere('kategori', 'like', '%' . $request->search . '%');
            });
        }

        // Fitur Filter Kategori
        if ($request->has('kategori') && $request->kategori != 'Semua Kategori' && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $facilities = $query->get();
        return view('admin.fasilitas', compact('facilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jumlah' => 'required|integer|min:0',
        ]);

        // Saat tambah baru, status otomatis berdasarkan jumlah unit
        $status = $request->jumlah > 0 ? 'Tersedia' : 'Tidak Tersedia';

        Facility::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'status' => $status,
        ]);

        return redirect()->back()->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jumlah' => 'required|integer|min:0',
            'status' => 'required|string', // Validasi input status dari modal edit
        ]);

        $facility = Facility::findOrFail($id);

        // Menggunakan status pilihan dari form edit langsung
        $facility->update([
            'nama_fasilitas' => $request->nama_fasilitas,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'status' => $request->status, 
        ]);

        return redirect()->back()->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();

        return redirect()->back()->with('success', 'Fasilitas berhasil dihapus.');
    }
}