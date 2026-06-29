<?php

namespace App\Services;

use App\Models\SuratJafa;

class JafaService
{
    public function __construct(
        protected SuratNumberService $suratNumberService
    ) {}

    public function getByPegawai(int $pegawaiId)
    {
        return SuratJafa::where('pegawai_id', $pegawaiId)->latest()->get();
    }

    public function findById(int $id)
    {
        return SuratJafa::with('pegawai.user')->findOrFail($id);
    }

    public function create(array $data, int $pegawaiId): SuratJafa
    {
        $nomorSurat = $this->suratNumberService->generateJafa('UIM');

        return SuratJafa::create([
            'pegawai_id'                  => $pegawaiId,
            'nomor_surat'                 => $nomorSurat,
            'jabatan_fungsional_diajukan' => $data['jabatan_fungsional_diajukan'],
            'jabatan_fungsional_sekarang' => $data['jabatan_fungsional_sekarang'],
            'pangkat_golongan'            => $data['pangkat_golongan'],
            'tmt_pangkat'                 => $data['tmt_pangkat'],
            'daftar_karya'                => $data['daftar_karya'] ?? null,
            'status'                      => 'diajukan',
        ]);
    }

    public function getAll()
    {
        return SuratJafa::with('pegawai')->latest()->get();
    }

    public function verifikasi(int $id, string $status, string $catatan = null): void
    {
        SuratJafa::findOrFail($id)->update([
            'status'  => $status,
            'catatan' => $catatan,
        ]);
    }

    public function uploadScan(int $id, string $path): void
    {
        SuratJafa::findOrFail($id)->update(['file_scan' => $path]);
    }
}