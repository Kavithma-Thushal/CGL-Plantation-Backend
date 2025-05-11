<?php

namespace App\Repositories\EmployeeBankDetail;

use App\Repositories\CrudRepositoryInterface;

interface EmployeeBankDetailRepositoryInterface extends CrudRepositoryInterface
{
    public function deleteByEmployee(int $employeeId) : void;

    public function updateStatusByEmployee(int $employeeId) : void;
}
