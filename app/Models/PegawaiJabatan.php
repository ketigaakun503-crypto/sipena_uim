<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiJabatan extends Model
{
    protected $fillable = [
        'pegawai_id', 'jabatan_id', 'tanggal_mulai',
        'tanggal_selesai', 'is_aktif', 'jenis',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}