<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KritikSaran extends Model
{
    use HasFactory;

    protected $table = 'kritik_sarans';
    protected $fillable = [
        'user_id',
        'instansi',
        'no_telepon',
        'jenis',      
        'pesan',
        'rating',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}