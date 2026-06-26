<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aula Serbaguna - POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}?v={{ time() }}">
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
                <li><a href="{{ route('detail.aula') }}" class="active">Detail Aula</a></li>
                 <li><a href="{{ route('jadwal') }}">Jadwal</a></li>
               <li><a href="{{ route('kritik') }}">Kritik & Saran</a></li>
            </ul>
            <div class="nav-auth">
                @auth
                    <span class="user-name" style="margin-right: 15px; color: #333; font-weight: 600;">
                        <i class="fa-solid fa-user-circle"></i> {{ Auth::user()->name }}
                    </span>
                    
                    <a href="{{ route('logout') }}" class="btn-register" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       Keluar
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="detail-section">
        <div class="container">
            <div class="detail-grid">
                
                <div class="left-column">
                    
                <div class="gallery-container">
    <div class="main-image">
        <img id="view-primary" src="{{ asset('images/aula/detail1.jpeg') }}" alt="Aula POLMAN Babel">
    </div>
    <div class="thumbnail-grid">
        <img class="thumbnail-item active" src="{{ asset('images/aula/detail1.jpeg') }}" onclick="changeImage(this)" alt="View 1">
        <img class="thumbnail-item" src="{{ asset('images/aula/detail2.jpeg') }}" onclick="changeImage(this)" alt="View 2">
        <img class="thumbnail-item" src="{{ asset('images/aula/detail3.jpeg') }}" onclick="changeImage(this)" alt="View 3">
        <img class="thumbnail-item" src="{{ asset('images/aula/detail4.jpeg') }}" onclick="changeImage(this)" alt="View 4">
    </div>
</div>

                    <div class="detail-info">
                        <h2>Aula Serbaguna POLMAN Babel</h2>
                        <p class="detail-desc">
                            Aula Serbaguna POLMAN Babel merupakan fasilitas multifungsi yang dapat digunakan untuk berbagai keperluan acara seperti seminar, workshop, wisuda, resepsi pernikahan, dan kegiatan formal lainnya. Dilengkapi dengan fasilitas modern dan didukung oleh tim profesional, aula ini menjadi pilihan tepat untuk berbagai acara Anda di Bangka Belitung.
                        </p>
                    </div>

                    <div class="sub-title-line">
                        <h3>Paket & Fasilitas</h3>
                        <div class="line"></div>
                    </div>

                    <div class="packet-tabs">
                        <button class="btn-tab-packet active" onclick="switchPacket('resepsi')">Paket Resepsi</button>
                        <button class="btn-tab-packet" onclick="switchPacket('pendidikan')">Paket Instansi Pendidikan</button>
                    </div>

                    <div id="content-resepsi" class="packet-content active">
                        <div class="detail-facilities-list">
                            <div class="facility-detail-item">
                                <i class="fa-solid fa-chair"></i>
                                <div class="facility-text-wrapper">
                                    <span class="facility-text-name">Kursi Plastik</span>
                                    <span class="facility-text-qty">250 Buah</span>
                                </div>
                            </div>
                            <div class="facility-detail-item">
                                <i class="fa-solid fa-table"></i>
                                <div class="facility-text-wrapper">
                                    <span class="facility-text-name">Meja Terima Tamu</span>
                                    <span class="facility-text-qty">2 Buah</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="content-pendidikan" class="packet-content">
                        <div class="detail-facilities-list">
                            <div class="facility-detail-item">
                                <i class="fa-solid fa-chair"></i>
                                <div class="facility-text-wrapper">
                                    <span class="facility-text-name">Kursi Plastik</span>
                                    <span class="facility-text-qty">250 Buah</span>
                                </div>
                            </div>
                            <div class="facility-detail-item">
                                <i class="fa-solid fa-table"></i>
                                <div class="facility-text-wrapper">
                                    <span class="facility-text-name">Meja Terima Tamu</span>
                                    <span class="facility-text-qty">2 Buah</span>
                                </div>
                            </div>
                            <div class="facility-detail-item">
                                <i class="fa-solid fa-display"></i>
                                <div class="facility-text-wrapper">
                                    <span class="facility-text-name">Videotron</span>
                                    <span class="facility-text-qty">Include</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sub-title-line">
                        <h3>Ketentuan Sewa</h3>
                        <div class="line"></div>
                    </div>
                    <ul class="rules-list">
                        <li><span class="num">1</span> Penyewaan eksternal hanya tersedia Jumat – Minggu.</li>
                        <li><span class="num">2</span> Pembayaran dilakukan langsung ke bendahara POLMAN Babel.</li>
                        <li><span class="num">3</span> Pemesanan minimal H-3 sebelum tanggal acara.</li>
                        <li><span class="num">4</span> Pembatalan wajib konfirmasi ke admin.</li>
                    </ul>

                </div> <div class="right-column sticky-sidebar">
                    <div class="price-card">
                        <span class="price-label">Harga Sewa</span>
                        <div class="price-amount">Rp 8.950.000</div>
                        <span class="price-unit">per sesi/ hari</span>

                        <div class="spec-list">
                            <div class="spec-item">
                                <span class="spec-label">Kapasitas</span>
                                <span class="spec-value">250 Kursi</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Tersedia</span>
                                <span class="spec-value">Jumat - Minggu</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Pembayaran</span>
                                <span class="spec-value">Langsung ke Bendahara Polman</span>
                            </div>
                        </div>
                        
                        @auth
                            <a href="{{ route('pemesanan') }}" class="btn-sidebar-order">Pesan Aula Ini</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-sidebar-order" onclick="alert('Silakan login terlebih dahulu untuk melakukan pemesanan aula.')">Pesan Aula Ini</a>
                        @endauth
                        
                        <span class="sidebar-note">Login diperlukan untuk memesan</span>
                    </div>
                </div> </div>
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

    <script>
        function changeImage(element) {
            document.getElementById('view-primary').src = element.src;
            const thumbnails = document.getElementsByClassName('thumbnail-item');
            for (let i = 0; i < thumbnails.length; i++) {
                thumbnails[i].classList.remove('active');
            }
            element.classList.add('active');
        }

        function switchPacket(packetName) {
            // 1. Hapus class 'active' dari semua tombol tab
            const tabs = document.getElementsByClassName('btn-tab-packet');
            for (let i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove('active');
            }
            
            // 2. Hapus class 'active' dari semua container konten fasilitas
            const contents = document.getElementsByClassName('packet-content');
            for (let i = 0; i < contents.length; i++) {
                contents[i].classList.remove('active');
            }
            
            // 3. Aktifkan tombol tab yang sedang diklik
            event.currentTarget.classList.add('active');
            
            // 4. Tampilkan konten fasilitas yang sesuai
            document.getElementById('content-' + packetName).classList.add('active');
        }
    </script>
</body>
</html>