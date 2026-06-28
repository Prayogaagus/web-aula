<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('pemesanan_id')->constrained('pemesanan')->onDelete('cascade');
            $blueprint->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            $blueprint->integer('jumlah_digunakan')->default(1);
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan_fasilitas');
    }
};