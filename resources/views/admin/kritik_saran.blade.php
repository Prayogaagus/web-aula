<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kritik dan Saran - POLMAN Babel</title>
    <link rel="stylesheet" href="{{ asset('css/kritik.css') }}">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">
        <img src="{{ asset('images/Logo_Polman.png') }}" class="nav-logo" alt="Logo">
        <div>
            <div class="brand-title">Penyewaan Aula</div>
            <div class="brand-subtitle">POLMAN Babel</div>
        </div>
    </div>

    <div class="nav-menu">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
        <a href="{{ route('admin.pengguna') }}" class="nav-link">Pengguna</a>
        <a href="{{ route('admin.pemesanan') }}" class="nav-link">Pemesanan</a>
        <a href="{{ route('admin.fasilitas') }}" class="nav-link">Fasilitas</a>
        <a href="{{ route('admin.kritik-saran') }}" class="nav-link active">Kritik & Saran</a>
        <a href="{{ route('admin.laporan.index') }}" class="nav-link">Laporan</a>
    </div>

    <div class="nav-profile">
        <div class="profile-avatar">AU</div>
        <span class="profile-name">Admin Utama</span>
    </div>
</nav>

<section class="hero-section" style="--bg-url: url('{{ asset('images/aula_polman.jpeg') }}');">
    <h1 class="hero-title">Kelola Kritik dan Saran</h1>
    <p class="hero-subtitle">Verifikasi pembayaran dan konfirmasi pemesanan.</p>
</section>

