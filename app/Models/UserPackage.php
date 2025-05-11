<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function benefits(){
        return $this->belongsTo(Benefit::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'plan_id');
    }
  
    public function treeBrand()
    {
        return $this->belongsTo(TreeBrand::class, 'tree_brand_id');
    }
  
    // package created staff user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }
   
    public function beneficiary()
    {
        return $this->hasOne(Beneficiary::class, 'user_package_id');
    }

    public function nominees()
    {
        return $this->hasMany(Nominee::class, 'user_package_id');
    }
  
    public function receipts()
    {
        return $this->hasMany(Receipt::class, 'user_package_id');
    }
 
    public function packageTimeline()
    {
        return $this->hasMany(PackageTimeline::class, 'user_package_id');
    }

    public function packageMedia()
    {
        return $this->hasMany(PackageMedia::class, 'user_package_id');
    }

    public function introducer()
    {
        return $this->hasOne(Introducer::class, 'user_package_id');
    }

    public function packageCustomerDetail()
    {
        return $this->hasOne(PackageCustomerDetail::class, 'user_package_id');
    }
    
    public function getActiveTimeline() : PackageTimeline
    {
        return $this->packageTimeline()->with(['packageStatus'])->where('status',1)->first();
    }

    public function getPackageMediaViaType(string $type){
        $packageMedia =  $this->packageMedia()->where('type',$type)->first();
        if($packageMedia == null) return null;
        return [
            'package_media_id'=> $packageMedia->id,
            'path'=>$packageMedia->media->getPaths()
        ];
     }
}
