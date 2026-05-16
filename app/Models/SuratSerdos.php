<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratSerdos extends Model
{
    protected $fillable = [
        'pegawai_id', 'nomor_surat', 'program_studi', 'bidang_ilmu',
        'jumlah_sks', 'tahun_mulai_mengajar', 'mata_kuliah',
        'status', 'file_scan', 'catatan',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}