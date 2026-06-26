<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Penyewaan Aula POLMAN BABEL</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
           <img src="{{ asset('images/Logo_Polman.png') }}"  class="img-logo">
                <div class="logo-text">
                    <span class="brand-title">Penyewaan Aula</span>
                    <span class="brand-sub">POLMAN BABEL</span>
                </div>
            </div>
            <ul class="nav-menu">
                <li><a href="#" class="active">Beranda</a></li>
                <li><a href="{{ route('detail.aula') }}">Detail Aula</a></li>
                <li><a href="{{ route('jadwal') }}">Jadwal</a></li>
               <li><a href="{{ route('kritik') }}">Kritik & Saran</a></li>
            </ul>
<div class="nav-auth">
    @auth
        <span class="user-name" style="margin-right: 15px; color: #333; font-weight: 600;">
            <i class="fa-solid fa-user-circle"></i> {{ Auth::user()->name }}
        </span>
        <a href="#" class="btn-register" onclick="alert('Fitur Logout akan diaktifkan oleh Backend Developer.'); return false;">
           Keluar
        </a>
    @else
        <a href="{{ route('login') }}" class="btn-login">Masuk</a>
        <a href="{{ route('register') }}" class="btn-register">Daftar</a>
    @endauth
</div>
        </div>
    </nav>

    <header class="hero" style="background-image: url('{{ asset('images/aula_polman.jpeg') }}');">`
        <div class="hero-overlay">
            <div class="hero-content">
                <h1>Sewa Aula POLMAN Babel dengan Mudah</h1>
                <p>Pesan ruang acara resmi kampus secara online, cepat, dan transparan</p>
                <div class="hero-buttons">
                <a href="{{ route('detail.aula') }}" class="btn-orange">Lihat Ketersediaan</a>
                    @auth
        <a href="{{ route('pemesanan') }}" class="btn-outline">Pesan Sekarang</a>
    @else
        <a href="{{ route('login') }}" class="btn-outline" onclick="alert('Silakan login terlebih dahulu untuk melakukan pemesanan aula.')">Pesan Sekarang</a>
    @endauth
                </div>
            </div>
        </div>
    </header>

    <section class="stats-bar">
        <div class="stats-container">
            <div class="stats-item">
                <h3>500</h3>
                <p>Kapasitas Orang</p>
            </div>
            <div class="stats-item">
                <h3>800</h3>
                <p>Luas (m²)</p>
            </div>
            <div class="stats-item">
                <h3>Jumat - Minggu</h3>
                <p>Tersedia</p>
            </div>
            <div class="stats-item">
                <h3>Lengkap</h3>
                <p>Fasilitas Tersedia</p>
            </div>
        </div>
    </section>

    <section class="about-section container">
        <div class="about-info">
            <h2>Aula Serbaguna POLMAN Babel</h2>
            <p class="about-desc">
                Aula serbaguna kami dirancang khusus untuk mendukung berbagai kegiatan kampus mulai dari seminar, konferensi, acara wisuda, hingga kegiatan sosial lainnya. Dengan fasilitas lengkap dan lokasi strategis, kami siap mendukung kesuksesan acara Anda.
            </p>
            
            <div class="about-features">
    <div class="feature-item">
        <div class="feature-icon-wrapper">
            <i class="fa-solid fa-fan feature-icon"></i>
        </div>
        <div>
            <h4>AC & Sound System</h4>
            <p>Sistem pendingin dan audio profesional.</p>
        </div>
    </div>
    
    <div class="feature-item">
        <div class="feature-icon-wrapper">
            <i class="fa-solid fa-square-parking feature-icon"></i>
        </div>
        <div>
            <h4>Parkir Luas</h4>
            <p>Area parkir yang nyaman untuk ratusan kendaraan.</p>
        </div>
    </div>
    
    <div class="feature-item">
        <div class="feature-icon-wrapper">
            <i class="fa-solid fa-video feature-icon"></i>
        </div>
        <div>
            <h4>Proyektor & Layar</h4>
            <p>Peralatan presentasi modern berkualitas tinggi.</p>
        </div>
    </div>
</div>
        </div>
        <div class="about-image">
           <img src="{{ asset('images/aula_polman.jpeg') }}" alt="Gedung Aula Serbaguna POLMAN Babel" class="img-aula-fluid">
        </div>
    </section>

    <section class="facilities-section">
        <div class="container">
            <h2 class="section-title">Fasilitas Tersedia</h2>
            <div class="facilities-grid">
                <div class="facility-card">
                    <i class="fa-solid fa-volume-high text-blue"></i>
                    <h3>Sound System</h3>
                    <p>Sistem suara profesional dengan kualitas terbaik.</p>
                </div>
                <div class="facility-card">
                    <i class="fa-solid fa-bolt text-blue"></i>
                    <h3>AC</h3>
                    <p>Pendingin ruangan dengan suhu terkontrol.</p>
                </div>
                <div class="facility-card">
                    <i class="fa-solid fa-display text-blue"></i>
                    <h3>Proyektor & Layar</h3>
                    <p>Peralatan presentasi modern dan canggih.</p>
                </div>
                <div class="facility-card">
                    <i class="fa-solid fa-chair text-blue"></i>
                    <h3>Meja & Kursi</h3>
                    <p>Peralatan berkualitas untuk kenyamanan peserta.</p>
                </div>
                <div class="facility-card">
                    <i class="fa-solid fa-restroom text-blue"></i>
                    <h3>Toilet</h3>
                    <p>Fasilitas sanitasi lengkap dan bersih.</p>
                </div>
                <div class="facility-card">
                    <i class="fa-solid fa-square-p text-blue"></i>
                    <h3>Parkir</h3>
                    <p>Area parkir luas dan aman untuk kendaraan.</p>
                </div>
                <div class="facility-card">
                    <i class="fa-solid fa-wifi text-blue"></i>
                    <h3>WiFi</h3>
                    <p>Koneksi internet kecepatan tinggi tersedia.</p>
                </div>
                <div class="facility-card">
                    <i class="fa-solid fa-shield-halved text-blue"></i>
                    <h3>Keamanan</h3>
                    <p>Sistem keamanan 24 jam untuk acara Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="steps-section container">
    <h2 class="section-title">Cara Pemesanan</h2>
    <div class="steps-grid">
        <div class="step-item">
            <div class="step-number">1</div>
            <h3>Daftar Akun</h3>
            <p>Buat akun dengan data lengkap dan valid.</p>
        </div>
        <div class="step-item">
            <div class="step-number">2</div>
            <h3>Pilih Jadwal</h3>
            <p>Lihat ketersediaan dan pilih tanggal acara.</p>
        </div>
        <div class="step-item">
            <div class="step-number">3</div>
            <h3>Isi Form</h3>
            <p>Lengkapi detail acara dan kebutuhan khusus.</p>
        </div>
        <div class="step-item">
            <div class="step-number">4</div>
            <h3>Bayar & Konfirmasi</h3>
            <p>Lakukan pembayaran dan terima konfirmasi.</p>
        </div>
    </div>
</section>

    <section class="cta-section">
        <h2>Siap Mengadakan Acara di POLMAN Babel?</h2>
        <p>Jangan lewatkan kesempatan untuk menggunakan aula terbaik dengan fasilitas lengkap.</p>
        @auth
        <a href="{{ route('pemesanan') }}" class="btn-orange-large">Pesan Aula Sekarang</a>
    @else
        <a href="{{ route('login') }}" class="btn-orange-large" onclick="alert('Silakan login terlebih dahulu untuk melakukan pemesanan aula.')">Pesan Aula Sekarang</a>
    @endauth
    </section>

    <footer class="main-footer">
        <div class="container footer-grid">
            <div class="footer-col">
                <div class="footer-logo">
                    <i class="fa-solid fa-building-columns"></i>
                    <span>Penyewaan Aula</span>
                </div>
                <p class="footer-text-muted">Politeknik Manufaktur Negeri Bangka Belitung - Sistem Pemesanan Aula Serbaguna.</p>
            </div>
            <div class="footer-col">
                <h3>Tautan</h3>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#">Detail Aula</a></li>
                    <li><a href="#">Jadwal</a></li>
                    <li><a href="#">Kritik & Saran</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Layanan</h3>
                <ul>
                    <li><a href="#">Sewa Aula</a></li>
                    <li><a href="#">Cek Ketersediaan</a></li>
                    <li><a href="#">Panduan Pemesanan</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Hubungi Kami</h3>
                <ul class="contact-list">
                    <li><i class="fa-solid fa-location-dot"></i> Jl. Timah Raya, Kawasan Industri Airkantung, Sungailiat, Bangka 33211</li>
                    <li><i class="fa-solid fa-phone"></i> +62-717-33211</li>
                    <li><i class="fa-solid fa-envelope"></i> info@polman-babel.ac.id</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Sistem Penyewaan Aula POLMAN Babel. Semua hak cipta dilindungi.</p>
        </div>
    </footer>

</body>
</html>