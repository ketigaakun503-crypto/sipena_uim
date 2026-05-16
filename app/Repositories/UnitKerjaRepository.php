<?php

namespace App\Repositories;

use App\Models\UnitKerja;
use App\Repositories\Interfaces\UnitKerjaRepositoryInterface;

class UnitKerjaRepository implements UnitKerjaRepositoryInterface
{
    public function getAll()
    {
        return UnitKerja::with('parent')->orderBy('jenis')->get();
    }

    public function findById(int $id)
    {
        return UnitKerja::findOrFail($id);
    }

    public function create(array $data)
    {
        return UnitKerja::create($data);
    }

    public function update(int $id, array $data)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        $unitKerja->update($data);
        return $unitKerja;
    }

    public function delete(int $id)
    {
        return UnitKerja::findOrFail($id)->delete();
    }
}