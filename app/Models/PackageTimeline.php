<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTimeline extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function packageStatus()
    {
        return $this->belongsTo(PackageStatus::class,'package_status_id');
    }
}
