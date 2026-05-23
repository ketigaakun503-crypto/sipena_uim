<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class KontrakKerja extends Model
{
    protected $fillable = [
        'pegawai_id', 'nomor_kontrak', 'jenis_kontrak',
        'tanggal_mulai', 'tanggal_selesai', 'keterangan',
        'status', 'notif_terkirim',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'notif_terkirim'  => 'boolean',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function getSisaHariAttribute(): ?int
    {
        if (!$this->tanggal_selesai) return null;
        return max(0, now()->diffInDays($this->tanggal_selesai, false));
    }

    public function getIsAkanBerakhirAttribute(): bool
    {
        if (!$this->tanggal_selesai) return false;
        return $this->sisa_hari <= 30 && $this->sisa_hari >= 0 && $this->status === 'aktif';
    }
}