<?php

namespace App\Services;

use App\Repositories\Interfaces\UnitKerjaRepositoryInterface;

class UnitKerjaService
{
    public function __construct(
        protected UnitKerjaRepositoryInterface $unitKerjaRepository
    ) {}

    public function getAll()
    {
        return $this->unitKerjaRepository->getAll();
    }

    public function findById(int $id)
    {
        return $this->unitKerjaRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->unitKerjaRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->unitKerjaRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->unitKerjaRepository->delete($id);
    }
}