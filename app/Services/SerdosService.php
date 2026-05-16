<?php

namespace App\Services;

use App\Models\SuratSerdos;

class SerdosService
{
    public function __construct(
        protected SuratNumberService $suratNumberService
    ) {}

    public function getByPegawai(int $pegawaiId)
    {
        return SuratSerdos::where('pegawai_id', $pegawaiId)->latest()->get();
    }

    public function findById(int $id)
    {
        return SuratSerdos::with('pegawai.user')->findOrFail($id);
    }

    public function create(array $data, int $pegawaiId): SuratSerdos
    {
        $nomorSurat = $this->suratNumberService->generateSerdos('UIM');

        return SuratSerdos::create([
            'pegawai_id'           => $pegawaiId,
            'nomor_surat'          => $nomorSurat,
            'program_studi'        => $data['program_studi'],
            'bidang_ilmu'          => $data['bidang_ilmu'],
            'jumlah_sks'           => $data['jumlah_sks'],
            'tahun_mulai_mengajar' => $data['tahun_mulai_mengajar'],
            'mata_kuliah'          => $data['mata_kuliah'] ?? null,
            'status'               => 'diajukan',
        ]);
    }

    public function getAll()
    {
        return SuratSerdos::with('pegawai')->latest()->get();
    }

    public function verifikasi(int $id, string $status, string $catatan = null): void
    {
        SuratSerdos::findOrFail($id)->update([
            'status'  => $status,
            'catatan' => $catatan,
        ]);
    }

    public function uploadScan(int $id, string $path): void
    {
        SuratSerdos::findOrFail($id)->update(['file_scan' => $path]);
    }
}