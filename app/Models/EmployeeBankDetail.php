<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBankDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bankAccount(){
        return $this->belongsTo(BankAccount::class);
    }
}
