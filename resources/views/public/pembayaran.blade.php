<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Sewa Aula - POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/pembayaran.css') }}?v={{ time() }}">
</head>
<body class="payment-body">

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
            <h2>Pembayaran</h2>
            <p>Selesaikan Pembayaran untuk melanjutkan pemesanan Anda.</p>
            
            <div class="stepper">
                <div class="step checked">1</div>
                <div class="line active-line"></div>
                <div class="step checked">2</div>
                <div class="line active-line"></div>
                <div class="step active">3</div>
                <div class="line"></div>
                <div class="step">4</div>
            </div>
        </div>
    </div>

    <div class="payment-container">
        
        <div class="payment-sidebar">
            <h3>Ringkasan Pemesanan</h3>
            
            <div class="aula-card-info">
                <img src="{{ asset('images/aula_polman.jpeg') }}" alt="Aula POLMAN Babel" class="sidebar-img">
                <div class="aula-details">
                    <h4>Aula POLMAN Babel</h4>
                    <p><i class="fa-solid fa-location-dot"></i> Jl. Timah Raya, Kawasan Industri Airkantung, Sungailiat, Bangka 33211</p>
                </div>
            </div>

            <div class="summary-list">
                <div class="summary-item">
                    <i class="fa-solid fa-calendar-days summary-icon"></i>
                    <div>
                        <span class="item-label">Tanggal</span>
                        <span class="item-value">Minggu, 25 Juni 2026</span>
                    </div>
                </div>

                <div class="summary-item">
                    <i class="fa-solid fa-clock summary-icon"></i>
                    <div>
                        <span class="item-label">Waktu</span>
                        <span class="item-value">08.00 - 17.00 WIB</span>
                    </div>
                </div>

                <div class="summary-item">
                    <i class="fa-solid fa-circle-question summary-icon"></i>
                    <div>
                        <span class="item-label">Jenis Acara</span>
                        <span class="item-value">Resepsi</span>
                    </div>
                </div>

                <div class="summary-item">
                    <i class="fa-solid fa-users summary-icon"></i>
                    <div>
                        <span class="item-label">Jumlah Peserta</span>
                        <span class="item-value">150 Orang</span>
                    </div>
                </div>

                <div class="summary-item">
                    <i class="fa-solid fa-heart-pulse summary-icon"></i>
                    <div>
                        <span class="item-label">Fasilitas Tambahan</span>
                        <span class="item-value">Sound System, Proyektor, Kursi Tambahan</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="payment-main-content">
            <h3>Detail Pembayaran</h3>
            
            <div class="price-row base-price">
                <span>Harga Sewa Aula</span>
                <span class="price-value">Rp 8.950.000</span>
            </div>

            <div class="facilities-section">
                <h5>Fasilitas Tambahan</h5>
                <div class="facility-price-item">
                    <span class="bullet-text">&bull; Sound System</span>
                    <span>Rp 300.000</span>
                </div>
                <div class="facility-price-item">
                    <span class="bullet-text">&bull; Proyektor</span>
                    <span>Rp 200.000</span>
                </div>
                <div class="facility-price-item">
                    <span class="bullet-text">&bull; Kursi Tambahan (50)</span>
                    <span>Rp 250.000</span>
                </div>
            </div>

            <div class="divider-line"></div>

            <div class="price-row subtotal-row">
                <span>Subtotal</span>
                <span>Rp 9.700.000</span>
            </div>
            <div class="price-row fee-row">
                <span>Biaya Layanan</span>
                <span>Rp 0</span>
            </div>

            <div class="divider-line-thick"></div>

            <div class="total-payment-box">
                <span class="total-title">Total Pembayaran</span>
                <span class="total-price">Rp 9.700.000</span>
            </div>

            <div class="method-section">
                <h3>Pilih Metode Pembayaran</h3>
                
                <div class="methods-grid">
                    <label class="method-card">
                        <input type="radio" name="payment_method" value="qris" checked>
                        <div class="card-content">
                            <div class="method-logo-placeholder">
                                <span class="qris-text">QRIS</span>
                            </div>
                            <span class="method-name">QRIS</span>
                            <span class="method-desc">Bayar Cepat</span>
                        </div>
                    </label>

                    <label class="method-card">
                        <input type="radio" name="payment_method" value="bank_transfer">
                        <div class="card-content">
                            <div class="method-logo-placeholder">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <span class="method-name">Transfer Bank</span>
                            <span class="method-desc">ATM/M Banking</span>
                        </div>
                    </label>

                    <label class="method-card">
                        <input type="radio" name="payment_method" value="ewallet">
                        <div class="card-content">
                            <div class="method-logo-placeholder">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <span class="method-name">E-Wallet</span>
                            <span class="method-desc">OVO, DANA, Gopay</span>
                        </div>
                    </label>

                    <label class="method-card">
                        <input type="radio" name="payment_method" value="credit_card">
                        <div class="card-content">
                            <div class="method-logo-placeholder">
                                <i class="fa-regular fa-credit-card"></i>
                            </div>
                            <span class="method-name">Kartu Kredit</span>
                            <span class="method-desc">VISA, Mastercard</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="action-container">
                <button type="button" class="btn-orange-pay">
                    <i class="fa-solid fa-lock"></i> Lanjutkan Pembayaran
                </button>
                <div class="secure-info">
                    <i class="fa-solid fa-circle-plus"></i> Transaksi aman dan terenkripsi
                </div>
            </div>

        </div>
    </div>

</body>
</html>