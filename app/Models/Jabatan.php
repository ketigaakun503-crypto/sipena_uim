<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = ['nama', 'jenis', 'unit_kerja_id', 'level'];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function pegawais()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_jabatans')
                    ->withPivot('tanggal_mulai', 'tanggal_selesai', 'is_aktif', 'jenis')
                    ->withTimestamps();
    }
}