<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    // Daftarkan kolom total dan status agar bisa disimpan (Mass Assignment)
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
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}