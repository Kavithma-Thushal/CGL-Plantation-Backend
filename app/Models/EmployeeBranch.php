<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBranch extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function currentEmployeeBranch()
    {
        return $this->hasOne(Employee::class,'current_employee_branch_id');
    }
}
