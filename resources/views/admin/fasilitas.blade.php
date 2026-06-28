<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Fasilitas - Penyewaan Aula POLMAN Babel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-fasilitas.css') }}?v={{ time() }}">
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
        <a href="{{ route('admin.pemesanan') }}">Pemesanan</a>
        <a href="{{ route('admin.fasilitas') }}" class="active">Fasilitas</a>
        <a href="{{ route('admin.kritik-saran') }}">Kritik & Saran</a>
        <a href="{{ route('admin.laporan.index') }}">Laporan</a>
    </div>

    <div class="user-profile">
        <div class="avatar">AU</div>
        <span>Admin Utama</span>
    </div>
</nav>

<section class="hero-section"
style="background-image: linear-gradient(rgba(11,58,122,0.85), rgba(11,58,122,0.85)), url('{{ asset('images/aula_polman.jpeg') }}');">
    <h1>Kelola Fasilitas</h1>
    <p>Kelola seluruh fasilitas aula dan pantau ketersediaannya.</p>
</section>

<main class="main-container">
<div class="min-h-screen bg-gray-50 pb-10">

    <div class="max-w-6xl mx-auto px-4 mt-6">
        @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center shadow-sm mb-6">
            <div class="bg-green-500 p-1.5 rounded-full text-white mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-sm">Berhasil!</h4>
                <p class="text-xs text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="bg-white p-4 rounded-xl shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            <form action="{{ route('admin.fasilitas') }}" method="GET" class="w-full flex flex-col md:flex-row gap-3 items-center">
                <div class="relative w-full md:w-80">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama fasilitas..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                
                <select name="kategori" onchange="this.form.submit()" class="w-full md:w-48 px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    <option value="Peralatan Presentasi" {{ request('kategori') == 'Peralatan Presentasi' ? 'selected' : '' }}>Peralatan Presentasi</option>
                    <option value="Peralatan Audio" {{ request('kategori') == 'Peralatan Audio' ? 'selected' : '' }}>Peralatan Audio</option>
                    <option value="Peralatan Pendukung" {{ request('kategori') == 'Peralatan Pendukung' ? 'selected' : '' }}>Peralatan Pendukung</option>
                    <option value="Perabot" {{ request('kategori') == 'Perabot' ? 'selected' : '' }}>Perabot</option>
                </select>
            </form>

            <button onclick="toggleModal('modal-tambah')" class="w-full md:w-auto bg-blue-950 hover:bg-blue-900 text-white font-medium text-sm px-4 py-2.5 rounded-lg flex items-center justify-center gap-2 transition shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Tambah Fasilitas
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 text-gray-700 text-xs font-semibold uppercase tracking-wider">
                        <th class="px-6 py-3.5 text-center w-16">No</th>
                        <th class="px-6 py-3.5">Nama Fasilitas</th>
                        <th class="px-6 py-3.5">Kategori</th>
                        <th class="px-6 py-3.5">Harga Sewa</th> <th class="px-6 py-3.5">Jumlah</th>
                        <th class="px-6 py-3.5">Kondisi</th>
                        <th class="px-6 py-3.5 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm text-gray-600">
                    @forelse($facilities as $index => $facility)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-6 py-4 text-center font-medium text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $facility->nama_fasilitas }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $facility->kategori }}</td>
                        
                        <td class="px-6 py-4 font-medium text-gray-950">
                            Rp {{ number_format($facility->harga, 0, ',', '.') }}
                        </td>
                        
                        <td class="px-6 py-4">{{ $facility->jumlah }} Unit</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $facility->status == 'Tersedia' ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }}">
                                {{ $facility->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center flex justify-center items-center gap-2">
                            <button onclick="openEditModal('{{ $facility->id }}', '{{ addslashes($facility->nama_fasilitas) }}', '{{ $facility->kategori }}', '{{ $facility->jumlah }}', '{{ $facility->harga }}', '{{ $facility->status }}')" class="text-amber-500 hover:bg-amber-50 p-1.5 rounded-lg border border-gray-200 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            
                            <form action="{{ route('admin.fasilitas.destroy', $facility->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg border border-gray-200 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-400">Belum ada data fasilitas yang tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-tambah" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Tambah Fasilitas Baru</h3>
        <form action="{{ route('admin.fasilitas.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Fasilitas</label>
                    <input type="text" name="nama_fasilitas" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Kategori</label>
                    <select name="kategori" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option>Peralatan Presentasi</option>
                        <option>Peralatan Audio</option>
                        <option>Peralatan Pendukung</option>
                        <option>Perabot</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Harga Sewa Satuan (Rp)</label>
                    <input type="number" name="harga" min="0" required placeholder="Contoh: 50000" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jumlah Unit</label>
                    <input type="number" name="jumlah" min="0" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="toggleModal('modal-tambah')" class="px-4 py-2 text-sm text-gray-500 hover:bg-gray-100 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm bg-blue-950 text-white rounded-lg hover:bg-blue-900">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Data Fasilitas</h3>
        <form id="form-edit" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Fasilitas</label>
                    <input type="text" id="edit-nama" name="nama_fasilitas" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Kategori</label>
                    <select id="edit-kategori" name="kategori" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="Peralatan Presentasi">Peralatan Presentasi</option>
                        <option value="Peralatan Audio">Peralatan Audio</option>
                        <option value="Peralatan Pendukung">Peralatan Pendukung</option>
                        <option value="Perabot">Perabot</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Harga Sewa Satuan (Rp)</label>
                    <input type="number" id="edit-harga" name="harga" min="0" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jumlah Unit</label>
                    <input type="number" id="edit-jumlah" name="jumlah" min="0" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Kondisi / Status</label>
                    <select id="edit-status" name="status" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Tidak Tersedia">Tidak Tersedia</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="toggleModal('modal-edit')" class="px-4 py-2 text-sm text-gray-500 hover:bg-gray-100 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm bg-blue-950 text-white rounded-lg hover:bg-blue-900">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
    }

    // UPDATE JAVASCRIPT AGAR BISA MEMBACA & MEMETAKAN VARIABEL HARGA BARU
    function openEditModal(id, nama, kategori, jumlah, harga, status) {
        const form = document.getElementById('form-edit');
        form.action = `/admin/fasilitas/${id}`;

        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-kategori').value = kategori;
        document.getElementById('edit-jumlah').value = jumlah;
        document.getElementById('edit-harga').value = harga;
        document.getElementById('edit-status').value = status;

        toggleModal('modal-edit');
    }
</script>
</main>

<footer class="footer">
    <div class="footer-bottom">
        &copy; 2026 Sistem Penyewaan Aula POLMAN Babel. Semua hak cipta dilindungi.
    </div>
</footer>

</body>
</html>