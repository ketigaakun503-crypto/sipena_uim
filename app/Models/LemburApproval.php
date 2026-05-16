<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LemburApproval extends Model
{
    protected $fillable = [
        'pengajuan_lembur_id', 'approver_id',
        'status', 'catatan', 'diproses_pada',
    ];

    public function pengajuanLembur()
    {
        return $this->belongsTo(PengajuanLembur::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}