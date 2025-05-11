<?php

namespace App\Http\Services;

use App\Repositories\AdministrativeLevel\AdministrativeLevelRepositoryInterface;

class AdministrativeLevelService
{
    public function __construct(
        private AdministrativeLevelRepositoryInterface $administrativeLevelRepository
    )
    {
    }

    public function find(int $id): ?object
    {
        return $this->administrativeLevelRepository->find($id);
    }

    public function getAll(array $filters): object
    {
        return $this->administrativeLevelRepository->getAll($filters);
    }

    public function add(array $data): ?object
    {
        return $this->administrativeLevelRepository->add($data);
    }

    public function update(int $id, array $data)
    {
        return $this->administrativeLevelRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->administrativeLevelRepository->delete($id);
    }

    public function hasChildren(int $id): bool
    {
        $obj = $this->administrativeLevelRepository->find($id);
        return $obj->children()->exists();
    }

    public function isIdExist(int $id) : bool
    {
        return $this->administrativeLevelRepository->isIdExist($id);
    }

}
