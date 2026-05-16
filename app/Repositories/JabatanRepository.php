<?php

namespace App\Repositories;

use App\Models\Jabatan;
use App\Repositories\Interfaces\JabatanRepositoryInterface;

class JabatanRepository implements JabatanRepositoryInterface
{
    public function getAll()
    {
        return Jabatan::with('unitKerja')->orderBy('nama')->get();
    }

    public function findById(int $id)
    {
        return Jabatan::with('unitKerja')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Jabatan::create($data);
    }

    public function update(int $id, array $data)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($data);
        return $jabatan;
    }

    public function delete(int $id)
    {
        return Jabatan::findOrFail($id)->delete();
    }
}