<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getNameAttribute()
    {
        $personalDetail = $this->personalDetails()->where('status', 1)->first();
        $name = $personalDetail->first_name;
        if($personalDetail->middle != ""){
            $name .= " ".$personalDetail->middle;
        }
        if($personalDetail->last_name != ""){
            $name .= " ".$personalDetail->last_name;
        }
        return $name;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function personalDetails()
    {
        return $this->morphMany(PersonalDetails::class, 'userable');
    }

    public function employeeDesignations()
    {
        return $this->hasMany(EmployeeDesignation::class);
    }

    public function reportingPersons()
    {
        return $this->hasMany(EmployeeDesignation::class, 'reporting_person_id');
    }

    public function operationBranches()
    {
        return $this->hasMany(EmployeeBranch::class);
    }

    public function userPackages()
    {
        return $this->hasMany(UserPackage::class,'agent_id');
    }

    public function employeeBankDetails()
    {
        return $this->hasMany(EmployeeBankDetail::class);
    }

    public function employeeBranches()
    {
        return $this->hasMany(EmployeeBranch::class);
    }

    public function currentEmployeeBranch()
    {
        return $this->belongsTo(EmployeeBranch::class, 'current_employee_branch_id');
    }

    public function getPersonalDetail(): PersonalDetails
    {
        $personalDetail = $this->personalDetails()->latest()->where('status', 1)->first();
        return $personalDetail ?: new PersonalDetails;
    }

    public function getActiveEmployeeDesignation(): EmployeeDesignation
    {
        $record = $this->employeeDesignations()->latest()->where('status', 1)->first();
        return $record ?: new EmployeeDesignation;
    }
}
