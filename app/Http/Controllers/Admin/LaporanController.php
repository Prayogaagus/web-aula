<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input filter, berikan default jika kosong
        $periode = $request->get('periode', '01 Juni 2026 - 30 Juni 2026');
        $statusPembayaran = $request->get('status_pembayaran', 'Semua');

        // 2. Pecah string rentang tanggal dari Flatpickr
        $dates = explode(" - ", $periode);
        if (count($dates) == 2) {
            $bulanIndo = [
                'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March',
                'April' => 'April', 'Mei' => 'May', 'Juni' => 'June',
                'Juli' => 'July', 'Agustus' => 'August', 'September' => 'September',
                'Oktober' => 'October', 'November' => 'November', 'Desember' => 'December'
            ];

            $dateStartEnglish = strtr($dates[0], $bulanIndo);
            $dateEndEnglish   = strtr($dates[1], $bulanIndo);

            $startDate = Carbon::parse($dateStartEnglish)->startOfDay()->format('Y-m-d');
            $endDate   = Carbon::parse($dateEndEnglish)->endOfDay()->format('Y-m-d');
        } else {
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate   = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        // 3. BUAT BASE QUERY UTAMA (Kunci Sinkronisasi Filter)
        $baseQuery = Pemesanan::query()->whereBetween('tanggal', [$startDate, $endDate]);

        if ($statusPembayaran !== 'Semua') {
            $baseQuery->where('status', $statusPembayaran);
        }

        // =========================================================================
        // 🔥 LOGIKA UNTUK UNDUH EXCEL (HANYA TABEL SAJA)
        // =========================================================================
        if ($request->get('export') === 'excel') {
            $namaFile = "Laporan_Pendapatan_Aula_" . date('Ymd_His') . ".xls";

            // Mengatur Header HTTP agar Browser Memaksa Download sebagai Excel
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$namaFile\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            // Ambil SEMUA data sesuai filter (Tanpa Paginate agar terunduh semua)
            $dataExcel = (clone $baseQuery)->orderBy('tanggal', 'desc')->get();

            // Mulai render struktur tabel mentah untuk Excel
            echo "<table border='1'>";
            echo "<thead>
                    <tr style='background-color: #1e3a8a; color: #ffffff; font-weight: bold;'>
                        <th>No</th>
                        <th>Kode Pemesanan</th>
                        <th>Nama Penyewa</th>
                        <th>Email</th>
                        <th>Jenis Acara</th>
                        <th>Tanggal Acara</th>
                        <th>Waktu (WIB)</th>
                        <th>Total Pendapatan (Rp)</th>
                        <th>Status Pembayaran</th>
                    </tr>
                  </thead>";
            echo "<tbody>";

            foreach ($dataExcel as $index => $item) {
                $no = $index + 1;
                $kode = $item->kode_pemesanan ?? 'AULA' . str_pad($item->id, 8, '0', STR_PAD_LEFT);
                $penyewa = $item->user->name ?? $item->nama;
                $email = $item->user->email ?? 'no-email@mail.com';
                $waktu = substr($item->jam_mulai, 0, 5) . ' - ' . substr($item->jam_selesai, 0, 5);
                $tanggalFormatted = Carbon::parse($item->tanggal)->translatedFormat('d F Y');

                echo "<tr>
                        <td style='text-align: center;'>{$no}</td>
                        <td>'{$kode}</td>
                        <td>{$penyewa}</td>
                        <td>{$email}</td>
                        <td>{$item->jenis_acara}</td>
                        <td>{$tanggalFormatted}</td>
                        <td style='text-align: center;'>{$waktu}</td>
                        <td style='text-align: right;'>{$item->total}</td>
                        <td>{$item->status}</td>
                      </tr>";
            }
            echo "</tbody>";
            echo "</table>";
            
            // Hentikan proses Laravel agar script view HTML bawah tidak ikut terunduh
            exit;
        }
        // =========================================================================

        // 4. HITUNG KARTU KPI
        $totalPendapatan = (clone $baseQuery)->sum('total');
        $totalTransaksi = (clone $baseQuery)->count();
        $rataRataTransaksi = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;
        $transaksiDikonfirmasi = (clone $baseQuery)->whereIn('status', ['Dikonfirmasi', 'Selesai'])->count();
        $persentaseDikonfirmasi = $totalTransaksi > 0 ? ($transaksiDikonfirmasi / $totalTransaksi) * 100 : 0;

        // 5. QUERY UNTUK GRAFIK/CHART
        $chartDataRaw = (clone $baseQuery)
            ->selectRaw('tanggal, SUM(total) as total_harian')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $chartLabels = [];
        $chartData = [];
        foreach ($chartDataRaw as $data) {
            $chartLabels[] = Carbon::parse($data->tanggal)->translatedFormat('d M');
            $chartData[] = (int) $data->total_harian;
        }

        // 6. QUERY UNTUK TABEL DI HALAMAN WEB (Menggunakan Paginate)
        $pemesananTerbaru = $baseQuery->orderBy('tanggal', 'desc')->paginate(10);

        // 7. Kirim data ke View Blade
        return view('admin.laporan', compact(
            'periode', 'statusPembayaran', 'totalPendapatan', 'totalTransaksi',
            'rataRataTransaksi', 'transaksiDikonfirmasi', 'persentaseDikonfirmasi',
            'chartLabels', 'chartData', 'pemesananTerbaru'
        ));
    }
}