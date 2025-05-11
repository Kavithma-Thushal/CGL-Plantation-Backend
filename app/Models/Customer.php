<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function packageCustomerDetails()
    {
        return $this->hasMany(PackageCustomerDetail::class, 'customer_id');
    }
}
