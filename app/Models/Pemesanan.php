<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    // Tambahkan baris ini jika belum ada, masukkan semua field yang di-insert
    protected $fillable = [
        'user_id',
        'nama',
        'instansi',
        'telp',
        'email',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'jenis_acara',
        'jumlah_peserta',
        'fasilitas',
        'catatan'
    ];
}