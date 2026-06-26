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
                                        onclick="openDetailModal('{{ addslashes($booking->nama) }}', '{{ addslashes($booking->jenis_acara) }}', '{{ addslashes($booking->fasilitas) }}', '{{ addslashes($booking->catatan) }}')">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button type="button" class="btn-action edit" title="Edit Data" 
                                        onclick="openEditModal('{{ $booking->id }}', '{{ $booking->user_id }}', '{{ addslashes($booking->nama) }}', '{{ addslashes($booking->instansi) }}', '{{ addslashes($booking->telp) }}', '{{ $booking->tanggal }}', '{{ $booking->jam_mulai }}', '{{ $booking->jam_selesai }}', '{{ addslashes($booking->jenis_acara) }}', '{{ $booking->jumlah_peserta }}', '{{ $booking->total }}', '{{ $booking->status }}', '{{ addslashes($booking->fasilitas) }}', '{{ addslashes($booking->catatan) }}')">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button type="button" class="btn-action delete" title="Hapus" 
                                        onclick="confirmDelete('{{ $booking->id }}', '{{ addslashes($booking->nama) }}')">
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
                    @if ($pemesanans->onFirstPage()) <span class="page-link-btn disabled"><</span> @else <a href="{{ $pemesanans->previousPageUrl() }}" class="page-link-btn"><</a> @endif
                    @foreach ($pemesanans->getUrlRange(1, $pemesanans->lastPage()) as $page => $url) <a href="{{ $url }}" class="page-link-btn {{ $page == $pemesanans->currentPage() ? 'active' : '' }}">{{ $page }}</a> @endforeach
                    @if ($pemesanans->hasMorePages()) <a href="{{ $pemesanans->nextPageUrl() }}" class="page-link-btn">></a> @else <span class="page-link-btn disabled">></span> @endif
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

                    <div class="form-group full-width"><label>Jenis / Nama Acara</label><input type="text" name="jenis_acara" class="form-control" placeholder="Contoh: Seminar Nasional, Pernikahan" required></div>
                    <div class="form-group full-width"><label>Fasilitas Tambahan</label><textarea name="fasilitas" class="form-control style-textarea" placeholder="Kursi tambahan, sound system, proyektor..."></textarea></div>
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

                    <div class="form-group full-width"><label>Jenis / Nama Acara</label><input type="text" name="jenis_acara" id="edit_jenis_acara" class="form-control" required></div>
                    <div class="form-group full-width"><label>Fasilitas Tambahan</label><textarea name="fasilitas" id="edit_fasilitas" class="form-control style-textarea"></textarea></div>
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

        // Fungsi menampilkan isi teks Catatan & Fasilitas secara utuh ke dalam modal popup
        function openDetailModal(nama, acara, fasilitas, catatan) {
            document.getElementById('view_nama_penyewa').innerText = nama;
            document.getElementById('view_nama_acara').innerText = acara;
            document.getElementById('view_detail_fasilitas').innerText = (fasilitas === 'null' || fasilitas === '') ? 'Tidak ada fasilitas tambahan.' : fasilitas;
            document.getElementById('view_detail_catatan').innerText = (catatan === 'null' || catatan === '') ? 'Tidak ada catatan khusus.' : catatan;
            
            toggleModal('modalDetailBooking', true);
        }

        function openEditModal(id, userId, nama, instansi, telp, tanggal, jamMulai, jamSelesai, jenisAcara, peserta, total, status, fasilitas, catatan) {
            document.getElementById('edit_user_id').value = userId;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_instansi').value = instansi === 'null' ? '' : instansi;
            document.getElementById('edit_telp').value = telp;
            document.getElementById('edit_tanggal').value = tanggal;
            document.getElementById('edit_jam_mulai').value = jamMulai;
            document.getElementById('edit_jam_selesai').value = jamSelesai;
            document.getElementById('edit_jenis_acara').value = jenisAcara;
            document.getElementById('edit_jumlah_peserta').value = peserta;
            document.getElementById('edit_total').value = total;
            document.getElementById('edit_status').value = status; // Mapping data status ke dropdown select edit modal
            document.getElementById('edit_fasilitas').value = fasilitas === 'null' ? '' : fasilitas;
            document.getElementById('edit_catatan').value = catatan === 'null' ? '' : catatan;

            document.getElementById('formEditBooking').action = `/admin/pemesanan/${id}`;
            toggleModal('modalEditBooking', true);
        }

        function confirmDelete(id, name) {
            if (confirm(`Apakah Anda yakin ingin menghapus data pemesanan atas nama "${name}"?`)) {
                const deleteForm = document.getElementById('formDeleteBooking');
                deleteForm.action = `/admin/pemesanan/${id}`;
                deleteForm.submit();
            }
        }
    </script>
</body>
</html>