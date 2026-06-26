<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/pembayaran-sukses.css') }}?v={{ time() }}">
</head>
<body class="success-body">

    <div class="top-blue-hero">
        <div class="confetti-overlay"></div>
        
        <nav class="global-navbar">
            <div class="nav-brand">
                <i class="fa-solid fa-layer-group brand-logo-icon"></i>
                <div class="brand-text">
                    <span class="main-brand">Penyewaan Aula</span>
                    <span class="sub-brand">POLMAN Babel</span>
                </div>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="active">Beranda</a></li>
                <li><a href="#">Detail Aula</a></li>
                <li><a href="#">Jadwal</a></li>
                <li><a href="#">Kritik & Saran</a></li>
            </ul>
            <div class="nav-auth">
                <a href="#" class="btn-logout">Log Out</a>
            </div>
        </nav>

        <div class="hero-inner">
            <div class="success-checkmark-circle">
                <i class="fa-solid fa-check"></i>
            </div>
            <h2>Pembayaran Berhasil</h2>
            <p>Terima kasih, pembayaran Anda telah kami terima.</p>
            
            <div class="stepper">
                <div class="step checked">1</div>
                <div class="line active-line"></div>
                <div class="step checked">2</div>
                <div class="line active-line"></div>
                <div class="step checked">3</div>
                <div class="line active-line"></div>
                <div class="step checked">4</div>
            </div>
        </div>
    </div>

    <div class="success-container">
        <div class="success-main-card">
            
            <div class="invoice-details-side">
                <div class="invoice-row">
                    <span class="inv-label">Kode Pemesanan</span>
                    <span class="inv-value font-bold">AULA08062026</span>
                </div>
                <div class="invoice-row">
                    <span class="inv-label">Tanggal Pembayaran</span>
                    <span class="inv-value font-bold">1 Juni 2026 - 10:45</span>
                </div>
                <div class="invoice-row">
                    <span class="inv-label">Metode Pembayaran</span>
                    <span class="inv-value font-bold">QRIS</span>
                </div>
                <div class="invoice-row">
                    <span class="inv-label">Total Pembayaran</span>
                    <span class="inv-value font-bold">Rp 9.700.000</span>
                </div>
                <div class="invoice-row">
                    <span class="inv-label">Status</span>
                    <span class="inv-value">
                        <span class="status-badge-green">Lunas</span>
                    </span>
                </div>
            </div>

            <div class="vertical-divider"></div>

            <div class="next-steps-side">
                <h3>Selanjutnya</h3>
                <p class="next-desc">kami akan memverifikasi data pemesanan Anda. Detail pemesanan telah dikirim ke email Anda.</p>
                
                <div class="action-buttons">
                    <button class="btn-orange-invoice">Lihat Invoice</button>
                    <a href="{{ route('home') }}" class="btn-link-home">Kembali ke Beranda</a>
                </div>
            </div>

        </div>
    </div>

    <footer class="main-footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="brand-row">
                    <i class="fa-solid fa-layer-group footer-logo-icon"></i>
                    <h4>Penyewaan Aula</h4>
                </div>
                <p>Politeknik Manufaktur Negeri Bangka Belitung - Sistem Pemesanan Aula Serbaguna</p>
            </div>
            <div class="footer-col">
                <h5>Tautan</h5>
                <a href="#">Beranda</a>
                <a href="#">Detail Aula</a>
                <a href="#">Jadwal</a>
                <a href="#">Kritik & Saran</a>
            </div>
            <div class="footer-col">
                <h5>Layanan</h5>
                <a href="#">Sewa Aula</a>
                <a href="#">Cek Ketersediaan</a>
                <a href="#">Panduan Pemesanan</a>
                <a href="#">FAQ</a>
            </div>
            <div class="footer-col">
                <h5>Hubungi Kami</h5>
                <p><i class="fa-solid fa-map-marker-alt"></i> Jl. Timah Raya, Kawasan Industri Airkantung, Sungailiat, Bangka 33211</p>
                <p><i class="fa-solid fa-phone"></i> +62-711-2341</p>
                <p><i class="fa-solid fa-envelope"></i> info@polman-babel.ac.id</p>
            </div>
        </div>
        <div class="footer-copyright">
            &copy; 2026 Sistem Penyewaan Aula POLMAN Babel. Semua hak cipta dilindungi.
        </div>
    </footer>

</body>
</html>