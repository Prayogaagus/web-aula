<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Ketersediaan Jadwal - POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/jadwal.css') }}?v={{ time() }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <img src="{{ asset('images/Logo_Polman.png') }}" alt="Logo POLMAN" class="img-logo">
                <div class="logo-text">
                    <span class="brand-title">Penyewaan Aula</span>
                    <span class="brand-sub">POLMAN BABEL</span>
                </div>
            </div>
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li><a href="{{ route('detail.aula') }}">Detail Aula</a></li>
                <li><a href="{{ route('jadwal') }}" class="active">Jadwal</a></li>
                <li><a href="{{ route('kritik') }}">Kritik & Saran</a></li>
            </ul>
            <div class="nav-auth">
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                <a href="{{ route('register') }}" class="btn-register">Daftar</a>
            </div>
        </div>
    </nav>

    <header class="jadwal-hero">
        <div class="container">
            <h1>Cek Ketersediaan Jadwal</h1>
            <p>Lihat tanggal yang tersedia untuk pemesanan aula</p>
        </div>
    </header>

    <main class="calendar-section">
        <div class="container">
            
            <div class="calendar-card">
                <div class="calendar-header">
                    <div class="status-indicators">
                        <div class="indicator"><span class="dot tersedia"></span> Tersedia</div>
                        <div class="indicator"><span class="dot dipesan"></span> Sudah Dipesan</div>
                        <div class="indicator"><span class="dot tidak-tersedia"></span> Tidak Tersedia</div>
                    </div>
                    <div class="calendar-nav">
                        <button class="btn-nav-cal"><i class="fa-solid fa-chevron-left"></i></button>
                        <span class="current-month">Mei 2026</span>
                        <button class="btn-nav-cal"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="calendar-grid">
                    <div class="day-name">Min</div>
                    <div class="day-name">Sen</div>
                    <div class="day-name">Sel</div>
                    <div class="day-name">Rab</div>
                    <div class="day-name">Kam</div>
                    <div class="day-name">Jum</div>
                    <div class="day-name">Sab</div>

                    <div class="day-cell placeholder"></div>
                    <div class="day-cell placeholder"></div>
                    <div class="day-cell placeholder"></div>
                    <div class="day-cell placeholder"></div>
                    <div class="day-cell placeholder"></div>

                    <div class="day-cell cell-tersedia"><span class="day-number">1</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-dipesan"><span class="day-number">2</span><span class="day-status">Seminar Nasional</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">3</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">4</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">5</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">6</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">7</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">8</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">9</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">10</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">11</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">12</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">13</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">14</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">15</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-dipesan"><span class="day-number">16</span><span class="day-status">Rapat Dinas</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">17</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">18</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">19</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">20</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">21</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">22</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">23</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">24</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">25</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">26</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">27</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tidak-tersedia"><span class="day-number">28</span><span class="day-status">Tidak Tersedia</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">29</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-tersedia"><span class="day-number">30</span><span class="day-status">Tersedia</span></div>
                    <div class="day-cell cell-dipesan"><span class="day-number">31</span><span class="day-status">Acara Pernikahan</span></div>
                </div>
            </div>

            <div class="info-cards-grid">
                <div class="info-card">
                    <div class="info-card-icon"><i class="fa-regular fa-clock"></i></div>
                    <h3>Jam Operasional</h3>
                    <p>Aula tersedia mulai pagi hingga selesai acara. Jam operasional mengikuti kebijakan kampus POLMAN Babel.</p>
                </div>
                <div class="info-card">
                    <div class="info-card-icon"><i class="fa-regular fa-calendar-check"></i></div>
                    <h3>Hari Tersedia</h3>
                    <p>Penyewaan untuk umum hanya tersedia setiap Jumat, Sabtu, dan Minggu. Senin hingga Kamis khusus kegiatan internal kampus.</p>
                </div>
                <div class="info-card">
                    <div class="info-card-icon"><i class="fa-regular fa-file-lines"></i></div>
                    <h3>Cara Pesan</h3>
                    <p>1. Daftar atau login akun. 2. Pilih tanggal tersedia (Jumat–Minggu). 3. Isi formulir pemesanan & pilih paket. 4. Tunggu konfirmasi dari admin.</p>
                </div>
            </div>

        </div>
    </main>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="nav-logo" style="margin-bottom:15px;">
                        <div class="logo-text">
                            <span class="brand-title" style="color:white;">Penyewaan Aula</span>
                            <span class="brand-sub" style="color:#94a3b8;">POLMAN BABEL</span>
                        </div>
                    </div>
                    <p style="font-size:0.85rem; line-height:1.5;">Politeknik Manufaktur Negeri Bangka Belitung - Sistem Pemesanan Aula Serbaguna.</p>
                </div>
                <div class="footer-col">
                    <h3>Tautan</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('detail.aula') }}">Detail Aula</a></li>
                        <li><a href="{{ route('jadwal') }}">Jadwal</a></li>
                        <li><a href="{{ route('kritik') }}">Kritik & Saran</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Layanan</h3>
                    <ul>
                        <li><a href="#">Sewa Aula</a></li>
                        <li><a href="{{ route('jadwal') }}">Cek Ketersediaan</a></li>
                        <li><a href="#">Panduan Pemesanan</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Hubungi Kami</h3>
                    <ul class="contact-list">
                        <li><i class="fa-solid fa-location-dot"></i> <span>Jl. Timah Raya, Kawasan Industri Airkantung, Sungailiat, Bangka 33211</span></li>
                        <li><i class="fa-solid fa-phone"></i> <span>+62-717-2341</span></li>
                        <li><i class="fa-solid fa-envelope"></i> <span>info@polman-babel.ac.id</span></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; 2026 Sistem Penyewaan Aula POLMAN Babel. Semua hak cipta dilindungi.
            </div>
        </div>
    </footer>

</body>
</html>