<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Sistem Informasi Penyewaan Aula POLMAN BABEL</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/notifikasi.css') }}?v={{ time() }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <img src="{{ asset('images/Logo_Polman.png') }}" class="img-logo" alt="Logo Polman">
                <div class="logo-text">
                    <span class="brand-title">Penyewaan Aula</span>
                    <span class="brand-sub">POLMAN BABEL</span>
                </div>
            </div>
            <ul class="nav-menu">
                <li><a href="#">Beranda</a></li>
                <li><a href="{{ route('detail.aula') }}">Detail Aula</a></li>
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

    <header class="hero" style="background-image: url('{{ asset('images/aula_polman.jpeg') }}');">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1>Notifikasi Anda</h1>
                <p>Pantau informasi penting, status verifikasi dokumen, dan jadwal pesanan aula Anda di sini.</p>
            </div>
        </div>
    </header>

    <div id="halaman-notifikasi-klien">
        <div class="notif-main-container">
            <div class="tab-selector">
                <a href="{{ route('notifikasi.index', ['kategori' => 'Semua']) }}" 
                   class="tab-item {{ $filterKategori == 'Semua' ? 'active' : '' }}">
                    <i class="fa-solid fa-border-all"></i> Semua
                </a>
                <a href="{{ route('notifikasi.index', ['kategori' => 'Pesanan']) }}" 
                   class="tab-item {{ $filterKategori == 'Pesanan' ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice"></i> Pesanan
                </a>
                <a href="{{ route('notifikasi.index', ['kategori' => 'Pembaruan']) }}" 
                   class="tab-item {{ $filterKategori == 'Pembaruan' ? 'active' : '' }}">
                    <i class="fa-solid fa-bell"></i> Pembaruan
                </a>
            </div>

            <div class="notif-outer-box">
                @if(count($notifications) > 0)
                    @foreach($notifications as $noti)
                        @php
                            $icon = 'fa-bell';
                            $color = 'blue';

                            switch($noti->tipe) {
                                case 'pesanan_berhasil':
                                case 'verifikasi_dokumen':
                                    $icon = 'fa-circle-check';
                                    $color = 'green';
                                    break;
                                case 'pembayaran_berhasil':
                                    $icon = 'fa-id-card-clip';
                                    $color = 'blue';
                                    break;
                                case 'invoice_tersedia':
                                    $icon = 'fa-file-lines';
                                    $color = 'blue';
                                    break;
                                case 'pengingat_pesanan':
                                case 'pembayaran_tertunda':
                                    $icon = $noti->tipe == 'pengingat_pesanan' ? 'fa-bell' : 'fa-triangle-exclamation';
                                    $color = 'amber';
                                    break;
                                case 'update_fasilitas':
                                case 'informasi_penting':
                                    $icon = $noti->tipe == 'update_fasilitas' ? 'fa-circle-info' : 'fa-bullhorn';
                                    $color = 'purple';
                                    break;
                            }
                        @endphp

                        <a href="{{ $noti->url ?? '#' }}" style="text-decoration: none; color: inherit; display: block;">
                            <div class="notif-row" style="cursor: pointer;">
                                <div class="icon-box {{ $color }}"><i class="fa-solid {{ $icon }}"></i></div>
                                <div class="notif-text">
                                    <h4>{{ $noti->judul }}</h4>
                                    <p>{{ $noti->pesan }}</p>
                                </div>
                                <div class="notif-time-box">
                                    {{ $noti->created_at->diffForHumans() }} 
                                    <i class="fa-solid fa-chevron-right"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="notif-empty-state">
                        <i class="fa-regular fa-bell-slash"></i>
                        <p class="empty-title">Belum ada notifikasi</p>
                        <p class="empty-subtitle">Belum ada informasi baru untuk Anda saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

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