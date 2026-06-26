<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Penyewaan Aula POLMAN Babel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-pengguna.css') }}?v={{ time() }}">
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
            <a href="{{ route('admin.pengguna') }}" class="active">Pengguna</a>
            <a href="{{ route('admin.pemesanan') }}">Pemesanan</a>
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
        <h1>Kelola Pengguna</h1>
        <p>Kelola data pengguna dan admin sistem.</p>
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
            <form action="{{ route('admin.pengguna') }}" method="GET" id="filterForm">
                <div class="filter-wrapper">
                    <div class="tabs-peran">
                        <a href="{{ route('admin.pengguna', ['role' => 'all', 'search' => request('search')]) }}" class="tab-item {{ request('role') == 'all' || !request('role') ? 'active' : '' }}">Semua Pengguna</a>
                        <a href="{{ route('admin.pengguna', ['role' => 'Penyewa', 'search' => request('search')]) }}" class="tab-item {{ request('role') == 'Penyewa' ? 'active' : '' }}">Penyewa</a>
                        <a href="{{ route('admin.pengguna', ['role' => 'Admin', 'search' => request('search')]) }}" class="tab-item {{ request('role') == 'Admin' ? 'active' : '' }}">Admin</a>
                    </div>
                    
                    <div class="search-filter-box">
                        <div class="search-input-wrapper">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, nomor telepon, atau alamat..." onchange="document.getElementById('filterForm').submit();">
                        </div>
                        <div class="right-filters">
                            <input type="hidden" name="role" value="{{ request('role', 'all') }}">
                            <button type="button" class="btn-tambah" onclick="toggleModal('modalTambah', true)"><i class="fa-solid fa-plus"></i> Tambah Pengguna</button>
                        </div>
                    </div>
                </div>
            </form>

            <table class="table-container">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Peran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $key => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $key }}</td>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>{{ $user->address ?? '-' }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <div class="action-btns">
                                <button type="button" class="btn-action edit" title="Edit" 
                                        onclick="openEditModal('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ addslashes($user->phone) }}', '{{ addslashes($user->role) }}', '{{ addslashes($user->address) }}')">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button type="button" class="btn-action delete" title="Hapus" 
                                        onclick="confirmDelete('{{ $user->id }}', '{{ addslashes($user->name) }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #888;">Data pengguna tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-wrapper">
                <div class="data-info">
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
                </div>
                <div class="page-nav">
                    @if ($users->onFirstPage()) <span class="page-link-btn" style="color: #ccc; cursor: not-allowed;"><</span> @else <a href="{{ $users->previousPageUrl() }}" class="page-link-btn"><</a> @endif
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url) <a href="{{ $url }}" class="page-link-btn {{ $page == $users->currentPage() ? 'active' : '' }}">{{ $page }}</a> @endforeach
                    @if ($users->hasMorePages()) <a href="{{ $users->nextPageUrl() }}" class="page-link-btn">></a> @else <span class="page-link-btn" style="color: #ccc; cursor: not-allowed;">></span> @endif
                </div>
            </div>
        </div>
    </main>

    <div id="modalTambah" class="modal-backdrop">
        <div class="modal-box">
            <div class="modal-header">
                <span>Tambah Pengguna Baru</span>
                <button class="modal-close" onclick="toggleModal('modalTambah', false)">&times;</button>
            </div>
            <form action="{{ route('admin.pengguna.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" class="form-control" required></div>
                    <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="form-group"><label>No. Telepon</label><input type="text" name="phone" class="form-control"></div>
                    <div class="form-group">
                        <label>Peran (Role)</label>
                        <select name="role" class="form-control" required>
                            <option value="penyewa">Penyewa</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group"><label>Alamat Lengkap</label><textarea name="address" class="form-control rows-textarea" placeholder="Tuliskan alamat domisili..."></textarea></div>
                    <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="toggleModal('modalTambah', false)">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="modal-backdrop">
        <div class="modal-box">
            <div class="modal-header">
                <span>Edit Data Pengguna</span>
                <button class="modal-close" onclick="toggleModal('modalEdit', false)">&times;</button>
            </div>
            <form id="formEditPengguna" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" id="edit_name" class="form-control" required></div>
                    <div class="form-group"><label>Email</label><input type="email" name="email" id="edit_email" class="form-control" required></div>
                    <div class="form-group"><label>No. Telepon</label><input type="text" name="phone" id="edit_phone" class="form-control"></div>
                    <div class="form-group">
                        <label>Peran (Role)</label>
                        <select name="role" id="edit_role" class="form-control" required>
                            <option value="penyewa">Penyewa</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group"><label>Alamat Lengkap</label><textarea name="address" id="edit_address" class="form-control rows-textarea"></textarea></div>
                    <div class="form-group"><label>Password Baru</label><input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="toggleModal('modalEdit', false)">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <form id="formDeletePengguna" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="nav-brand" style="color: white; margin-bottom: 15px;"><i class="fa-solid fa-building-columns"></i> Penyewaan Aula</div>
                <p>Politeknik Manufaktur Negeri Bangka Belitung - Sistem Pemesanan Aula Serbaguna.</p>
            </div>
        </div>
        <div class="footer-bottom">&copy; 2026 Sistem Penyewaan Aula POLMAN Babel. Semua hak cipta dilindungi.</div>
    </footer>

    <script>
        function toggleModal(modalId, isShow) {
            const modal = document.getElementById(modalId);
            if (isShow) {
                modal.classList.add('show');
            } else {
                modal.classList.remove('show');
            }
        }

        function openEditModal(id, name, email, phone, role, address) {
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_phone').value = (phone === 'null' || phone === null) ? '' : phone;
            document.getElementById('edit_role').value = role.toLowerCase();
            document.getElementById('edit_address').value = (address === 'null' || address === null) ? '' : address;

            document.getElementById('formEditPengguna').action = `/admin/pengguna/${id}`;
            toggleModal('modalEdit', true);
        }

        function confirmDelete(id, name) {
            if (confirm(`Apakah Anda yakin ingin menghapus pengguna "${name}"?`)) {
                const deleteForm = document.getElementById('formDeletePengguna');
                deleteForm.action = `/admin/pengguna/${id}`;
                deleteForm.submit();
            }
        }
    </script>
</body>
</html>