<?php

namespace App\Http\Services;

use App\Models\EmployeeBranch;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\EmployeeBranch\EmployeeBranchRepositoryInterface;

class EmployeeBranchService
{
    public function __construct(
        private EmployeeBranchRepositoryInterface $employeeBranchRepositoryInterface,
        private EmployeeRepositoryInterface $employeeRepositoryInterface
    ) {}

    public function add(int $employeeId, array $operationBranches = [],): Void
    {
        $branchIds =  array_column($operationBranches, 'branch_id');
        $this->employeeBranchRepositoryInterface->deactivateUnRelatedRecords($employeeId, $branchIds);
        foreach ($operationBranches as $operationBranch) {
            $this->employeeBranchRepositoryInterface->updateOrCreate([
                'employee_id' => $employeeId,
                'branch_id' => $operationBranch['branch_id'],
            ], [
                'status' => 1
            ]);
        }
    }

    public function find(int $id){
        return $this->employeeBranchRepositoryInterface->find($id);
    }

    public function firstOrCreate(int $employeeId, int $branchId): EmployeeBranch
    {
        $keys = ['employee_id' => $employeeId];
        $values = ['branch_id' => $branchId];
        return $this->employeeBranchRepositoryInterface->firstOrCreate($keys, $values);
    }

    public function getAll(array $filters = []): Collection
    {
        return $this->employeeBranchRepositoryInterface->getAll($filters);
    }

    public function getBranchesForEmployee($employeeId)
    {
        $employee = $this->employeeRepositoryInterface->find($employeeId);
        return  $this->getAll(['employee_id' => $employeeId])->map(function ($item) use ($employee) {
            $item['is_current_branch'] = $employee->current_employee_branch_id == $item->id;
            return $item;
        });
    }
}
