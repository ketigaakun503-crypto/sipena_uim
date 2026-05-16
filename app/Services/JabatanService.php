<?php

namespace App\Services;

use App\Repositories\Interfaces\JabatanRepositoryInterface;

class JabatanService
{
    public function __construct(
        protected JabatanRepositoryInterface $jabatanRepository
    ) {}

    public function getAll()
    {
        return $this->jabatanRepository->getAll();
    }

    public function findById(int $id)
    {
        return $this->jabatanRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->jabatanRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->jabatanRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->jabatanRepository->delete($id);
    }
}