<?php

namespace App\Repositories\EmployeeBankDetail;

use App\Models\EmployeeBankDetail;
use App\Repositories\CrudRepository;

class EmployeeBankDetailRepository extends CrudRepository implements EmployeeBankDetailRepositoryInterface
{
    public function __construct(EmployeeBankDetail $model)
    {
        parent::__construct($model);
    }

    public function deleteByEmployee(int $employeeId): void
    {
       $this->model->where('employee_id',$employeeId)->delete();
    }

    public function updateStatusByEmployee(int $employeeId) : void
    {
        $this->model->where('employee_id',$employeeId)->update(['status'=>0]);
    }
}
