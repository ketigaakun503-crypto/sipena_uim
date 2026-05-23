<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nip', 'nidn', 'nama_lengkap', 'jenis_kelamin',
        'tempat_lahir', 'tanggal_lahir', 'alamat', 'no_hp', 'email',
        'foto', 'status', 'jenis_pegawai', 'sisa_cuti',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jabatans()
    {
        return $this->belongsToMany(Jabatan::class, 'pegawai_jabatans')
                    ->withPivot('tanggal_mulai', 'tanggal_selesai', 'is_aktif', 'jenis')
                    ->withTimestamps();
    }

    public function jabatanAktif()
    {
        return $this->jabatans()->wherePivot('is_aktif', true);
    }

    public function riwayatJabatan()
    {
        return $this->hasMany(RiwayatJabatan::class);
    }
    public function kontrakKerjas()
{
    return $this->hasMany(KontrakKerja::class)->latest();
}

public function kontrakAktif()
{
    return $this->hasOne(KontrakKerja::class)->where('status', 'aktif')->latest();
}

public function suratKeputusans()
{
    return $this->hasMany(SuratKeputusan::class)->latest();
}
}