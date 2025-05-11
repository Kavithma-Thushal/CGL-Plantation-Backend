<?php

namespace App\Http\Services;

use App\Repositories\PlanTemplate\PlanTemplateRepositoryInterface;

class PlanTemplateService
{
    public function __construct(
        private PlanTemplateRepositoryInterface $planTemplateRepository,
    )
    {
    }

    public function find(int $id): ?object
    {
        return $this->planTemplateRepository->find($id);
    }

    public function getAll(array $filters): object
    {
        return $this->planTemplateRepository->getAll($filters);
    }

    public function add(array $data): ?object
    {
        return $this->planTemplateRepository->add($data);
    }

    public function update(int $id, array $data)
    {
        return $this->planTemplateRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->planTemplateRepository->delete($id);
    }

    public function hasChildren(int $id): bool
    {
        $obj = $this->planTemplateRepository->find($id);
        return $obj->children()->exists();
    }

    public function isIdExist(int $id)
    {
        return $this->planTemplateRepository->isIdExist($id);
    }

}
