<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeputusan extends Model
{
    protected $fillable = [
        'pegawai_id', 'nomor_sk', 'jenis_sk', 'jabatan_yang_ditetapkan',
        'tanggal_sk', 'tmt', 'pertimbangan', 'keterangan', 'status', 'file_sk',
    ];

    protected $casts = [
        'tanggal_sk' => 'date',
        'tmt'        => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function getJenisSkLabelAttribute(): string
    {
        return match($this->jenis_sk) {
            'pengangkatan'      => 'SK Pengangkatan',
            'jabatan_fungsional' => 'SK Jabatan Fungsional',
            'jabatan_struktural' => 'SK Jabatan Struktural',
            default             => $this->jenis_sk,
        };
    }
}