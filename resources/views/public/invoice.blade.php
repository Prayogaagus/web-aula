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
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('detail.aula') }}">Detail Aula</a></li>
            <li><a href="{{ route('jadwal') }}">Jadwal</a></li>
            <li><a href="{{ route('kritik') }}">Kritik & Saran</a></li>
        </ul>
        <div class="nav-auth">
            @auth
                <span class="user-name" style="margin-right: 15px; color: #333; font-weight: 600;">
                    <i class="fa-solid fa-user-circle"></i> {{ Auth::user()->name }}
                </span>
                <a href="{{ route('logout') }}" class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none; padding: 8px 16px; background-color: #e11d48; color: white; border-radius: 6px; font-weight: 600;">
                    Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login" style="text-decoration: none; margin-right: 10px;">Masuk</a>
                <a href="{{ route('register') }}" class="btn-register" style="text-decoration: none;">Daftar</a>
            @endauth
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
                        <td>: {{ $pemesanan->kode_pemesanan }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>: {{ $pemesanan->created_at->format('d M Y') }}</td>
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
                        <td class="value">{{ $pemesanan->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label">Instansi</td>
                        <td class="value">{{ $pemesanan->instansi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">No. Telepon</td>
                        <td class="value">{{ $pemesanan->telp }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="value">{{ $pemesanan->user->email ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="data-column">
                <h3>Detail Pemesanan</h3>
                <table class="info-table">
                    <tr>
                        <td class="label">Tanggal</td>
                        <td class="value">{{ date('d M Y', strtotime($pemesanan->tanggal)) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Waktu</td>
                        <td class="value">{{ date('H.i', strtotime($pemesanan->jam_mulai)) }} - {{ date('H.i', strtotime($pemesanan->jam_selesai)) }} WIB</td>
                    </tr>
                    <tr>
                        <td class="label">Acara</td>
                        <td class="value">{{ $pemesanan->jenis_acara }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jumlah Peserta</td>
                        <td class="value">{{ $pemesanan->jumlah_peserta }} Orang</td>
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
                            <th>Deskripsi Item Layanan</th>
                            <th style="width: 12%">Jumlah</th>
                            <th style="width: 22%">Harga Satuan</th>
                            <th style="width: 22%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="center">1</td>
                            <td>
                                @if(($pemesanan->paket ?? '') === 'Paket Resepsi')
                                    <strong>Sewa Ruangan: Paket Resepsi Pernikahan / Umum</strong>
                                @elseif(($pemesanan->paket ?? '') === 'Paket Instansi Pendidikan')
                                    <strong>Sewa Ruangan: Paket Instansi Pendidikan & Kampus</strong>
                                @else
                                    <strong>Sewa Ruangan: {{ $pemesanan->paket }}</strong>
                                @endif
                            </td>
                            <td class="center">1</td>
                            @php
                                $hargaDasarGedung = ($pemesanan->paket === 'Paket Resepsi') ? 8950000 : 4500000;
                            @endphp
                            <td>Rp {{ number_format($hargaDasarGedung, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($hargaDasarGedung, 0, ',', '.') }}</td>
                        </tr>
                        
                        @php $no = 2; @endphp
                        @foreach($splitFasilitas as $item)
                            @if(!empty($item))
                                @php
                                    $namaFasilitas = trim($item);
                                    $jumlahUnit = 1;
                                    $hargaSatuan = 0;
                                    $subtotalFasilitas = 0;

                                    // Membedah teks string "Nama Fasilitas (Jumlah)" menggunakan regex
                                    if (preg_match('/^(.+)\s\((\d+)\)$/', $item, $matches)) {
                                        $namaFasilitas = trim($matches[1]);
                                        $jumlahUnit = (int)$matches[2];
                                    }

                                    // Mencari harga asli dari database master berdasarkan nama
                                    $facility = \App\Models\Facility::where('nama_fasilitas', $namaFasilitas)->first();
                                    if ($facility) {
                                        $hargaSatuan = $facility->harga;
                                        $subtotalFasilitas = $hargaSatuan * $jumlahUnit;
                                    }
                                @endphp
                                <tr>
                                    <td class="center">{{ $no++ }}</td>
                                    <td>Fasilitas Tambahan: {{ $namaFasilitas }}</td>
                                    <td class="center">{{ $jumlahUnit }}</td>
                                    <td>
                                        @if($hargaSatuan > 0)
                                            Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                                        @else
                                            Termasuk
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($subtotalFasilitas, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="summary-calculation-box">
                <div class="calc-row">
                    <span>Subtotal</span>
                    <span class="calc-val">Rp {{ number_format($pemesanan->total, 0, ',', '.') }}</span>
                </div>
                <div class="calc-row">
                    <span>Biaya Layanan</span>
                    <span class="calc-val">Rp 0</span>
                </div>
                <div class="calc-total-row">
                    <span>Total Pembayaran</span>
                    <span class="total-val">Rp {{ number_format($pemesanan->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="footer-note-grid">
            <div class="catatan-box">
                <h4>Catatan Penting</h4>
                <ul>
                    <li>Status Pemesanan Anda saat ini adalah: <strong>{{ $pemesanan->status }}</strong></li>
                    <li>Pembayaran harus dilakukan sebelum batas waktu yang ditentukan admin.</li>
                    <li>Invoice ini berlaku sebagai bukti pendaftaran pesanan sistem yang sah.</li>
                </ul>

                @if($pemesanan->catatan)
                <h4 style="margin-top: 1.25rem; color: #1e293b;"><i class="fa-solid fa-comment-dots"></i> Catatan Tambahan Anda:</h4>
                <div style="background-color: #f8fafc; padding: 0.75rem 1rem; border-left: 4px solid #f97316; font-style: italic; color: #475569; border-radius: 0 6px 6px 0; font-size: 0.9rem; margin-top: 0.25rem;">
                    {{ $pemesanan->catatan }}
                </div>
                @endif
            </div>
            
            <div class="signature-box">
                <p class="greeting">Konfirmasi Pembayaran di Bawah ini:</p>
                
                @php
                    $nomorWA = '628123456789'; 
                    $pesanWA = rawurlencode("Halo Admin Aula POLMAN Babel, saya ingin mengonfirmasi pemesanan aula dengan Kode Invoice: " . $pemesanan->kode_pemesanan . ". Berikut rincian data atas nama " . $pemesanan->nama . ".");
                @endphp
                
                <a href="https://wa.me/{{ $nomorWA }}?text={{ $pesanWA }}" target="_blank" class="btn-whatsapp-invoice">
                    <i class="fa-brands fa-whatsapp"></i> Hubungi via WhatsApp
                </a>
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
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('detail.aula') }}">Detail Aula</a></li>
                        <li><a href="{{ route('jadwal') }}">Jadwal</a></li>
                        <li><a href="{{ route('kritik') }}">Kritik & Saran</a></li>
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