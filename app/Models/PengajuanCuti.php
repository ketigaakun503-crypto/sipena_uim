<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanCuti extends Model
{
    protected $fillable = [
        'pegawai_id', 'jenis_cuti', 'tanggal_mulai', 'tanggal_selesai',
        'jumlah_hari', 'alasan', 'lampiran', 'status',
    ];

    protected $casts = [
        'tanggal_mulai'  => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function approvals()
    {
        return $this->hasMany(CutiApproval::class);
    }
}