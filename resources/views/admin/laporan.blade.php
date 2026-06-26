<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - Penyewaan Aula POLMAN Babel</title>
    <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <nav class="navbar">
        <div class="nav-brand">
            <img src="{{ asset('images/Logo_Polman.png') }}" alt="Logo">
            <div>
                <div class="brand-title">Penyewaan Aula</div>
                <div class="brand-subtitle">POLMAN Babel</div>
            </div>
        </div>

        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.pengguna') }}">Pengguna</a>
            <a href="{{ route('admin.pemesanan') }}">Pemesanan</a>
            <a href="{{ route('admin.fasilitas') }}">Fasilitas</a>
            <a href="{{ route('admin.kritik-saran') }}">Kritik & Saran</a>
            <a href="{{ route('admin.laporan.index') }}" class="active">Laporan</a>
        </div>

        <div class="nav-user">
            <div class="user-avatar">AU</div>
            <span class="user-name">Admin Utama</span>
        </div>
    </nav>

    <div class="hero-header" style="background-image: linear-gradient(rgba(15, 32, 67, 0.85), rgba(15, 32, 67, 0.85)), url('{{ asset('images/aula_polman.jpeg') }}');">
        <h1>Laporan Pendapatan</h1>
        <p>Pantau dan analisis pendapatan dari setiap pemesanan Aula.</p>
    </div>

    <div class="main-container">
        
        <div class="card-filter">
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="filter-form" id="filterForm">
                <div class="input-group period">
                    <label>Periode</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fa-regular fa-calendar"></i></span>
                        <input type="text" id="periode" name="periode" value="{{ $periode }}" placeholder="01 Mei 2026 - 31 Mei 2026" class="input-field" readonly>
                    </div>
                </div>

                <div class="input-group status">
                    <label>Status Pembayaran</label>
                    <select name="status_pembayaran" onchange="this.form.submit()" class="select-field">
                        <option value="Semua" {{ $statusPembayaran == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="Menunggu Konfirmasi" {{ $statusPembayaran == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="Dikonfirmasi" {{ $statusPembayaran == 'Dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                        <option value="Selesai" {{ $statusPembayaran == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </form>

            <div>
                <a href="{{ route('admin.laporan.index', array_merge(request()->query(), ['export' => 'excel'])) }}" class="btn-download" style="text-decoration: none;">
                    <i class="fa-solid fa-download"></i>
                    <span>Unduh Laporan</span>
                </a>
            </div>
        </div>

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <div class="kpi-label">Total Pendapatan</div>
                    <div class="kpi-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="kpi-trend"><i class="fa-solid fa-arrow-trend-up"></i> +12% dari periode lalu</div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon"><i class="fa-regular fa-calendar-check"></i></div>
                <div>
                    <div class="kpi-label">Total Transaksi</div>
                    <div class="kpi-value">{{ $totalTransaksi }}</div>
                    <div class="kpi-trend"><i class="fa-solid fa-arrow-trend-up"></i> +5 dari periode lalu</div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon amber"><i class="fa-solid fa-rotate-left"></i></div>
                <div>
                    <div class="kpi-label">Rata-rata per Transaksi</div>
                    <div class="kpi-value">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</div>
                    <div class="kpi-trend"><i class="fa-solid fa-arrow-trend-up"></i> +8% dari periode lalu</div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon"><i class="fa-solid fa-wallet"></i></div>
                <div>
                    <div class="kpi-label">Pembayaran Dikonfirmasi</div>
                    <div class="kpi-value">{{ $transaksiDikonfirmasi }}</div>
                    <div class="kpi-trend" style="color:#2563eb;">{{ number_format($persentaseDikonfirmasi, 2) }}% dari total</div>
                </div>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3>Grafik Pendapatan</h3>
                <select class="chart-select">
                    <option>Per Hari</option>
                    <option>Per Bulan</option>
                </select>
            </div>
            <div class="chart-wrapper">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h3>Pemesanan Terbaru</h3>
                <a href="#">Lihat Semua</a>
            </div>
            
            <div class="responsive-table-outer">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Kode Pemesanan</th>
                            <th>Penyewa</th>
                            <th>Acara</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemesananTerbaru as $index => $item)
                        <tr>
                            <td class="text-center text-col-no">{{ $pemesananTerbaru->firstItem() + $index }}</td>
                            <td class="text-col-code">{{ $item->kode_pemesanan ?? 'AULA'.str_pad($item->id, 8, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="text-col-bold">{{ $item->user->name ?? $item->nama }}</div>
                                <div class="text-col-subtext">{{ $item->user->email ?? 'no-email@mail.com' }}</div>
                            </td>
                            <td class="text-col-bold" style="color: #475569;">{{ $item->jenis_acara }}</td>
                            <td>
                                <div class="text-col-bold" style="color: #475569;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                                <div class="text-col-subtext">{{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }} WIB</div>
                            </td>
                            <td class="text-col-bold" style="color: #1e293b;">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="status-badge 
                                    {{ $item->status == 'Selesai' ? 'selesai' : '' }}
                                    {{ $item->status == 'Dikonfirmasi' ? 'dikonfirmasi' : '' }}
                                    {{ $item->status == 'Menunggu Konfirmasi' ? 'menunggu' : '' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-col-no" style="padding: 3rem 0;">Belum ada data pemesanan terdata di periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pemesananTerbaru->hasPages())
                <div class="table-pagination">
                    {{ $pemesananTerbaru->links() }}
                </div>
            @endif
        </div>
    </div>

    <footer class="footer">
        <div class="footer-grid">
            <div>
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                    <img src="{{ asset('images/Logo_Polman.png') }}" style="height: 2rem; width: auto; filter: brightness(0) invert(1);" alt="Logo">
                    <span class="footer-brand-title">Penyewaan Aula</span>
                </div>
                <p class="footer-desc">Politeknik Manufaktur Negeri Bangka Belitung - Sistem Pemesanan Aula Serbaguna.</p>
            </div>
            <div class="footer-column">
                <h4>Tautan</h4>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#">Detail Aula</a></li>
                    <li><a href="#">Jadwal</a></li>
                    <li><a href="#">Kritik & Saran</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="#">Sewa Aula</a></li>
                    <li><a href="#">Cek Ketersediaan</a></li>
                    <li><a href="#">Panduan Pemesanan</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Hubungi Kami</h4>
                <p style="margin-bottom: 0.5rem;">Jl. Timah Raya, Kawasan Industri Airkantung, Sungailiat, Bangka 33211</p>
                <p style="margin-bottom: 0.5rem;">+62-717-31341</p>
                <p style="color: #64748b;">info@polman-babel.ac.id</p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 Sistem Penyewaan Aula POLMAN Babel. Semua hak cipta dilindungi.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. INISIALISASI KALENDER (FLATPICKR)
            flatpickr("#periode", {
                mode: "range", 
                dateFormat: "d F Y",
                locale: {
                    ...flatpickr.l10ns.id, // Set bahasa Indonesia
                    rangeSeparator: " - "  // Pemisah string " - "
                },
                allowInput: false, // Blokir ketik manual
                // Fungsi otomatis kirim form (submit) ketika selesai memilih dua rentang tanggal
                onClose: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        document.getElementById('filterForm').submit();
                    }
                }
            });

            // 2. INISIALISASI GRAFIK PENDAPATAN (CHART.JS)
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const labelsData = @json($chartLabels);
            const revenueData = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelsData.length ? labelsData : ['1 Mei', '5 Mei', '10 Mei', '15 Mei', '20 Mei', '25 Mei', '30 Mei', '10 Juni'],
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: revenueData.length ? revenueData : [600000, 1100000, 1050000, 600000, 2200000, 2450000, 2600000, 3100000],
                        borderColor: '#1e3a8a',
                        backgroundColor: 'rgba(30, 58, 138, 0.04)',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#1e3a8a',
                        pointHoverRadius: 6,
                        tension: 0.35,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000) + 'M';
                                    if (value >= 1000) return (value / 1000) + 'k';
                                    return value;
                                },
                                font: { size: 10, weight: 'bold' }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '600' } }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>