<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Added 'url' to fillable so you can save the link
    protected $fillable = [
        'user_id', 
        'judul', 
        'pesan', 
        'tipe', 
        'kategori', 
        'is_read', 
        'url'
    ];

    // Good practice: cast is_read to a boolean
    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}