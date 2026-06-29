<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutiApproval extends Model
{
    protected $fillable = [
        'pengajuan_cuti_id', 'approver_id', 'jabatan_id',
        'status', 'catatan', 'diproses_pada',
    ];

    public function pengajuanCuti()
    {
        return $this->belongsTo(PengajuanCuti::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}