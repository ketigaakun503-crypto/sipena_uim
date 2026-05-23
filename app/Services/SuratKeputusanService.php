<?php

namespace App\Services;

use App\Models\SuratKeputusan;

class SuratKeputusanService
{
    public function getAll()
    {
        return SuratKeputusan::with('pegawai')->latest()->get();
    }

    public function getByPegawai(int $pegawaiId)
    {
        return SuratKeputusan::where('pegawai_id', $pegawaiId)->latest()->get();
    }

    public function findById(int $id)
    {
        return SuratKeputusan::with('pegawai')->findOrFail($id);
    }

    public function create(array $data): SuratKeputusan
    {
        // Generate nomor SK otomatis
        $data['nomor_sk'] = $this->generateNomorSK($data['jenis_sk']);
        return SuratKeputusan::create($data);
    }

    public function update(int $id, array $data): void
    {
        SuratKeputusan::findOrFail($id)->update($data);
    }

    public function delete(int $id): void
    {
        SuratKeputusan::findOrFail($id)->delete();
    }

    public function terbitkan(int $id): void
    {
        SuratKeputusan::findOrFail($id)->update(['status' => 'diterbitkan']);
    }

    private function generateNomorSK(string $jenisSk): string
    {
        $kode = match($jenisSk) {
            'pengangkatan'       => 'SK-ANGKAT',
            'jabatan_fungsional' => 'SK-JABFUNG',
            'jabatan_struktural' => 'SK-JABSTRUK',
            default              => 'SK',
        };

        $bulanRomawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        $bulan  = $bulanRomawi[now()->month - 1];
        $tahun  = now()->year;
        $urutan = SuratKeputusan::whereYear('created_at', $tahun)
                    ->where('jenis_sk', $jenisSk)
                    ->count() + 1;
        $nomor  = str_pad($urutan, 3, '0', STR_PAD_LEFT);

        return "{$nomor}/UIM/{$kode}/{$bulan}/{$tahun}";
    }

    public function uploadFileSK(int $id, string $path): void
    {
        SuratKeputusan::findOrFail($id)->update(['file_sk' => $path]);
    }
}