<main class="main-container">

    <div class="stats-grid">
        <div class="card-stat">
            <div>
                <p class="stat-label">Total Masukan</p>
                <h3 class="stat-value">{{ $stats['total'] }}</h3>
            </div>
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </div>
        </div>
        <div class="card-stat">
            <div>
                <p class="stat-label">Kritik</p>
                <h3 class="stat-value">{{ $stats['kritik'] }}</h3>
            </div>
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.232.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
        <div class="card-stat">
            <div>
                <p class="stat-label">Saran</p>
                <h3 class="stat-value">{{ $stats['saran'] }}</h3>
            </div>
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
            </div>
        </div>
        <div class="card-stat">
            <div>
                <p class="stat-label">Ditindaklanjuti</p>
                <h3 class="stat-value">{{ $stats['ditindaklanjuti'] }}</h3>
            </div>
            <div class="stat-icon success">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="tab-navigation">
        <a href="?tab=semua" class="tab-link {{ $tab == 'semua' ? 'active' : '' }}">Semua Masukan</a>
        <a href="?tab=kritik" class="tab-link {{ $tab == 'kritik' ? 'active' : '' }}">Kritik</a>
        <a href="?tab=saran" class="tab-link {{ $tab == 'saran' ? 'active' : '' }}">Saran</a>
        <a href="?tab=ditindaklanjuti" class="tab-link {{ $tab == 'ditindaklanjuti' ? 'active' : '' }}">Ditindaklanjuti</a>
        <a href="?tab=belum_ditindaklanjuti" class="tab-link {{ $tab == 'belum_ditindaklanjuti' ? 'active' : '' }}">Belum Ditindaklanjuti</a>
    </div>

    <form action="{{ route('admin.kritik-saran') }}" method="GET" id="sortForm">
    <input type="hidden" name="tab" value="{{ request('tab', 'semua') }}">
    <input type="hidden" name="search" value="{{ request('search') }}">

    <select name="sort" onchange="this.form.submit()" class="sort-select">
        <option value="terbaru" {{ request('sort') == 'terbaru' || !request()->has('sort') ? 'selected' : '' }}>
            Terbaru
        </option>
        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>
            Terlama
        </option>
    </select>
    </form>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="text-center w-12">No</th>
                    <th class="w-52">Pengguna</th>
                    <th class="text-center w-24">Jenis</th>
                    <th>Pesan</th>
                    <th class="w-44">Tanggal</th>
                    <th class="text-center w-48">Status</th>
                    <th class="text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($masukan as $index => $item)
                <tr>
                    <td class="text-center" style="font-weight: 600; color: #9ca3af;">
                        {{ $masukan->firstItem() + $index }}
                    </td>
                    <td>
                        <div class="user-name">{{ $item->user->name }}</div>
                        <div class="user-email">{{ $item->user->email }}</div>
                    </td>
                    <td class="text-center">
                        <span class="{{ $item->jenis == 'Kritik' ? 'type-kritik' : 'type-saran' }}">
                            {{ $item->jenis }}
                        </span>
                    </td>
                    <td>
                        <div class="message-cell">{{ $item->pesan }}</div>
                    </td>
                    <td>
                        <div class="date-primary">{{ $item->created_at->isoFormat('D MMMM YYYY') }}</div>
                        <div class="date-secondary">{{ $item->created_at->format('H.i') }} WIB</div>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $item->status == 'Ditindaklanjuti' ? 'badge-success' : 'badge-warning' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        <div class="action-group">
                            <button onclick="openDetailModal('{{ addslashes($item->user->name) }}', '{{ $item->jenis }}', '{{ addslashes($item->pesan) }}')" class="btn-action btn-view" title="Lihat detail">
                             <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            
                            <form action="{{ route('admin.kritik-saran.status', $item->id) }}" method="POST" style="display: inline;">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="{{ $item->status == 'Belum Ditindaklanjuti' ? 'Ditindaklanjuti' : 'Belum Ditindaklanjuti' }}">
                                <button type="submit" title="Ubah status penanganan" class="btn-action btn-edit">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                            </form>

                            <form action="{{ route('admin.kritik-saran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus masukan ini?')" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus masukan" class="btn-action btn-delete">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="no-data">Tidak ada kritik atau saran yang ditemukan pada kategori ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-row">
        <p class="pagination-info">
            Menampilkan {{ $masukan->firstItem() ?? 0 }} - {{ $masukan->lastItem() ?? 0 }} dari {{ $masukan->total() }} data
        </p>
        <div class="pagination-buttons">
            @if ($masukan->onFirstPage())
                <span class="page-btn disabled">&lt;</span>
            @else
                <a href="{{ $masukan->previousPageUrl() }}" class="page-btn">&lt;</a>
            @endif

            @foreach ($masukan->getUrlRange(1, $masukan->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="page-btn {{ $page == $masukan->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach

            @if ($masukan->hasMorePages())
                <a href="{{ $masukan->nextPageUrl() }}" class="page-btn">&gt;</a>
            @else
                <span class="page-btn disabled">&gt;</span>
            @endif
        </div>
    </div>
</main>

<div id="modal-detail" class="modal-backdrop hidden">
    <div class="modal-box">
        <div class="modal-header">
            <h3 class="modal-title">Isi Detail Masukan</h3>
            <button onclick="closeDetailModal()" class="modal-close-btn">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="modal-body">
            <div>
                <span class="modal-label">Pengirim</span>
                <p id="modal-pengirim" class="modal-text"></p>
            </div>
            <div>
                <span class="modal-label">Jenis Masukan</span>
                <p id="modal-jenis" class="modal-text"></p>
            </div>
            <div>
                <span class="modal-label">Isi Pesan</span>
                <div class="modal-desc-box" id="modal-pesan"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeDetailModal()" class="btn-close-modal">Tutup Detail</button>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer-grid">
        <div>
            <div class="footer-brand">
                <img src="{{ asset('images/Logo_Polman.png') }}" class="footer-logo" alt="Logo">
                <span class="footer-brand-name">Penyewaan Aula</span>
            </div>
            <p class="footer-text">Politeknik Manufaktur Negeri Bangka Belitung - Sistem Pemesanan Aula Serbaguna.</p>
        </div>
        <div>
            <h4 class="footer-heading">Tautan</h4>
            <ul class="footer-links">
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Detail Aula</a></li>
                <li><a href="#">Jadwal</a></li>
                <li><a href="#">Kritik & Saran</a></li>
            </ul>
        </div>
        <div>
            <h4 class="footer-heading">Layanan</h4>
            <ul class="footer-links">
                <li><a href="#">Sewa Aula</a></li>
                <li><a href="#">Cek Ketersediaan</a></li>
                <li><a href="#">Panduan Pemesanan</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>
        <div>
            <h4 class="footer-heading">Hubungi Kami</h4>
            <div class="footer-text" style="color: #9ca3af;">
                <p style="margin: 0 0 0.5rem 0;">Jl. Timah Raya, Kawasan Industri Airkantung, Sungailiat, Bangka 33211</p>
                <p style="margin: 0 0 0.5rem 0;">+62-717-31341</p>
                <p style="margin: 0;">info@polman-babel.ac.id</p>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        &copy; 2026 Sistem Penyewaan Aula POLMAN Babel. Semua hak cipta dilindungi.
    </div>
</footer>

<script>
    function openDetailModal(pengirim, jenis, pesan) {
        document.getElementById('modal-pengirim').innerText = pengirim;
        document.getElementById('modal-jenis').innerText = jenis;
        document.getElementById('modal-pesan').innerText = pesan;
        document.getElementById('modal-detail').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('modal-detail').classList.add('hidden');
    }
</script>
</body>
</html>