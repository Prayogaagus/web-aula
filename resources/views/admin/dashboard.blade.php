<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Penyewaan Aula POLMAN Babel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}?v={{ time() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <nav class="navbar">
        <div class="nav-brand">
            <img src="{{ asset('images/Logo_Polman.png') }}" class="nav-logo" alt="Logo">
            <div class="brand-text">
                <div class="brand-title">Penyewaan Aula</div>
                <div class="brand-subtitle">POLMAN Babel</div>
            </div>
        </div>
        <div class="nav-links">
            <a href="#" class="active">Dashboard</a>
            <a href="{{ route('admin.pengguna') }}">Pengguna</a>
            <a href="{{ route('admin.pemesanan') }}">Pemesanan</a>
            <a href="{{ route('admin.fasilitas') }}">Fasilitas</a>
            <a href="{{ route('admin.kritik-saran') }}">Kritik & Saran</a>
            <a href="{{ route('admin.laporan.index') }}">Laporan</a>
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
                        <div class="number">{{ $totalPengguna }}</div>
                        @if($penggunaHariIni > 0)
                            <div class="trend">+{{ $penggunaHariIni }} pengguna baru hari ini</div>
                        @endif
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon"><i class="fa-solid fa-rectangle-list"></i></div>
                    <div class="stat-details">
                        <h3>Total Pemesanan</h3>
                        <div class="number">{{ $totalPemesanan }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa-solid fa-wallet"></i></div>
                    <div class="stat-details">
                        <h3>Total Pendapatan</h3>
                        <div class="number">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon warning"><i class="fa-solid fa-clock-rotate-left"></i></div>
                    <div class="stat-details">
                        <h3>Menunggu Verifikasi</h3>
                        <div class="number">{{ $menungguVerifikasi }}</div>
                        <div class="trend alert">Perlu tindakan</div>
                    </div>
                </div>
            </div>

        <div class="middle-grid">
            <div class="card-panel">
    <div class="panel-header">
        <span>Grafik Pemesanan Bulanan</span>
    </div>
            <div class="card-panel">
                <div class="panel-header">Aktivitas Terbaru</div>
                <ul class="activity-list">
    @foreach($aktivitasTerbaru as $item)
        <li class="activity-item">
            {{-- Tentukan Ikon dan Warna berdasarkan tipe model --}}
            @if($item instanceof \App\Models\Pemesanan)
                <div class="activity-icon icon-blue"><i class="fa-solid fa-file-lines"></i></div>
                <div class="activity-text">
                    <strong>Pemesanan baru untuk acara</strong>
                    {{ $item->nama_acara }}
                </div>
            @elseif($item instanceof \App\Models\User)
                <div class="activity-icon icon-green"><i class="fa-solid fa-user-plus"></i></div>
                <div class="activity-text">
                    <strong>Pengguna baru mendaftar</strong>
                    {{ $item->name }}
                </div>
            @elseif($item instanceof \App\Models\KritikSaran)
                <div class="activity-icon icon-purple"><i class="fa-solid fa-list-ul"></i></div>
                <div class="activity-text">
                    <strong>Kritik dan saran baru masuk</strong>
                    Dari {{ $item->nama }}
                </div>
            @endif
            
            <div class="activity-time">{{ $item->created_at->diffForHumans() }}</div>
        </li>
    @endforeach
</ul>
            </div>
        </div>

        <div class="card-panel">
            <div class="panel-header">
                <span>Pemesanan Terbaru</span>
                <a href="{{ route('admin.pemesanan') }}" style="color: var(--primary-blue); text-decoration: none; font-weight: normal;">Lihat Semua</a>
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
                        @foreach($recentPemesanan as $item)
                        <tr>
                            <td>{{ $item->kode_pemesanan }}</td> <!-- Sesuaikan nama kolom -->
                            <td>{{ $item->user->name ?? 'User' }}</td> 
                            <td>{{ date('d F Y', strtotime($item->tanggal)) }}</td>
                            <td>{{ $item->jenis_acara }}</td>
                            <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="status status-{{ $item->status }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
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