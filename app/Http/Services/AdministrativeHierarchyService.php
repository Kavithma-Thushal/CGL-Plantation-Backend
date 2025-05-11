<?php

namespace App\Http\Services;

use App\Classes\CodeGenerator;
use App\Repositories\AdministrativeHierarchy\AdministrativeHierarchyRepositoryInterface;

class AdministrativeHierarchyService
{
    public function __construct(
        private AdministrativeHierarchyRepositoryInterface $administrativeHierarchyRepository
    ) {
    }

    public function find(int $designationId): ?object
    {
        return $this->administrativeHierarchyRepository->find($designationId);
    }

    public function getAll(array $filters): object
    {
        return $this->administrativeHierarchyRepository->getAll($filters);
    }

    public function add(array $data): ?object
    {
        return $this->administrativeHierarchyRepository->add($data);
    }

    public function update(int $designationId, array $data)
    {
        return $this->administrativeHierarchyRepository->update($designationId, $data);
    }

    public function delete(int $designationId)
    {
        return $this->administrativeHierarchyRepository->delete($designationId);
    }

    public function hasChildren(int $designationId): bool
    {
        $designation = $this->administrativeHierarchyRepository->find($designationId);
        return $designation->children()->exists();
    }

    public function doesParentValidInHierarchy(){
        
    }
}
