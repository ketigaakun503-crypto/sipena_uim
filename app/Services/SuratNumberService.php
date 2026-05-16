<?php

namespace App\Services;

use App\Models\SuratJafa;
use App\Models\SuratSerdos;

class SuratNumberService
{
    private array $bulanRomawi = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
        5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
        9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
    ];

    public function generateJafa(string $kodeUnit): string
    {
        $bulan  = $this->bulanRomawi[now()->month];
        $tahun  = now()->year;
        $urutan = SuratJafa::whereYear('created_at', $tahun)->count() + 1;
        $nomor  = str_pad($urutan, 3, '0', STR_PAD_LEFT);

        return "{$nomor}/UIM/JAFA/{$bulan}/{$tahun}";
    }

    public function generateSerdos(string $kodeUnit): string
    {
        $bulan  = $this->bulanRomawi[now()->month];
        $tahun  = now()->year;
        $urutan = SuratSerdos::whereYear('created_at', $tahun)->count() + 1;
        $nomor  = str_pad($urutan, 3, '0', STR_PAD_LEFT);

        return "{$nomor}/UIM/SERDOS/{$bulan}/{$tahun}";
    }
}