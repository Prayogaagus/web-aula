<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Aula - POLMAN BABEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}?v={{ time() }}">
    <style>
        .facility-box.disabled-box {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            cursor: not-allowed;
            opacity: 0.7;
        }
        /* Style tambahan untuk input jumlah */
        .qty-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed #e2e8f0;
        }
        .qty-input {
            width: 70px;
            padding: 4px 8px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font-weight: 600;
            color: #334155;
        }
        .qty-input:disabled {
            background-color: #f1f5f9;
            color: #94a3b8;
        }
    </style>
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

    <div class="top-blue-hero">
        <div class="hero-inner">
            <h2>Form Pemesanan Aula</h2>
            <p>Lengkapi data di bawah ini untuk melakukan pemesanan Aula POLMAN Babel</p>
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
                        <input type="text" id="nama" name="nama" value="{{ Auth::check() ? Auth::user()->name : '' }}" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="instansi">Instansi/Perusahaan</label>
                        <input type="text" id="instansi" name="instansi" placeholder="Masukkan Instansi atau Perusahaan">
                    </div>
                    <div class="form-group">
                        <label for="telp">No. Telepon/WhatsApp <span class="required">*</span></label>
                        <input type="tel" id="telp" name="telp" value="{{ Auth::check() ? Auth::user()->phone : '' }}" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" placeholder="nama@gmail.com" required readonly>
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
                        <input type="date" id="tanggal" name="tanggal" required>
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
                        <label for="jumlah_peserta">Jumlah Peserta <span class="required">*</span></label>
                        <select id="jumlah_peserta" name="jumlah_peserta" required>
                            <option value="" disabled selected>Pilih jumlah peserta</option>
                            <option value="100">Kurang dari 100 Orang</option>
                            <option value="300">100 - 300 Orang</option>
                            <option value="500">300 - 500 Orang</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section-card">
                <div class="section-card-header">
                    <i class="fa-solid fa-heart-pulse icon-title"></i>
                    <h3>3. Fasilitas Tambahan (Opsional)</h3>
                </div>
                <div class="checkbox-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">
                    @if(isset($facilities) && !$facilities->isEmpty())
                        @foreach($facilities as $index => $facility)
                            <div class="facility-box {{ $facility->status === 'Tidak Tersedia' || $facility->jumlah < 1 ? 'disabled-box' : '' }}" style="border: 1px solid #cbd5e1; padding: 15px; border-radius: 8px; display: flex; flex-direction: column; justify-content: space-between;">
                                <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-weight: 600;">
                                    <input type="checkbox" 
                                           name="fasilitas[{{ $index }}][id]" 
                                           value="{{ $facility->id }}" 
                                           class="facility-checkbox"
                                           data-target="qty-{{ $facility->id }}"
                                           {{ $facility->status === 'Tidak Tersedia' || $facility->jumlah < 1 ? 'disabled' : '' }}
                                           onchange="toggleQuantity(this)">
                                    <span class="box-text" style="font-size: 0.95rem; color: #334155;">
                                        {{ $facility->nama_fasilitas }}
                                        <div style="font-size: 0.8rem; color: #64748b; font-weight: normal; margin-top: 2px;">
                                            Harga: Rp {{ number_format($facility->harga, 0, ',', '.') }} | Stok: <strong>{{ $facility->jumlah }}</strong>
                                        </div>
                                        @if($facility->status === 'Tidak Tersedia' || $facility->jumlah < 1)
                                            <small style="color: #ef4444; font-weight: bold; display: block; margin-top: 2px;">(Tidak Tersedia)</small>
                                        @endif
                                    </span>
                                </label>

                                @if($facility->status === 'Tersedia' && $facility->jumlah > 0)
                                    <div class="qty-wrapper">
                                        <label style="font-size: 0.85rem; color: #475569;">Jumlah Dibutuhkan:</label>
                                        <input type="number" 
                                               id="qty-{{ $facility->id }}" 
                                               name="fasilitas[{{ $index }}][jumlah]" 
                                               class="qty-input"
                                               value="1" 
                                               min="1" 
                                               max="{{ $facility->jumlah }}" 
                                               disabled 
                                               required>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p style="grid-column: 1 / -1; color: #94a3b8; font-size: 0.9rem;">Daftar fasilitas master belum dikonfigurasi.</p>
                    @endif
                    
                    <div class="facility-combo-box" style="grid-column: 1 / -1; margin-top: 1rem;">
                        <div class="other-input-row">
                            <input type="text" name="fasilitas_lainnya" placeholder="Sebutkan kebutuhan lain diluar pilihan diatas (jika ada)" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section-card">
                <div class="section-card-header">
                    <i class="fa-solid fa-box-open icon-title"></i>
                    <h3>Pilih Paket</h3>
                </div>
                <div class="radio-group" style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <label class="package-option">
                        <input type="radio" name="paket" value="Paket Resepsi" required>
                        <div class="package-box">Paket Resepsi (Rp 8.950.000)</div>
                    </label>
                    <label class="package-option">
                        <input type="radio" name="paket" value="Paket Instansi Pendidikan" required>
                        <div class="package-box">Paket Instansi Pendidikan (Rp 4.500.000)</div>
                    </label>
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

    <script>
        function toggleQuantity(checkbox) {
            const targetId = checkbox.getAttribute('data-target');
            const qtyInput = document.getElementById(targetId);
            
            if (qtyInput) {
                if (checkbox.checked) {
                    qtyInput.disabled = false;
                    qtyInput.focus();
                } else {
                    qtyInput.disabled = true;
                    qtyInput.value = 1; // Reset ke default
                }
            }
        }
    </script>
</body>
</html>