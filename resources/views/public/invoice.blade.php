<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pemesanan - POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}?v={{ time() }}">
</head>
<body class="invoice-body">

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

    <div class="invoice-container">
        
        <div class="invoice-header-row">
            <div class="aula-profile">
                <img src="{{ asset('images/aula_polman.jpeg') }}" alt="Aula POLMAN Babel" class="aula-img">
                <div class="aula-meta">
                    <h4>Aula POLMAN Babel</h4>
                    <p>Jl. Timah Raya, Kawasan Industri Airkantung, Sungailiat, Bangka 33211</p>
                </div>
            </div>
            
            <div class="invoice-title-box">
                <h2>INVOICE</h2>
                <table class="meta-table">
                    <tr>
                        <td>Kode Invoice</td>
                        <td>: INV/KLIEN/001</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>: 1 Juni 2026</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr class="section-divider">

        <div class="data-pemesanan-grid">
            <div class="data-column">
                <h3>Data Pemesan</h3>
                <table class="info-table">
                    <tr>
                        <td class="label">Nama</td>
                        <td class="value">Ahmad Danis</td>
                    </tr>
                    <tr>
                        <td class="label">Instansi</td>
                        <td class="value">PT. Maju Terus</td>
                    </tr>
                    <tr>
                        <td class="label">No. Telepon</td>
                        <td class="value">0812-3421-6296</td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="value">ahmad@gmail.com</td>
                    </tr>
                </table>
            </div>

            <div class="data-column">
                <h3>Detail Pemesanan</h3>
                <table class="info-table">
                    <tr>
                        <td class="label">Tanggal</td>
                        <td class="value">Minggu, 25 Juni 2026</td>
                    </tr>
                    <tr>
                        <td class="label">Waktu</td>
                        <td class="value">08.00 - 17.00 WIB</td>
                    </tr>
                    <tr>
                        <td class="label">Acara</td>
                        <td class="value">Resepsi</td>
                    </tr>
                    <tr>
                        <td class="label">Jumlah Peserta</td>
                        <td class="value">150 orang</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="billing-section-grid">
            
            <div class="table-responsive">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width: 8%">No</th>
                            <th>Deskripsi</th>
                            <th style="width: 12%">Jumlah</th>
                            <th style="width: 22%">Harga Satuan</th>
                            <th style="width: 22%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="center">1</td>
                            <td>Sewa gedung Aula</td>
                            <td class="center">1</td>
                            <td>Rp 8.950.000</td>
                            <td>Rp 8.950.000</td>
                        </tr>
                        <tr>
                            <td class="center">2</td>
                            <td>Sound System</td>
                            <td class="center">1</td>
                            <td>Rp 300.000</td>
                            <td>Rp 300.000</td>
                        </tr>
                        <tr>
                            <td class="center">3</td>
                            <td>Proyektor</td>
                            <td class="center">1</td>
                            <td>Rp 200.000</td>
                            <td>Rp 200.000</td>
                        </tr>
                        <tr>
                            <td class="center">4</td>
                            <td>Kursi Tambahan</td>
                            <td class="center">50</td>
                            <td>Rp 5.000</td>
                            <td>Rp 250.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="summary-calculation-box">
                <div class="calc-row">
                    <span>Subtotal</span>
                    <span class="calc-val">Rp 9.700.000</span>
                </div>
                <div class="calc-row">
                    <span>Biaya Layanan</span>
                    <span class="calc-val">Rp 0</span>
                </div>
                <div class="calc-total-row">
                    <span>Total Pembayaran</span>
                    <span class="total-val">Rp 9.700.000</span>
                </div>
            </div>
        </div>

        <div class="footer-note-grid">
            <div class="catatan-box">
                <h4>Catatan</h4>
                <ul>
                    <li>Pembayaran harus dilakukan sebelum batas waktu yang ditentukan</li>
                    <li>Invoice ini berlaku sebagai bukti pemesanan yang sah</li>
                </ul>
            </div>
            
            <div class="signature-box">
                <p class="greeting">Hormat kami,</p>
                <p class="sign-title">Admin Aula Polman Babel</p>
            </div>
        </div>

    </div>

    <footer class="global-footer">
        <div class="footer-container">
            <div class="footer-brand-section">
                <div class="footer-logo">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Penyewaan Aula</span>
                </div>
                <p>Politeknik Manufaktur Negeri Bangka Belitung - Sistem Pemesanan Aula Serbaguna</p>
            </div>
            <div class="footer-links-grid">
                <div>
                    <h5>Tautan</h5>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Detail Aula</a></li>
                        <li><a href="#">Jadwal</a></li>
                        <li><a href="#">Kritik & Saran</a></li>
                    </ul>
                </div>
                <div>
                    <h5>Layanan</h5>
                    <ul>
                        <li><a href="#">Sewa Aula</a></li>
                        <li><a href="#">Cek Ketersediaan</a></li>
                        <li><a href="#">Panduan Pemesanan</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h5>Hubungi Kami</h5>
                    <ul class="contact-list">
                        <li><i class="fa-solid fa-location-dot"></i> Jl. Timah Raya, Kawasan Industri Airkantung, Sungailiat, Bangka 33211</li>
                        <li><i class="fa-solid fa-phone"></i> +62-711-2341</li>
                        <li><i class="fa-solid fa-envelope"></i> info@polman-babel.ac.id</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Sistem Penyewaan Aula POLMAN Babel. Semua hak cipta dilindungi.</p>
        </div>
    </footer>

</body>
</html>