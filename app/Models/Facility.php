<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    // Tambahkan baris ini
    protected $fillable = [
        'nama_fasilitas', 
        'kategori', 
        'jumlah',
        'status' // Sesuaikan dengan kolom yang ada di database Anda
    ];

    public function pemesanan()
    {
        return $this->belongsToMany(Pemesanan::class, 'pemesanan_fasilitas', 'facility_id', 'pemesanan_id')
                    ->withPivot('jumlah_digunakan')
                    ->withTimestamps();
    }
}