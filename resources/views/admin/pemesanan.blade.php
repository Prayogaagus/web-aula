<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pemesanan - Penyewaan Aula POLMAN Babel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-pemesanan.css') }}?v={{ time() }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-brand">
            <img src="{{ asset('images/Logo_Polman.png') }}" class="nav-logo" alt="Logo">
            <div class="brand-text">
                <div class="brand-title">Penyewaan Aula</div>
                <div class="brand-subtitle">POLMAN Babel</div>
            </div>
        </div>
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.pengguna') }}">Pengguna</a>
            <a href="{{ route('admin.pemesanan') }}" class="active">Pemesanan</a>
            <a href="{{ route('admin.fasilitas') }}">Fasilitas</a>
            <a href="{{ route('admin.kritik-saran') }}">Kritik & Saran</a>
            <a href="{{ route('admin.laporan.index') }}">Laporan</a>
        </div>
        <div class="user-profile">
            <div class="avatar">AU</div>
            <span>Admin Utama</span>
        </div>
    </nav>

    <section class="hero-section" style="background-image: linear-gradient(rgba(11, 58, 122, 0.85), rgba(11, 58, 122, 0.85)), url('{{ asset("images/aula_polman.jpeg") }}');">
        <h1>Kelola Pemesanan</h1>
        <p>Kelola data pemesanan aula dan pantau seluruh detail pelaksanaan acara.</p>
    </section>

    <main class="main-container">
        
        @if(session('success'))
            <div class="alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-danger">
                <strong><i class="fa-solid fa-triangle-exclamation"></i> Gagal memproses data:</strong>
                <ul>
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="card-panel">
            <form action="{{ route('admin.pemesanan') }}" method="GET" id="searchForm">
                <div class="filter-wrapper-booking">
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari penyewa, instansi, atau jenis acara..." onchange="document.getElementById('searchForm').submit();">
                    </div>
                    <button type="button" class="btn-tambah" onclick="toggleModal('modalTambahBooking', true)">
                        <i class="fa-solid fa-plus"></i> Buat Pemesanan Baru
                    </button>
                </div>
            </form>

            <table class="table-container">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Penyewa & Kontak</th>
                        <th>Instansi</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Detail Acara</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemesanans as $booking)
                    <tr>
                        <td><strong>#{{ $booking->id }}</strong></td>
                        <td>
                            <span class="text-primary-dark"><strong>{{ $booking->nama }}</strong></span><br>
                            <small class="text-muted"><i class="fa-solid fa-phone fa-xs"></i> {{ $booking->telp }}</small><br>
                            <small class="text-muted"><i class="fa-solid fa-envelope fa-xs"></i> {{ $booking->user->email ?? 'Tidak Terkait' }}</small>
                        </td>
                        <td>{{ $booking->instansi ?? '-' }}</td>
                        <td>
                            <i class="fa-regular fa-calendar-days text-orange"></i> {{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d F Y') }}<br>
                            <small class="text-muted"><i class="fa-regular fa-clock"></i> {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB</small>
                        </td>
                        <td>
                            <span class="badge-acara">{{ $booking->jenis_acara }}</span><br>
                            <small class="text-muted"><i class="fa-solid fa-users"></i> {{ $booking->jumlah_peserta }} Peserta</small>
                        </td>
                        <td><strong>Rp {{ number_format($booking->total, 0, ',', '.') }}</strong></td>
                        <td>
                            @if($booking->status == 'Menunggu Konfirmasi')
                                <span class="status-badge status-menunggu">Menunggu</span>
                            @elseif($booking->status == 'Dikonfirmasi')
                                <span class="status-badge status-dikonfirmasi">Dikonfirmasi</span>
                            @elseif($booking->status == 'Selesai')
                                <span class="status-badge status-selesai">Selesai</span>
                            @elseif($booking->status == 'Dibatalkan')
                                <span class="status-badge status-dibatalkan">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <button type="button" class="btn-action view" title="Lihat Catatan & Fasilitas"
                                        onclick="openDetailModal(this)"
                                        data-nama="{{ $booking->nama }}"
                                        data-jenis-acara="{{ $booking->jenis_acara }}"
                                        data-fasilitas="{{ $booking->fasilitas }}"
                                        data-catatan="{{ $booking->catatan }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                
                                <button type="button" class="btn-action edit" title="Edit Data" 
                                        onclick="openEditModal(this)"
                                        data-id="{{ $booking->id }}"
                                        data-user-id="{{ $booking->user_id }}"
                                        data-paket="{{ $booking->paket }}"
                                        data-nama="{{ $booking->nama }}"
                                        data-instansi="{{ $booking->instansi }}"
                                        data-telp="{{ $booking->telp }}"
                                        data-tanggal="{{ $booking->tanggal }}"
                                        data-jam-mulai="{{ $booking->jam_mulai }}"
                                        data-jam-selesai="{{ $booking->jam_selesai }}"
                                        data-jenis-acara="{{ $booking->jenis_acara }}"
                                        data-jumlah-peserta="{{ $booking->jumlah_peserta }}"
                                        data-total="{{ $booking->total }}"
                                        data-status="{{ $booking->status }}"
                                        data-catatan="{{ $booking->catatan }}"
                                        data-facilities="{{ json_encode($booking->facilities) }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                
                                <button type="button" class="btn-action delete" title="Hapus" 
                                        onclick="confirmDelete(this)"
                                        data-id="{{ $booking->id }}"
                                        data-nama="{{ $booking->nama }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 30px; color: #888;">Belum ada data pemesanan yang tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-wrapper">
                <div>Menampilkan {{ $pemesanans->firstItem() ?? 0 }} - {{ $pemesanans->lastItem() ?? 0 }} dari {{ $pemesanans->total() }} pemesanan</div>
                <div class="page-nav">
                    @if ($pemesanans->onFirstPage()) <span class="page-link-btn disabled">&lt;</span> @else <a href="{{ $pemesanans->previousPageUrl() }}" class="page-link-btn">&lt;</a> @endif
                    @foreach ($pemesanans->getUrlRange(1, $pemesanans->lastPage()) as $page => $url) <a href="{{ $url }}" class="page-link-btn {{ $page == $pemesanans->currentPage() ? 'active' : '' }}">{{ $page }}</a> @endforeach
                    @if ($pemesanans->hasMorePages()) <a href="{{ $pemesanans->nextPageUrl() }}" class="page-link-btn">&gt;</a> @else <span class="page-link-btn disabled">&gt;</span> @endif
                </div>
            </div>
        </div>
    </main>

    <div id="modalTambahBooking" class="modal-backdrop">
        <div class="modal-box modal-large">
            <div class="modal-header">
                <span><i class="fa-solid fa-calendar-plus"></i> Buat Pemesanan Baru</span>
                <button class="modal-close" onclick="toggleModal('modalTambahBooking', false)">&times;</button>
            </div>
            <form action="{{ route('admin.pemesanan.store') }}" method="POST">
                @csrf
                <div class="modal-body modal-grid">
                    <div class="form-group">
                        <label>Hubungkan ke Akun User</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Pilih Akun --</option>
                            @foreach($users as $user) <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option> @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label>Nama Penanggung Jawab</label><input type="text" name="nama" class="form-control" required></div>
                    <div class="form-group"><label>Nama Instansi / Organisasi</label><input type="text" name="instansi" class="form-control" placeholder="Kosongkan jika pribadi"></div>
                    <div class="form-group"><label>No. Telepon / WhatsApp</label><input type="text" name="telp" class="form-control" required></div>
                    <div class="form-group"><label>Tanggal Pelaksanaan</label><input type="date" name="tanggal" class="form-control" required></div>
                    <div class="form-group"><label>Jumlah Peserta</label><input type="number" name="jumlah_peserta" class="form-control" min="1" required></div>
                    <div class="form-group"><label>Jam Mulai Acara</label><input type="time" name="jam_mulai" class="form-control" required></div>
                    <div class="form-group"><label>Jam Selesai Acara</label><input type="time" name="jam_selesai" class="form-control" required></div>
                    
                    <div class="form-group"><label>Total Harga Penyewaan (Rp)</label><input type="number" name="total" class="form-control" placeholder="Contoh: 2500000" required></div>
                    <div class="form-group">
                        <label>Status Pemesanan</label>
                        <select name="status" class="form-control" required>
                            <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                            <option value="Dikonfirmasi">Dikonfirmasi</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pilihan Paket</label>
                        <select name="paket" class="form-control" required>
                            <option value="">-- Pilih Paket --</option>
                            <option value="Paket Resepsi">Paket Resepsi</option>
                            <option value="Paket Instansi Pendidikan">Paket Instansi Pendidikan</option>
                        </select>
                    </div>

                    <div class="form-group full-width"><label>Jenis / Nama Acara</label><input type="text" name="jenis_acara" class="form-control" placeholder="Contoh: Seminar Nasional, Pernikahan" required></div>
                    <div class="form-group full-width">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Fasilitas & Jumlah</label>
                        <div class="facilities-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; max-height: 200px; overflow-y: auto;">
                            @foreach($facilities as $index => $facility)
                                @php $isOutOfStock = $facility->jumlah <= 0; @endphp
                                <div class="facility-row" style="display: flex; align-items: center; gap: 8px; background: #f9f9f9; padding: 5px; border-radius: 4px; {{ $isOutOfStock ? 'opacity: 0.6;' : '' }}">
                                    <input type="hidden" name="fasilitas[{{ $index }}][id]" value="{{ $facility->id }}">
                                    
                                    <input type="checkbox" name="fasilitas[{{ $index }}][selected]" value="1" class="facility-checkbox" {{ $isOutOfStock ? 'disabled' : '' }}>
                                    
                                    <span style="flex-grow: 1; font-size: 13px;">
                                        {{ $facility->nama_fasilitas }}
                                        @if($isOutOfStock) <strong style="color: #dc2626;">(Habis)</strong> @endif
                                    </span>
                                    
                                    <input type="number" name="fasilitas[{{ $index }}][jumlah]" value="{{ $isOutOfStock ? 0 : 1 }}" min="{{ $isOutOfStock ? 0 : 1 }}" max="{{ $facility->jumlah }}" class="form-control facility-amount" style="width: 60px; height: 30px; padding: 2px;" disabled>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Centang fasilitas yang ingin disewa dan masukkan jumlahnya.</small>
                    </div>
                    <div class="form-group full-width"><label>Catatan Khusus</label><textarea name="catatan" class="form-control style-textarea" placeholder="Catatan tambahan mengenai alur acara..."></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="toggleModal('modalTambahBooking', false)">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Pemesanan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditBooking" class="modal-backdrop">
        <div class="modal-box modal-large">
            <div class="modal-header">
                <span><i class="fa-solid fa-calendar-check"></i> Edit Data Pemesanan</span>
                <button class="modal-close" onclick="toggleModal('modalEditBooking', false)">&times;</button>
            </div>
            <form id="formEditBooking" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body modal-grid">
                    <div class="form-group">
                        <label>Hubungkan ke Akun User</label>
                        <select name="user_id" id="edit_user_id" class="form-control" required>
                            @foreach($users as $user) <option value="{{ $user->id }}">{{ $user->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label>Nama Penanggung Jawab</label><input type="text" name="nama" id="edit_nama" class="form-control" required></div>
                    <div class="form-group"><label>Nama Instansi / Organisasi</label><input type="text" name="instansi" id="edit_instansi" class="form-control"></div>
                    <div class="form-group"><label>No. Telepon / WhatsApp</label><input type="text" name="telp" id="edit_telp" class="form-control" required></div>
                    <div class="form-group"><label>Tanggal Pelaksanaan</label><input type="date" name="tanggal" id="edit_tanggal" class="form-control" required></div>
                    <div class="form-group"><label>Jumlah Peserta</label><input type="number" name="jumlah_peserta" id="edit_jumlah_peserta" class="form-control" min="1" required></div>
                    <div class="form-group"><label>Jam Mulai Acara</label><input type="time" name="jam_mulai" id="edit_jam_mulai" class="form-control" required></div>
                    <div class="form-group"><label>Jam Selesai Acara</label><input type="time" name="jam_selesai" id="edit_jam_selesai" class="form-control" required></div>
                    
                    <div class="form-group"><label>Total Harga Penyewaan (Rp)</label><input type="number" name="total" id="edit_total" class="form-control" required></div>
                    <div class="form-group">
                        <label>Status Pemesanan (Admin Menu)</label>
                        <select name="status" id="edit_status" class="form-control" required>
                            <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                            <option value="Dikonfirmasi">Dikonfirmasi</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pilihan Paket</label>
                        <select name="paket" id="edit_paket" class="form-control" required>
                            <option value="">-- Pilih Paket --</option>
                            <option value="Paket Resepsi">Paket Resepsi</option>
                            <option value="Paket Instansi Pendidikan">Paket Instansi Pendidikan</option>
                        </select>
                    </div>

                    <div class="form-group full-width"><label>Jenis / Nama Acara</label><input type="text" name="jenis_acara" id="edit_jenis_acara" class="form-control" required></div>
                    <div class="form-group full-width">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Fasilitas & Jumlah</label>
                        <div class="facilities-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; max-height: 200px; overflow-y: auto;">
                            @foreach($facilities as $index => $facility)
                                @php $isOutOfStock = $facility->jumlah <= 0; @endphp
                                <div class="facility-row" data-id="{{ $facility->id }}" style="display: flex; align-items: center; gap: 8px; background: #f9f9f9; padding: 5px; border-radius: 4px; {{ $isOutOfStock ? 'opacity: 0.6;' : '' }}">
                                    <input type="hidden" name="fasilitas[{{ $index }}][id]" value="{{ $facility->id }}">
                                    
                                    <input type="checkbox" name="fasilitas[{{ $index }}][selected]" value="1" class="edit-facility-checkbox" {{ $isOutOfStock ? 'disabled' : '' }}>
                                    
                                    <span style="flex-grow: 1; font-size: 13px;">
                                        {{ $facility->nama_fasilitas }}
                                        @if($isOutOfStock) <strong style="color: #dc2626;">(Habis)</strong> @endif
                                    </span>
                                    
                                    <input type="number" name="fasilitas[{{ $index }}][jumlah]" value="{{ $isOutOfStock ? 0 : 1 }}" min="{{ $isOutOfStock ? 0 : 1 }}" max="{{ $facility->jumlah }}" data-global-stock="{{ $facility->jumlah }}" class="form-control edit-facility-amount" style="width: 60px; height: 30px; padding: 2px;" disabled>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Centang fasilitas yang ingin disewa dan masukkan jumlahnya.</small>
                    </div>
                    <div class="form-group full-width"><label>Catatan Khusus</label><textarea name="catatan" id="edit_catatan" class="form-control style-textarea"></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="toggleModal('modalEditBooking', false)">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalDetailBooking" class="modal-backdrop">
        <div class="modal-box">
            <div class="modal-header">
                <span><i class="fa-solid fa-circle-info"></i> Detail Tambahan Acara</span>
                <button class="modal-close" onclick="toggleModal('modalDetailBooking', false)">&times;</button>
            </div>
            <div class="modal-body">
                <p style="margin-bottom: 5px;"><strong>Penyewa:</strong> <span id="view_nama_penyewa"></span></p>
                <p style="margin-bottom: 15px;"><strong>Acara:</strong> <span id="view_nama_acara"></span></p>
                
                <label style="font-weight: bold; font-size: 13px; color: #334155;">Fasilitas Tambahan:</label>
                <div class="detail-box-preview" id="view_detail_fasilitas"></div>

                <label style="font-weight: bold; font-size: 13px; color: #334155;">Catatan Khusus Admin:</label>
                <div class="detail-box-preview" id="view_detail_catatan"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-primary" onclick="toggleModal('modalDetailBooking', false)">Tutup Detail</button>
            </div>
        </div>
    </div>

    <form id="formDeleteBooking" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <footer class="footer">
        <div class="footer-bottom">&copy; 2026 Sistem Penyewaan Aula POLMAN Babel. Semua hak cipta dilindungi.</div>
    </footer>

    <script>
        function toggleModal(modalId, isShow) {
            const modal = document.getElementById(modalId);
            if (isShow) modal.classList.add('show');
            else modal.classList.remove('show');
        }

        function openDetailModal(button) {
            const nama = button.getAttribute('data-nama');
            const acara = button.getAttribute('data-jenis-acara');
            const fasilitas = button.getAttribute('data-fasilitas');
            const catatan = button.getAttribute('data-catatan');

            document.getElementById('view_nama_penyewa').innerText = nama;
            document.getElementById('view_nama_acara').innerText = acara;
            document.getElementById('view_detail_fasilitas').innerText = (fasilitas === 'null' || !fasilitas) ? 'Tidak ada fasilitas tambahan.' : fasilitas;
            document.getElementById('view_detail_catatan').innerText = (catatan === 'null' || !catatan) ? 'Tidak ada catatan khusus.' : catatan;
            
            toggleModal('modalDetailBooking', true);
        }

        function openEditModal(button) {
            const id = button.getAttribute('data-id');
            const userId = button.getAttribute('data-user-id');
            const paket = button.getAttribute('data-paket');
            const nama = button.getAttribute('data-nama');
            const instansi = button.getAttribute('data-instansi');
            const telp = button.getAttribute('data-telp');
            const tanggal = button.getAttribute('data-tanggal');
            const jamMulai = button.getAttribute('data-jam-mulai');   
            const jamSelesai = button.getAttribute('data-jam-selesai'); 
            const jenisAcara = button.getAttribute('data-jenis-acara');
            const peserta = button.getAttribute('data-jumlah-peserta');
            const total = button.getAttribute('data-total');
            const status = button.getAttribute('data-status');
            const catatan = button.getAttribute('data-catatan');
            const facilitiesJson = button.getAttribute('data-facilities');

            // 1. Isi input dasar
            document.getElementById('edit_user_id').value = userId;
            document.getElementById('edit_paket').value = paket;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_instansi').value = (instansi === 'null' || !instansi ? '' : instansi);
            document.getElementById('edit_telp').value = telp;
            document.getElementById('edit_tanggal').value = tanggal;
            document.getElementById('edit_jam_mulai').value = jamMulai;
            document.getElementById('edit_jam_selesai').value = jamSelesai;
            document.getElementById('edit_jenis_acara').value = jenisAcara;
            document.getElementById('edit_jumlah_peserta').value = peserta;
            document.getElementById('edit_total').value = total;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_catatan').value = (catatan === 'null' || !catatan ? '' : catatan);

            // 2. Reset semua keadaan modal edit ke default global stock
            const rows = document.querySelectorAll('#modalEditBooking .facility-row');
            rows.forEach(row => {
                const cb = row.querySelector('.edit-facility-checkbox');
                const num = row.querySelector('.edit-facility-amount');
                const globalStock = parseInt(num.getAttribute('data-global-stock')) || 0;

                if (cb) {
                    cb.checked = false;
                    cb.disabled = (globalStock <= 0);
                }
                if (num) {
                    num.value = (globalStock > 0 ? 1 : 0);
                    num.min = (globalStock > 0 ? 1 : 0);
                    num.max = globalStock;
                    num.disabled = true; // Tetap nonaktif sebelum dicentang
                }
            });

            // 3. Rekalkulasi Atribut Validasi berdasarkan data pesanan lama
            if (facilitiesJson) {
                try {
                    const fasilitasData = JSON.parse(facilitiesJson);
                    
                    fasilitasData.forEach(f => {
                        const row = document.querySelector(`#modalEditBooking .facility-row[data-id="${f.id}"]`);
                        if (row) {
                            const checkbox = row.querySelector('.edit-facility-checkbox');
                            const numInput = row.querySelector('.edit-facility-amount');
                            const globalStock = parseInt(numInput.getAttribute('data-global-stock')) || 0;
                            
                            // Logika Krusial: Max yang diperbolehkan = Sisa stok di gudang + Stok yang sudah dipakai order ini
                            const maxBisaDipinjam = globalStock + f.pivot.jumlah_digunakan;

                            if (checkbox) {
                                checkbox.disabled = false;
                                checkbox.checked = true;
                            }
                            if (numInput) {
                                numInput.disabled = false;
                                numInput.min = 1; // Karena sedang terpakai, batas bawah kembali jadi 1
                                numInput.max = maxBisaDipinjam;
                                numInput.value = f.pivot.jumlah_digunakan;
                            }
                        }
                    });
                } catch (e) {
                    console.error("Gagal memproses data fasilitas:", e);
                }
            }

            // 4. Perbarui Form Action & Buka Modal
            document.getElementById('formEditBooking').action = `/admin/pemesanan/${id}`;
            toggleModal('modalEditBooking', true);
        }

        function confirmDelete(button) {
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-nama');
            
            if (confirm(`Apakah Anda yakin ingin menghapus data pemesanan atas nama "${name}"?`)) {
                const deleteForm = document.getElementById('formDeleteBooking');
                deleteForm.action = `/admin/pemesanan/${id}`;
                deleteForm.submit();
            }
        }

        // SINKRONISASI REALTIME ANTARA CHECKBOX & INPUT ANGKA
        document.addEventListener('DOMContentLoaded', function() {
            // Logika Sinkronisasi Modal Tambah
            const tambahCheckboxes = document.querySelectorAll('.facility-checkbox');
            tambahCheckboxes.forEach(cb => {
                const row = cb.closest('.facility-row');
                const numInput = row.querySelector('.facility-amount');
                
                cb.addEventListener('change', function() {
                    if (this.checked) {
                        numInput.disabled = false;
                        numInput.value = 1;
                    } else {
                        numInput.disabled = true;
                    }
                });
            });

            // Logika Sinkronisasi Modal Edit
            const editCheckboxes = document.querySelectorAll('.edit-facility-checkbox');
            editCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const row = this.closest('.facility-row');
                    const numInput = row.querySelector('.edit-facility-amount');
                    if (numInput) {
                        if (this.checked) {
                            numInput.disabled = false;
                            const currentVal = parseInt(numInput.value);
                            if (isNaN(currentVal) || currentVal <= 0) {
                                numInput.value = 1;
                            }
                        } else {
                            numInput.disabled = true;
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>