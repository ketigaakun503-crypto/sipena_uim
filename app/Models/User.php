<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Pegawai;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method bool hasRole(string $role)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class);
    }
    public function notifikasis()
{
    return $this->hasMany(Notifikasi::class)->latest();
}

public function notifikasiTidakDibaca()
{
    return $this->hasMany(Notifikasi::class)->where('dibaca', false);
}
}