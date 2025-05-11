<?php

namespace App\Repositories\EmployeeDesignation;

use App\Models\EmployeeDesignation;
use App\Repositories\CrudRepository;

class EmployeeDesignationRepository extends CrudRepository implements EmployeeDesignationRepositoryInterface
{
    public function __construct(EmployeeDesignation $model)
    {
        parent::__construct($model);
    }

    public function findActiveByEmployeeId(int $employeeId): ?EmployeeDesignation
    {
        return $this->model->where('employee_id',$employeeId)->active()->first();
    }

    public function deleteByEmployee(int $employeeId): void
    {
        $this->model->where('employee_id', $employeeId)->delete();
    }

    public function deactivateOldRecordsByEmployee(int $employeeId) : void
    {
        $this->model->where('employee_id',$employeeId)->update(['status'=>0]);
    }
}
