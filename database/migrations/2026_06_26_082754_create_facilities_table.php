<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('nama_fasilitas');
            $blueprint->string('kategori'); // Peralatan Presentasi, Audio, Perabot, dll.
            $blueprint->integer('jumlah')->default(0);
            $blueprint->enum('status', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};