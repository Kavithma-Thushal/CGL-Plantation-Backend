<?php

namespace App\Repositories\Employee;

use App\Repositories\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeRepositoryInterface extends CrudRepositoryInterface
{
    public function getByNIC(string $nic): ?object;

    public function getByUserId(string $userId): ?object;

    public function getByMobile(string $nic): ?object;

    public function getAll(array $filters, array $relations = [], array $sortBy = []): Collection;
}
