<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    // Menampilkan halaman form
public function create() {
    // Tambahkan 'public.' di depan nama file
    return view('public.form-pemesanan'); 
}

    // Menyimpan data ke database
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama' => 'required',
            'telp' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'jenis_acara' => 'required',
            'jumlah_peserta' => 'nullable',
        ]);

        $fasilitas = $request->has('fasilitas') ? implode(', ', $request->fasilitas) : null;

        Pemesanan::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'instansi' => $request->instansi,
            'telp' => $request->telp,
            'email' => $request->email,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'jenis_acara' => $request->jenis_acara,
            'jumlah_peserta' => $request->jumlah_peserta,
            'fasilitas' => $fasilitas,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('pembayaran')->with('success', 'Data pemesanan berhasil disimpan!');
    }
}