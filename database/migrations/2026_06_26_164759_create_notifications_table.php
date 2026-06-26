<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // Menghubungkan notifikasi ke id di tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('judul'); // Contoh: "Pesanan Berhasil", "Pembayaran Berhasil"
            $table->text('pesan');  // Isi pesan detail notifikasi
            $table->string('tipe');   // Untuk menentukan icon & warna (success, info, warning, danger, dll)
            $table->enum('kategori', ['Pesanan', 'Pembaruan']); // Untuk filter tab menu
            $table->boolean('is_read')->default(false); // Status baca
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};