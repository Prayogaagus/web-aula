<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kritik dan Saran - POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/kritik-saran.css') }}?v={{ time() }}">
</head>
<body class="feedback-body">

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
            <li><a href="#" class="active">Kritik & Saran</a></li>
        </ul>
        <div class="nav-auth">
            <a href="#" class="btn-logout">Log Out</a>
        </div>
    </nav>

    <div class="hero-feedback-banner">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Kritik dan Saran</h1>
            <p>Kami sangat menghargai masukan Anda untuk meningkatkan layanan kami.</p>
        </div>
    </div>

    <div class="feedback-container">
        <form action="#" method="POST">
            @csrf

            <div class="form-section-title">
                <i class="fa-solid fa-user-gear section-icon"></i>
                <h2>Data Pemesan</h2>
            </div>
            
            <div class="form-card">
                <div class="input-grid-2">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Instansi/Perusahaan (Opsional)</label>
                        <input type="text" name="instansi" placeholder="Masukkan Instansi atau Perusahaan">
                    </div>
                </div>
                <div class="input-grid-2 mt-3">
                    <div class="form-group">
                        <label>No. Telepon/WhatsApp (Opsional)</label>
                        <input type="text" name="no_telepon" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" placeholder="nama@gmail.com" required>
                    </div>
                </div>
            </div>

            <div class="form-section-title">
                <i class="fa-solid fa-list-check section-icon"></i>
                <h2>Jenis Masukan</h2>
            </div>

            <div class="category-grid">
                <label class="category-card">
                    <input type="radio" name="jenis_masukan" value="Kritik" required>
                    <div class="card-content">
                        <i class="fa-solid fa-comments icon-kritik"></i>
                        <h3>Kritik</h3>
                        <p>Sampaikan hal yang perlu kami perbaiki.</p>
                        <span class="custom-radio"></span>
                    </div>
                </label>

                <label class="category-card">
                    <input type="radio" name="jenis_masukan" value="Saran">
                    <div class="card-content">
                        <i class="fa-solid fa-lightbulb icon-saran"></i>
                        <h3>Saran</h3>
                        <p>Berikan ide atau saran untuk kami.</p>
                        <span class="custom-radio"></span>
                    </div>
                </label>

                <label class="category-card">
                    <input type="radio" name="jenis_masukan" value="Apresiasi">
                    <div class="card-content">
                        <i class="fa-solid fa-thumbs-up icon-apresiasi"></i>
                        <h3>Apresiasi</h3>
                        <p>Sampaikan pengalaman positif Anda.</p>
                        <span class="custom-radio"></span>
                    </div>
                </label>

                <label class="category-card">
                    <input type="radio" name="jenis_masukan" value="Lainnya">
                    <div class="card-content">
                        <i class="fa-solid fa-ellipsis icon-lainnya"></i>
                        <h3>Lainnya</h3>
                        <p>Masukan lainnya.</p>
                        <span class="custom-radio"></span>
                    </div>
                </label>
            </div>

            <div class="form-section-title">
                <i class="fa-solid fa-comment-dots section-icon"></i>
                <h2>Pesan Anda</h2>
            </div>
            
            <div class="form-card">
                <div class="form-group">
                    <label>Tulis kritik atau saran Anda <span class="required">*</span></label>
                    <textarea name="pesan" rows="5" placeholder="Tuliskan pesan Anda di sini..." maxlength="1000" id="pesanTextArea" required></textarea>
                    <span class="char-count" id="charCounter">0/1000</span>
                </div>
            </div>

            <div class="form-section-title">
                <i class="fa-solid fa-paperclip section-icon"></i>
                <h2>Penilaian Layanan</h2>
            </div>
            
            <div class="form-card">
                <label class="rating-label">Berikan Penilaian Anda.</label>
                <div class="star-rating-wrapper">
                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" class="fa-regular fa-star"></label>
                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" class="fa-regular fa-star"></label>
                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" class="fa-regular fa-star"></label>
                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" class="fa-regular fa-star"></label>
                    <input type="radio" id="star1" name="rating" value="1" required /><label for="star1" class="fa-regular fa-star"></label>
                </div>
            </div>

            <div class="info-alert-box">
                <i class="fa-solid fa-circle-info info-icon"></i>
                <div class="info-text-content">
                    <h4>Informasi</h4>
                    <p>Masukan Anda akan membantu kami memberikan layanan yang lebih baik. Semua data yang Anda berikan akan kami jaga kerahasiaannya.</p>
                </div>
            </div>

            <button type="submit" class="btn-submit-feedback">Kirim Masukan</button>

        </form>
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

    <script>
        const textarea = document.getElementById('pesanTextArea');
        const counter = document.getElementById('charCounter');
        textarea.addEventListener('input', () => {
            counter.textContent = `${textarea.value.length}/1000`;
        });

        const stars = document.querySelectorAll('.star-rating-wrapper label');
        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                stars.forEach((s, i) => {
                    if(i >= index) {
                        s.classList.remove('fa-regular');
                        s.classList.add('fa-solid');
                    } else {
                        s.classList.remove('fa-solid');
                        s.classList.add('fa-regular');
                    }
                });
            });
        });
    </script>
</body>
</html>