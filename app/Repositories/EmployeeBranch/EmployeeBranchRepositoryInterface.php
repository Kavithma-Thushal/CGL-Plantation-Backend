<?php

namespace App\Repositories\EmployeeBranch;

use App\Models\EmployeeBranch;
use App\Repositories\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeBranchRepositoryInterface extends CrudRepositoryInterface
{
    public function deactivateUnRelatedRecords(int $employeeId,array $branchIds) : void;

    public function deleteByEmployee(int $employeeId) : void;

    public function firstOrCreate(array $keys,array $values) : EmployeeBranch;
}
