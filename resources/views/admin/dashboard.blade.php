<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Penyewaan Aula POLMAN Babel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}?v={{ time() }}">
    
</head>
<body>

    <nav class="navbar">
        <div class="nav-brand">
    <img src="{{ asset('images/Logo_Polman.png') }}" class="nav-logo">
    <div class="brand-text">
        <div class="brand-title">Penyewaan Aula</div>
        <div class="brand-subtitle">POLMAN Babel</div>
    </div>
</div>
        <div class="nav-links">
            <a href="#" class="active">Dashboard</a>
            <a href="#">Pengguna</a>
            <a href="#">Pemesanan</a>
            <a href="#">Pembayaran</a>
        </div>
        <div class="user-profile">
            <div class="avatar">AU</div>
            <span>Admin Utama</span>
        </div>
    </nav>

<section class="hero-section" style="background-image: linear-gradient(rgba(11, 58, 122, 0.85), rgba(11, 58, 122, 0.85)), url('{{ asset("images/aula_polman.jpeg") }}');">
    
    <h1>Dashboard Admin</h1>
    <p>Ringkasan aktivitas sistem pemesanan aula.</p>

</section>

    <main class="main-container">
        
        <div class="stat-cards-wrapper">
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-user-group"></i></div>
                <div class="stat-details">
                    <h3>Total Pengguna</h3>
                    <div class="number">125</div>
                    <div class="trend">+8 pengguna baru</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-file-invoice"></i></div>
                <div class="stat-details">
                    <h3>Total Pemesanan</h3>
                    <div class="number">50</div>
                    <div class="trend">+5 dari bulan lalu</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-wallet"></i></div>
                <div class="stat-details">
                    <h3>Total Pendapatan</h3>
                    <div class="number">Rp 15.250.000</div>
                    <div class="trend">+12% dari bulan lalu</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <div class="stat-details">
                    <h3>Menunggu Verifikasi</h3>
                    <div class="number">5</div>
                    <div class="trend alert">Perlu tindakan</div>
                </div>
            </div>
        </div>

        <div class="middle-grid">
            <div class="card-panel">
                <div class="panel-header">
                    <span>Grafik Pemesanan Bulanan</span>
                    <select style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                        <option>8 Bulan Terakhir</option>
                    </select>
                </div>
                <div class="chart-placeholder">
                    <span>[Area Chart.js / ApexCharts]</span>
                </div>
            </div>
            <div class="card-panel">
                <div class="panel-header">Aktivitas Terbaru</div>
                <ul class="activity-list">
                    <li class="activity-item">
                        <div class="activity-icon icon-blue"><i class="fa-solid fa-file-lines"></i></div>
                        <div class="activity-text">
                            <strong>Pemesanan baru untuk acara</strong>
                            Acara Pernikahan
                        </div>
                        <div class="activity-time">2 menit lalu</div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon icon-green"><i class="fa-solid fa-check"></i></div>
                        <div class="activity-text">
                            <strong>Pembayaran berhasil diverifikasi</strong>
                            AULA08062026
                        </div>
                        <div class="activity-time">15 menit lalu</div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon icon-yellow"><i class="fa-solid fa-clock"></i></div>
                        <div class="activity-text">
                            <strong>Pemesanan menunggu verifikasi</strong>
                            AULA08072025
                        </div>
                        <div class="activity-time">45 menit lalu</div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon icon-purple"><i class="fa-solid fa-list-ul"></i></div>
                        <div class="activity-text">
                            <strong>Kritik dan saran baru masuk</strong>
                            Dari Ahmad Danis
                        </div>
                        <div class="activity-time">1 jam lalu</div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-panel">
            <div class="panel-header">
                <span>Pemesanan Terbaru</span>
                <a href="#" style="color: var(--primary-blue); text-decoration: none; font-weight: normal;">Lihat Semua</a>
            </div>
            <table class="table-container">
                <thead>
                    <tr>
                        <th>Kode Pemesanan</th>
                        <th>Penyewa</th>
                        <th>Tanggal</th>
                        <th>Acara</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AULA09212006</td>
                        <td>Danis Ahmad</td>
                        <td>25 Juni 2026</td>
                        <td>Acara Pernikahan</td>
                        <td>Rp 9.700.000</td>
                        <td class="status status-menunggu">Menunggu</td>
                    </tr>
                    <tr>
                        <td>AULA09342007</td>
                        <td>Gibran Raka</td>
                        <td>25 Mei 2026</td>
                        <td>Seminar Nasional</td>
                        <td>Rp 2.500.000</td>
                        <td class="status status-dikonfirmasi">Dikonfirmasi</td>
                    </tr>
                    <tr>
                        <td>AULA10332009</td>
                        <td>Devi Lestari</td>
                        <td>20 Mei 2025</td>
                        <td>Pelatihan</td>
                        <td>Rp 5.200.000</td>
                        <td class="status status-selesai">Selesai</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="nav-brand" style="color: white; margin-bottom: 15px;">
                    <i class="fa-solid fa-building-columns"></i> Penyewaan Aula
                </div>
                <p>Politeknik Manufaktur Negeri Bangka Belitung - Sistem Pemesanan Aula Serbaguna.</p>
            </div>
            <div class="footer-col">
                <h4>Tautan</h4>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#">Detail Aula</a></li>
                    <li><a href="#">Jadwal</a></li>
                    <li><a href="#">Kritik & Saran</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="#">Sewa Aula</a></li>
                    <li><a href="#">Cek Ketersediaan</a></li>
                    <li><a href="#">Panduan Pemesanan</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Hubungi Kami</h4>
                <div class="contact-item"><i class="fa-solid fa-location-dot" style="color: var(--warning);"></i> <p>Jl. Timah Raya, Kawasan Industri Airkantung, Sungailiat, Bangka 33211</p></div>
                <div class="contact-item"><i class="fa-solid fa-phone" style="color: var(--warning);"></i> <p>+62-711-2341</p></div>
                <div class="contact-item"><i class="fa-solid fa-envelope" style="color: var(--warning);"></i> <p>info@polman-babel.ac.id</p></div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 Sistem Penyewaan Aula POLMAN Babel. Semua hak cipta dilindungi.
        </div>
    </footer>

</body>
</html>