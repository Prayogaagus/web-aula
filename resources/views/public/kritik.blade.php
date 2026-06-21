<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kritik & Saran - POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/kritik.css') }}?v={{ time() }}">
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
                <li><a href="{{ route('jadwal') }}">Jadwal</a></li>
                <li><a href="{{ route('kritik') }}">Kritik & Saran</a></li>
            </ul>
            <div class="nav-auth">
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                <a href="{{ route('register') }}" class="btn-register">Daftar</a>
            </div>
        </div>
    </nav>

    <header class="kritik-hero">
        <div class="container">
            <h1>Kritik & Saran</h1>
            <p>Bantu kami meningkatkan layanan penyewaan aula</p>
        </div>
    </header>

    <main class="kritik-section">
        <div class="container">
            
            <div class="form-card">
                <h2>Kirim Masukan Anda</h2>
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap Anda">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="contoh@email.com">
                    </div>

                    <div class="form-group">
                        <label for="jenis">Jenis Masukan</label>
                        <select id="jenis" name="jenis" class="form-control">
                            <option value="" disabled selected>Pilih jenis masukan</option>
                            <option value="Kritik">Kritik</option>
                            <option value="Saran">Saran</option>
                            <option value="Keluhan">Keluhan/Aduan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea id="pesan" name="pesan" class="form-control" rows="5" placeholder="Tuliskan masukan anda di sini..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Penilaian Layanan</label>
                        <div class="rating-stars">
                            <i class="fa-regular fa-star" onclick="setRating(1)"></i>
                            <i class="fa-regular fa-star" onclick="setRating(2)"></i>
                            <i class="fa-regular fa-star" onclick="setRating(3)"></i>
                            <i class="fa-regular fa-star" onclick="setRating(4)"></i>
                            <i class="fa-regular fa-star" onclick="setRating(5)"></i>
                        </div>
                        <input type="hidden" id="rating-value" name="rating" value="0">
                    </div>

                    <button type="submit" class="btn-submit-kritik">Kirim Masukan</button>
                </form>
            </div>

            <h3 class="testimonial-title">Apa Kata Mereka?</h3>
            <div class="testimonial-grid">
                
                <div class="testimonial-card">
                    <div class="testi-header">
                        <div class="avatar-initial">EM</div>
                        <div class="user-info">
                            <h4>Evan Mahesa</h4>
                            <span>15 Mei 2024</span>
                        </div>
                    </div>
                    <div class="testi-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="testi-text">Mantep nian</p>
                </div>

                <div class="testimonial-card">
                    <div class="testi-header">
                        <div class="avatar-initial">AA</div>
                        <div class="user-info">
                            <h4>Akbar</h4>
                            <span>10 Mei 2024</span>
                        </div>
                    </div>
                    <div class="testi-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                    </div>
                    <p class="testi-text">Ni la tempat paling nyaman</p>
                </div>

                <div class="testimonial-card">
                    <div class="testi-header">
                        <div class="avatar-initial">DF</div>
                        <div class="user-info">
                            <h4>Danis</h4>
                            <span>28 April 2024</span>
                        </div>
                    </div>
                    <div class="testi-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="testi-text">Yang penting komen</p>
                </div>

                <div class="testimonial-card">
                    <div class="testi-header">
                        <div class="avatar-initial">AP</div>
                        <div class="user-info">
                            <h4>Agus</h4>
                            <span>20 April 2024</span>
                        </div>
                    </div>
                    <div class="testi-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                    </div>
                    <p class="testi-text">Tempet ape ni hebener ee, nyaman nian</p>
                </div>

                <div class="testimonial-card">
                    <div class="testi-header">
                        <div class="avatar-initial">R</div>
                        <div class="user-info">
                            <h4>Revaldo</h4>
                            <span>12 April 2024</span>
                        </div>
                    </div>
                    <div class="testi-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="testi-text">Mwehehehe</p>
                </div>

                <div class="testimonial-card">
                    <div class="testi-header">
                        <div class="avatar-initial">JJ</div>
                        <div class="user-info">
                            <h4>Jojo</h4>
                            <span>5 April 2024</span>
                        </div>
                    </div>
                    <div class="testi-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                    </div>
                    <p class="testi-text">Saya akan pergi ke midlane</p>
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

    <script>
        function setRating(ratingValue) {
            document.getElementById('rating-value').value = ratingValue;
            const stars = document.querySelectorAll('.rating-stars i');
            
            stars.forEach((star, index) => {
                if (index < ratingValue) {
                    star.className = "fa-solid fa-star active";
                } else {
                    star.className = "fa-regular fa-star";
                }
            });
        }
    </script>
</body>
</html>