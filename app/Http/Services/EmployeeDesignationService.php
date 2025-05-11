<?php

namespace App\Http\Services;

use App\Classes\CodeGenerator;
use App\Models\EmployeeDesignation;
use App\Repositories\EmployeeDesignation\EmployeeDesignationRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class EmployeeDesignationService
{
    public function __construct(
        private EmployeeDesignationRepositoryInterface $employeeDesignationRepositoryInterface,
    ) {
    }

    public function add(int $employeeId,array $data) : EmployeeDesignation
    {
        $this->employeeDesignationRepositoryInterface->deactivateOldRecordsByEmployee($employeeId);
        $record = [
            'employee_id'=>$employeeId,
            'reporting_person_id'=>$data['reporting_person_id'] ?? null,
            'designation_id' => $data['designation_id'],
            'base_branch_id' => $data['base_branch_id'],
            'start_date' => $data['letter_date'],
            'end_date' => null,
            'status'=>1
        ];
        //First employee is creating trough UserSeeder in test environments.There is no auth user in that moment
        if (app()->environment() !== 'production' && !Auth::check()) {
            $record['created_user_id'] = 1;
        }else{
            $record['created_user_id'] = Auth::id();
        }
       return  $this->employeeDesignationRepositoryInterface->add($record);
    }

}
