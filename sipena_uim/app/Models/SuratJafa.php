<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJafa extends Model
{
    protected $fillable = [
        'pegawai_id', 'nomor_surat', 'jabatan_fungsional_diajukan',
        'jabatan_fungsional_sekarang', 'pangkat_golongan', 'tmt_pangkat',
        'daftar_karya', 'status', 'file_scan', 'catatan',
    ];

    protected $casts = [
        'tmt_pangkat' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}