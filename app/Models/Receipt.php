<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function userPackage()
    {
        return $this->belongsTo(UserPackage::class, 'user_package_id');
    }

    public static function getNextNumber(): array
    {
        $index = 1;
        if (self::count() > 0) {
            $index = self::latest()->first()->ref_number_index + 1;
        }
        $receiptNumber = $index;
        return ['index' => $index, 'number' => $receiptNumber];
    }
}
