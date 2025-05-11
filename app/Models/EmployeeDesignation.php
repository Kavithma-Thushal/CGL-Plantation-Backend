<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeDesignation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function baseBranch()
    {
        return $this->belongsTo(Branch::class, 'base_branch_id');
    }

    public function reportingPerson()
    {
        return $this->belongsTo(Employee::class, 'reporting_person_id');
    }
}
