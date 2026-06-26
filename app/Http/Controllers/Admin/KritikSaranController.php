<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KritikSaran;
use Illuminate\Http\Request;

class KritikSaranController extends Controller
{
    public function index(Request $request)
    {
        // Gunakan .with('user') untuk memuat data relasi user sekaligus
        $query = KritikSaran::with('user');

        // Fitur Pencarian Nama (di tabel users) atau Pesan (di tabel kritik_sarans)
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('pesan', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $tab = $request->get('tab', 'semua');
        if ($tab == 'kritik') { $query->where('jenis', 'Kritik'); }
        elseif ($tab == 'saran') { $query->where('jenis', 'Saran'); }
        elseif ($tab == 'ditindaklanjuti') { $query->where('status', 'Ditindaklanjuti'); }
        elseif ($tab == 'belum_ditindaklanjuti') { $query->where('status', 'Belum Ditindaklanjuti'); }

        if ($request->get('sort') == 'terlama') { 
    // Jika terlama, urutkan tanggal ASC, lalu ID ASC
    $query->orderBy('created_at', 'asc')->orderBy('id', 'asc'); 
} else { 
    // Jika terbaru, urutkan tanggal DESC, lalu ID DESC
    $query->orderBy('created_at', 'desc')->orderBy('id', 'desc'); 
}

        $masukan = $query->paginate(7)->withQueryString();

        $stats = [
            'total' => KritikSaran::count(),
            'kritik' => KritikSaran::where('jenis', 'Kritik')->count(),
            'saran' => KritikSaran::where('jenis', 'Saran')->count(),
            'ditindaklanjuti' => KritikSaran::where('status', 'Ditindaklanjuti')->count(),
        ];

        return view('admin.kritik_saran', compact('masukan', 'stats', 'tab'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Ditindaklanjuti,Belum Ditindaklanjuti']);
        KritikSaran::findOrFail($id)->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status respon berhasil diperbarui.');
    }

    public function destroy($id)
    {
        KritikSaran::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data kritik/saran berhasil dihapus.');
    }
}