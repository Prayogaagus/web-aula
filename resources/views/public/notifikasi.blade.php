<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - POLMAN Babel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/notifikasi.css') }}?v={{ time() }}">
</head>
<body>

<div id="halaman-notifikasi-klien">
    <nav class="global-navbar">
                <div class="nav-brand">
            <i class="fa-solid fa-layer-group brand-logo-icon"></i>
            <div class="brand-text">
                <span class="main-brand">Penyewaan Aula</span>
                <span class="sub-brand">POLMAN Babel</span>
            </div>
        </div>
        <ul class="nav-links">
            <li><a href="#">Beranda</a></li>
            <li><a href="#">Detail Aula</a></li>
            <li><a href="#">Jadwal</a></li>
            <li><a href="#">Kritik & Saran</a></li>
        </ul>
        <a href="#" class="btn-logout">Log Out</a>
    </nav>

    <div class="hero-notif-banner">
        <h1>Notifikasi</h1>
        <p>Pantau informasi penting terkait aktivitas Anda.</p>
    </div>

    <div class="notif-main-container">
        <div class="tab-selector">
            <button class="tab-item active"><i class="fa-solid fa-border-all"></i> Semua</button>
            <button class="tab-item"><i class="fa-solid fa-file-invoice"></i> Pesanan</button>
            <button class="tab-item"><i class="fa-solid fa-bell"></i> Pembaruan</button>
        </div>

        <div class="notif-card-wrapper">
            <div class="notif-row">
                <div class="icon-box green"><i class="fa-solid fa-check"></i></div>
                <div class="notif-text">
                    <h4>Pesanan Berhasil</h4>
                    <p>Pesanan aula untuk tanggal 25 Juni 2026 telah berhasil dibuat.</p>
                </div>
                <div class="notif-time">2 menit yang lalu <i class="fa-solid fa-chevron-right"></i></div>
            </div>
            <div class="notif-row">
                <div class="icon-box blue"><i class="fa-solid fa-file-invoice"></i></div>
                <div class="notif-text">
                    <h4>Pembayaran Berhasil</h4>
                    <p>Pembayaran sebesar Rp 9.700.000 telah berhasil diproses.</p>
                </div>
                <div class="notif-time">15 menit yang lalu <i class="fa-solid fa-chevron-right"></i></div>
            </div>
        </div>
    </div>
</div>

</body>
</html>