<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanLembur extends Model
{
    protected $fillable = [
        'pegawai_id', 'tanggal_lembur', 'jam_mulai', 'jam_selesai',
        'jumlah_jam', 'alasan', 'status', 'catatan_approver',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function approvals()
    {
        return $this->hasMany(LemburApproval::class);
    }
}