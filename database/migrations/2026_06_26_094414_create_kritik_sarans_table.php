<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kritik_sarans', function (Blueprint $table) {
            $table->id();
            
            // Menghubungkan ke tabel users (karena nama & email diambil otomatis dari data login)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kolom opsional pelengkap sesuai form di Blade
            $table->string('instansi')->nullable();
            $table->string('no_telepon')->nullable();
            
            // Diubah menjadi string/diperluas enum-nya agar pilihan Apresiasi & Lainnya di form tidak error
            $table->enum('jenis', ['Kritik', 'Saran']);
            
            $table->text('pesan');
            
            // Menambahkan kolom rating integer (1 sampai 5) untuk menampung bintang
            $table->integer('rating');
            
            // Status tindak lanjut untuk manajemen admin
            $table->enum('status', ['Ditindaklanjuti', 'Belum Ditindaklanjuti'])->default('Belum Ditindaklanjuti');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kritik_sarans');
    }
};