<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/pembayaran-detail.css') }}?v={{ time() }}">
</head>
<body class="qris-body">

    <nav class="global-navbar">
        <div class="nav-brand">
            <i class="fa-solid fa-layer-group brand-logo-icon"></i>
            <div class="brand-text">
                <span class="main-brand">Penyewaan Aula</span>
                <span class="sub-brand">POLMAN Babel</span>
            </div>
        </div>
        <ul class="nav-links">
            <li><a href="#" class="active">Beranda</a></li>
            <li><a href="#">Detail Aula</a></li>
            <li><a href="#">Jadwal</a></li>
            <li><a href="#">Kritik & Saran</a></li>
        </ul>
        <div class="nav-auth">
            <a href="#" class="btn-logout">Log Out</a>
        </div>
    </nav>

    <div class="top-blue-hero">
        <div class="hero-inner">
            <h2>Pembayaran QRIS</h2>
            <p>Scan QR code di bawah ini menggunakan aplikasi e-wallet atau mobile banking</p>
        </div>
    </div>

    <div class="qris-container">
        <div class="qris-card-left">
            <div class="qris-header-logo">
                <span class="qris-main-text">QRIS</span>
                <span class="qris-sub-text">QR Code Standar<br>Pembayaran Nasional</span>
            </div>
            
            <div class="qr-code-wrapper">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=AULA08062026" alt="QR Code QRIS">
            </div>

            <p class="limit-text">Selesaikan pembayaran sebelum</p>
            
            <div class="countdown-timer">
                <div class="time-box"><span>23</span><label>Jam</label></div>
                <div class="time-box"><span>59</span><label>Menit</label></div>
                <div class="time-box"><span>32</span><label>Detik</label></div>
            </div>
        </div>

        <div class="qris-card-right">
            <h3>Detail Pembayaran</h3>
            <div class="detail-rows">
                <div class="detail-row">
                    <span>Kode Pemesanan</span>
                    <span class="highlight-blue">AULA08062026</span>
                </div>
                <div class="detail-row">
                    <span>Nama Pemesan</span>
                    <span>Ahmad Danis</span>
                </div>
                <div class="detail-row">
                    <span>Total Pembayaran</span>
                    <span class="highlight-blue text-lg">Rp 9.700.000</span>
                </div>
            </div>

            <hr class="card-divider">

            <h3>Cara Pembayaran</h3>
            <ul class="steps-list">
                <li><span class="step-num">1</span> Buka aplikasi e-wallet atau mobile banking</li>
                <li><span class="step-num">2</span> Pilih menu QRIS</li>
                <li><span class="step-num">3</span> Scan kode QR di samping</li>
                <li><span class="step-num">4</span> Pastikan nominal sesuai</li>
                <li><span class="step-num">5</span> Konfirmasi pembayaran</li>
            </ul>

            <div class="wallet-logos">
                <img src="https://gopay.co.id/favicon.ico" alt="Gopay" style="display:none;"><span class="logo-name">gopay</span>
                <span class="logo-name font-ovo">OVO</span>
                <span class="logo-name font-dana">DANA</span>
                <span class="logo-name font-shopee">ShopeePay</span>
                <span class="logo-name font-link">LinkAja!</span>
            </div>
            <p class="and-others">dan lainnya</p>
        </div>
    </div>

    <div class="qris-footer-actions">
        <a href="{{ route('pembayaran') }}" class="btn-back-white"><i class="fa-solid fa-chevron-left"></i> Kembali</a>
        <a href="{{ route('pembayaran.sukses') }}" style="text-decoration: none; color: white;" class="auto-verify-text">
            Pembayaran akan otomatis diverifikasi setelah berhasil. <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

</body>
</html>