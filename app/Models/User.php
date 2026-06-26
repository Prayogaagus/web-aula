<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // PINDAHKAN INI KE DALAM CLASS
protected $fillable = [
    'name',
    'email',
    'password',
    'phone',    // Wajib ditambahkan
    'address',  
    'role',// Wajib ditambahkan
];

    // Gunakan cara standar untuk hidden agar lebih kompatibel
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function notifications()
        {
    return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
        }   
}