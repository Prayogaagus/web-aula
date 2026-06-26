<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Aula - POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}?v={{ time() }}">
</head>
<body class="booking-body">

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
            <h2>Form Pemesanan Aula</h2>
            <p>Lengkapi data di bawah ini untuk melakukan pemesanan Aula POLMAN Babel</p>
            
            <div class="stepper">
                <div class="step active">1</div>
                <div class="line"></div>
                <div class="step">2</div>
                <div class="line"></div>
                <div class="step">3</div>
                <div class="line"></div>
                <div class="step">4</div>
            </div>
        </div>
    </div>

    <div class="booking-container">
        <form action="{{ route('pemesanan.store') }}" method="POST">
            @csrf

            <div class="form-section-card">
                <div class="section-card-header">
                    <i class="fa-solid fa-user-gear icon-title"></i>
                    <h3>1. Data Pemesanan</h3>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="instansi">Instansi/Perusahaan</label>
                        <input type="text" id="instansi" name="instansi" placeholder="Masukkan Instansi atau Perusahaan">
                    </div>
                    <div class="form-group">
                        <label for="telp">No. Telepon/WhatsApp <span class="required">*</span></label>
                        <input type="tel" id="telp" name="telp" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" placeholder="nama@gmail.com" required>
                    </div>
                </div>
            </div>

            <div class="form-section-card">
                <div class="section-card-header">
                    <i class="fa-solid fa-file-text icon-title"></i>
                    <h3>2. Detail Pemesanan</h3>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Penggunaan <span class="required">*</span></label>
                        <div class="input-icon-wrapper">
                            <input type="date" id="tanggal" name="tanggal" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jam_mulai">Waktu Mulai <span class="required">*</span></label>
                        <input type="time" id="jam_mulai" name="jam_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="jam_selesai">Waktu Selesai <span class="required">*</span></label>
                        <input type="time" id="jam_selesai" name="jam_selesai" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_acara">Jenis Acara <span class="required">*</span></label>
                        <input type="text" id="jenis_acara" name="jenis_acara" placeholder="Contoh: Seminar, Rapat, Pernikahan" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="jumlah_peserta">Jumlah Peserta</label>
                        <select id="jumlah_peserta" name="jumlah_peserta">
                            <option value="" disabled selected>Pilih jumlah peserta</option>
                            <option value="< 100">&lt; 100 Orang</option>
                            <option value="100 - 300">100 - 300 Orang</option>
                            <option value="300 - 500">300 - 500 Orang</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section-card">
                <div class="section-card-header">
                    <i class="fa-solid fa-heart-pulse icon-title"></i>
                    <h3>3. Fasilitas Tambahan (Opsional)</h3>
                </div>
                <div class="checkbox-grid">
                    <label class="facility-box">
                        <input type="checkbox" name="fasilitas[]" value="Sound System">
                        <span class="box-text">Sound System</span>
                    </label>
                    <label class="facility-box">
                        <input type="checkbox" name="fasilitas[]" value="Proyektor">
                        <span class="box-text">Proyektor</span>
                    </label>
                    <label class="facility-box">
                        <input type="checkbox" name="fasilitas[]" value="Proyektor_2">
                        <span class="box-text">Proyektor</span>
                    </label>
                    <label class="facility-box">
                        <input type="checkbox" name="fasilitas[]" value="Proyektor_3">
                        <span class="box-text">Proyektor</span>
                    </label>
                    <label class="facility-box">
                        <input type="checkbox" name="fasilitas[]" value="Meja Tambahan">
                        <span class="box-text">Meja Tambahan</span>
                    </label>
                    <label class="facility-box">
                        <input type="checkbox" name="fasilitas[]" value="Panggung">
                        <span class="box-text">Panggung</span>
                    </label>
                    
                    <div class="facility-combo-box">
                        <label class="facility-inner-check">
                            <input type="checkbox" name="fasilitas[]" value="Parkir Tambahan">
                            <span>Parkir Tambahan</span>
                        </label>
                        <div class="other-input-row">
                            <label><input type="checkbox" name="fasilitas[]" value="Lainnya"> Lainnya</label>
                            <input type="text" name="fasilitas_lainnya" placeholder="Sebutkan kebutuhan lain">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section-card">
                <div class="section-card-header">
                    <i class="fa-solid fa-file-lines icon-title"></i>
                    <h3>4. Catatan Tambahan (Opsional)</h3>
                </div>
                <textarea id="catatan" name="catatan" rows="3" placeholder="Tuliskan catatan tambahan (jika ada)"></textarea>
            </div>

            <div class="info-alert-box">
                <div class="info-icon"><i class="fa-solid fa-circle-info"></i></div>
                <div class="info-text">
                    <h4>Informasi</h4>
                    <p>Setelah form dikirim, Anda akan diarahkan ke halaman pembayaran. Pastikan data yang Anda masukkan sudah benar.</p>
                </div>
            </div>

            <div class="form-actions-container">
                <button type="submit" class="btn-orange-submit">Pesan Sekarang</button>
            </div>
        </form>
    </div>

</body>
</html>