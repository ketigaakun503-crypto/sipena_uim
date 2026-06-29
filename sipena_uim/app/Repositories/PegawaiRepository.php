<?php

namespace App\Repositories;

use App\Models\Pegawai;
use App\Repositories\Interfaces\PegawaiRepositoryInterface;

class PegawaiRepository implements PegawaiRepositoryInterface
{
    public function getAll()
    {
        return Pegawai::with(['user', 'jabatanAktif.unitKerja'])->orderBy('nama_lengkap')->get();
    }

    public function findById(int $id)
    {
        return Pegawai::with(['user', 'jabatanAktif.unitKerja', 'riwayatJabatan'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Pegawai::create($data);
    }

    public function update(int $id, array $data)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($data);
        return $pegawai;
    }

    public function delete(int $id)
    {
        return Pegawai::findOrFail($id)->delete();
    }
}