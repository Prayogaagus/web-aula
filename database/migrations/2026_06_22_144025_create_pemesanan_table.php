<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            
            // Kolom Penting untuk Identifikasi
            $table->string('kode_pemesanan')->unique(); // Tambahkan unique agar tidak ada kode ganda
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('paket'); // Ditambahkan untuk menyimpan pilihan paket
            
            // Informasi Penyewa
            $table->string('nama');
            $table->string('instansi')->nullable();
            $table->string('telp');
            
            // Detail Acara
            $table->date('tanggal')->index(); // Index ditambahkan untuk mempercepat pencarian jadwal
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('jenis_acara');
            $table->unsignedInteger('jumlah_peserta'); // unsigned agar tidak bisa negatif
            
            // Fasilitas & Tambahan
            $table->text('fasilitas')->nullable();
            $table->text('catatan')->nullable();
            
            // Keuangan & Status
            $table->decimal('total', 15, 2)->default(0);
            $table->enum('status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Selesai', 'Dibatalkan'])
                  ->default('Menunggu Konfirmasi');
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};