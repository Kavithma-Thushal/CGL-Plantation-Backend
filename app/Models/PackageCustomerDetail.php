<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageCustomerDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
   
    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }
  
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function country()
    {
        return  $this->belongsTo(Country::class);
    }
}
