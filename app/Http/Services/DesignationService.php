<?php

namespace App\Http\Services;

use App\Http\Resources\DesignationResource;
use App\Repositories\Designation\DesignationRepositoryInterface;

class DesignationService
{
    public function __construct(
        private DesignationRepositoryInterface $designationRepositoryInterface
    ) {
    }

    public function find(int $designationId): ?object
    {
        return $this->designationRepositoryInterface->find($designationId);
    }

    public function getAll(array $filters): object
    {
        return $this->designationRepositoryInterface->getAll($filters);
    }

    public function add(array $data): ?object
    {
        return $this->designationRepositoryInterface->add($data);
    }

    public function update(int $designationId, array $data): bool
    {
        return $this->designationRepositoryInterface->update($designationId, $data);
    }

    public function delete(int $designationId): bool
    {
        return $this->designationRepositoryInterface->delete($designationId);
    }

    public function hasChildren(int $designationId): bool
    {
        $designation = $this->designationRepositoryInterface->find($designationId);
        return $designation->children()->exists();
    }

    public function getTree(): array
    {
        $designations = $this->designationRepositoryInterface->getAllWithRelations(['children']);
        return $this->buildTree($designations);
    }

    private function buildTree($designations, $parentId = null, $level = 0): array
    {
        $branch = [];
        foreach ($designations as $designation) {
            if ($designation->parent_id == $parentId) {
                $children = $this->buildTree($designations, $designation->id, $level + 1);
                $node = [
                    'id' => $designation['id'],
                    'expanded' => !empty($children),
                    'type' => 'person',
                    'styleClass'=>'hierarchy-color_'.$level,
                    'level' => $level,
                    'data' => new DesignationResource($designation),
                    'children' => $children
                ];
                $branch[] = $node;
            }
        }
        return $branch;
    }
}
