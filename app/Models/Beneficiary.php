<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;
    protected $guarded = [];
    

    public function userPackage()
    {
        return $this->belongsTo(UserPackage::class, 'user_package_id');
    }

    public function personalDetails()
    {
        return $this->morphMany(PersonalDetails::class, 'userable');
    }
  
    public function getPersonalDetail(): PersonalDetails
    {
        $personalDetail = $this->personalDetails()->where('status', 1)->first();
        return $personalDetail ?: new PersonalDetails;
    }
}
