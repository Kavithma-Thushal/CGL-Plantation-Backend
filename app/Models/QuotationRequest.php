<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationRequest extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function title()
    {
        return $this->belongsTo(Title::class, 'title_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class,'quotation_request_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'agent_id');
    }

    public function branch()
    {
        return $this->belongsTo(EmployeeBranch::class, 'branch_id');
    }

}
