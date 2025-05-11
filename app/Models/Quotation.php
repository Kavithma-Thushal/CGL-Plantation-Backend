<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function quotationRequest()
    {
        return $this->belongsTo(QuotationRequest::class, 'quotation_request_id');
    }

    public static function getNextNumber() : int
    {
        $latest = self::latest()->first();
        if($latest == null) return 1;
        return intval($latest->quotation_number) + 1;
    }
}
