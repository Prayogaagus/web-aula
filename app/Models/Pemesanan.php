<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    // Daftarkan kolom agar bisa disimpan (Mass Assignment)
    protected $fillable = [
        'user_id',
        'paket',
        'kode_pemesanan',
        'nama',
        'instansi',
        'telp',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'jenis_acara',
        'jumlah_peserta',
        'fasilitas',
        'catatan',
        'total',
        'status'
    ];

    protected static function booted()
    {
        static::created(function ($pemesanan) {
            // Tempat logis jika ingin memicu event otomatis saat data baru masuk
        });
    }

    /**
     * Hubungan Many-to-Many ke Model Facility via tabel pivot pemesanan_fasilitas
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'fasilitas', 'pemesanan_id', 'facility_id')
                    ->withPivot('jumlah_digunakan') // Mengizinkan sistem membaca kolom kuantitas unit
                    ->withTimestamps();
    }

    /**
     * Hubungan BelongsTo ke data User (Penyewa)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}