<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function planTemplate(): BelongsTo
    {
        return $this->belongsTo(PlanTemplate::class, 'plan_template_id');
    }

    public function planBenefitRates(): HasMany
    {
        return $this->hasMany(PlanBenefitRate::class, 'plan_id');
    }

    public function userPackages()
    {
        return $this->hasMany(UserPackage::class, 'plan_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'plan_id');
    }
}
