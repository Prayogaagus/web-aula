<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pemesanan;
use App\Models\Facility;
use App\Models\KritikSaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================================================
        // 1. SEED DATA USER & ADMIN (Tabel: users)
        // ==========================================================================
        
        // Akun Admin Utama
        User::updateOrCreate(
            ['email' => 'admin@polman-babel.ac.id'],
            [
                'name' => 'Admin Utama',
                'phone' => '081111111111',
                'address' => 'Kampus POLMAN Babel',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Akun Penyewa Mockup 1: Danis Ahmad
        $userDanis = User::updateOrCreate(
            ['email' => 'Danis55@gmail.com'],
            [
                'name' => 'Danis Ahmad',
                'phone' => '08123456788',
                'address' => 'Jl. Pangkalpinang No. 12',
                'password' => Hash::make('password123'),
                'role' => 'penyewa',
            ]
        );

        // Akun Penyewa Mockup 2: Gibran Raka
        $userGibran = User::updateOrCreate(
            ['email' => 'Gibran02@gmail.com'],
            [
                'name' => 'Gibran Raka',
                'phone' => '08234567891',
                'address' => 'Sungkailiat, Bangka',
                'password' => Hash::make('password123'),
                'role' => 'penyewa',
            ]
        );


        // ==========================================================================
        // 2. SEED DATA FASILITAS + KOLOM HARGA BARU (Tabel: facilities)
        // ==========================================================================
        
        Facility::updateOrCreate(
            ['nama_fasilitas' => 'Sound System Standard'],
            [
                'kategori' => 'Peralatan Audio',
                'jumlah' => 2,
                'harga' => 500000, // Rp 500.000 / unit
                'status' => 'Tersedia'
            ]
        );

        Facility::updateOrCreate(
            ['nama_fasilitas' => 'Proyektor HD 4K'],
            [
                'kategori' => 'Peralatan Presentasi',
                'jumlah' => 3,
                'harga' => 300000, // Rp 300.000 / unit
                'status' => 'Tersedia'
            ]
        );

        Facility::updateOrCreate(
            ['nama_fasilitas' => 'Kursi Futura'],
            [
                'kategori' => 'Perabot',
                'jumlah' => 500,
                'harga' => 5000, // Rp 5.000 / unit
                'status' => 'Tersedia'
            ]
        );

        Facility::updateOrCreate(
            ['nama_fasilitas' => 'AC Portable 2 PK'],
            [
                'kategori' => 'Peralatan Pendukung',
                'jumlah' => 6,
                'harga' => 250000, // Rp 250.000 / unit
                'status' => 'Tersedia'
            ]
        );

        Facility::updateOrCreate(
            ['nama_fasilitas' => 'Mikrofon Wireless (Shure)'],
            [
                'kategori' => 'Peralatan Audio',
                'jumlah' => 4,
                'harga' => 100000, // Rp 100.000 / unit
                'status' => 'Tersedia'
            ]
        );


        // ==========================================================================
        // 3. SEED DATA PEMESANAN (Tabel: pemesanan)
        // ==========================================================================
        
        // Transaksi 1: Danis Ahmad (Selesai)
        // Perhitungan: Paket Resepsi (8.950.000) + Sound (1x500.000) + Kursi (400x5.000 = 2.000.000) = 11.450.000
        Pemesanan::updateOrCreate(
            ['kode_pemesanan' => 'AULA202605001'],
            [
                'user_id'        => $userDanis->id, 
                'tanggal'        => '2026-05-05',
                'paket'          => 'Paket Resepsi',
                'nama'           => 'Danis Ahmad',
                'instansi'       => 'Pribadi',
                'telp'           => '08123456788',
                'jam_mulai'      => '08:00:00',
                'jam_selesai'    => '17:00:00',
                'jenis_acara'    => 'Acara Pernikahan',
                'jumlah_peserta' => 500,
                'fasilitas'      => 'Sound System Standard (1), Kursi Futura (400)',
                'catatan'        => 'Harap siapkan kebersihan gedung H-1.',
                'total'          => 11450000, 
                'status'         => 'Selesai',
            ]
        );

        // Transaksi 2: Gibran Raka (Dikonfirmasi)
        // Perhitungan: Paket Pendidikan (4.500.000) + Proyektor (1x300.000) + Sound (1x500.000) = 5.300.000
        Pemesanan::updateOrCreate(
            ['kode_pemesanan' => 'AULA202605002'],
            [
                'user_id'        => $userGibran->id, 
                'tanggal'        => '2026-05-20',
                'paket'          => 'Paket Instansi Pendidikan',
                'nama'           => 'Gibran Raka',
                'instansi'       => 'Himpunan Mahasiswa',
                'telp'           => '08234567891',
                'jam_mulai'      => '09:00:00',
                'jam_selesai'    => '12:00:00',
                'jenis_acara'    => 'Seminar Nasional',
                'jumlah_peserta' => 200,
                'fasilitas'      => 'Proyektor HD 4K (1), Sound System Standard (1)',
                'catatan'        => 'Memerlukan gladi bersih pada jam 07:00 pagi.',
                'total'          => 5300000, 
                'status'         => 'Dikonfirmasi',
            ]
        );

        // Transaksi Tambahan 3: Mengisi Grafik Juni (Dikonfirmasi)
        // Perhitungan: Paket Pendidikan (4.500.000) + AC (4x250.000 = 1.000.000) + Proyektor (1x300.000) = 5.800.000
        Pemesanan::updateOrCreate(
            ['kode_pemesanan' => 'AULA202606001'],
            [
                'user_id'        => $userDanis->id, 
                'tanggal'        => '2026-06-10',
                'paket'          => 'Paket Instansi Pendidikan',
                'nama'           => 'Danis Ahmad',
                'instansi'       => 'PT Maju Mundur',
                'telp'           => '08123456788',
                'jam_mulai'      => '08:00:00',
                'jam_selesai'    => '15:00:00',
                'jenis_acara'    => 'Corporate Gathering',
                'jumlah_peserta' => 150,
                'fasilitas'      => 'AC Portable 2 PK (4), Proyektor HD 4K (1)',
                'catatan'        => 'Layout kursi berformat teater.',
                'total'          => 5800000, 
                'status'         => 'Dikonfirmasi',
            ]
        );

        // Transaksi Tambahan 4: Mengisi Grafik Juni (Menunggu Konfirmasi)
        // Perhitungan: Paket Resepsi (8.950.000) + Sound (1x500.000) = 9.450.000
        Pemesanan::updateOrCreate(
            ['kode_pemesanan' => 'AULA202606002'],
            [
                'user_id'        => $userGibran->id, 
                'tanggal'        => '2026-06-25',
                'paket'          => 'Paket Resepsi',
                'nama'           => 'Gibran Raka',
                'instansi'       => 'Pribadi',
                'telp'           => '08234567891',
                'jam_mulai'      => '13:00:00',
                'jam_selesai'    => '21:00:00',
                'jenis_acara'    => 'Acara Ulang Tahun',
                'jumlah_peserta' => 100,
                'fasilitas'      => 'Sound System Standard (1)',
                'catatan'        => 'Akan membawa katering luar.',
                'total'          => 9450000, 
                'status'         => 'Menunggu Konfirmasi',
            ]
        );


        // ==========================================================================
        // 4. SEED DATA KRITIK & SARAN (Tabel: kritik_sarans)
        // ==========================================================================
        
        KritikSaran::updateOrCreate(
            ['pesan' => 'AC Portable di bagian pojok kanan belakang aula kurang terasa dingin ketika kapasitas ruangan sedang terisi penuh.'],
            [
                'user_id' => $userDanis->id,
                'jenis'   => 'Kritik',
                'rating'  => 3, 
                'status'  => 'Belum Ditindaklanjuti',
            ]
        );

        KritikSaran::updateOrCreate(
            ['pesan' => 'Mohon dipertimbangkan untuk menambahkan metode pembayaran otomatis via E-Wallet QRIS langsung di website agar konfirmasi instan.'],
            [
                'user_id' => $userGibran->id,
                'jenis'   => 'Saran',
                'rating'  => 5, 
                'status'  => 'Belum Ditindaklanjuti',
            ]
        );

        KritikSaran::updateOrCreate(
            ['pesan' => 'Mikrofon wireless yang disediakan sempat mengalami gangguan distorsi suara sekitar 5 menit di pertengahan acara seminar.'],
            [
                'user_id' => $userDanis->id,
                'jenis'   => 'Kritik',
                'rating'  => 4, 
                'status'  => 'Ditindaklanjuti',
            ]
        );
    }
}