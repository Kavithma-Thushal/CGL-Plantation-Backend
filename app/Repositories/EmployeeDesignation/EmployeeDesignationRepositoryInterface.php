<?php

namespace App\Repositories\EmployeeDesignation;

use App\Models\EmployeeDesignation;
use App\Repositories\CrudRepositoryInterface;

interface EmployeeDesignationRepositoryInterface extends CrudRepositoryInterface
{
    public function findActiveByEmployeeId(int $employeeId) : ?EmployeeDesignation;

    public function deleteByEmployee(int $employeeId) : void;

    public function deactivateOldRecordsByEmployee(int $employeeId) : void;

}
