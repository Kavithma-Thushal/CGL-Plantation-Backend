<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getNameAttribute(){
        return trim(($this->title->name ?? '') . $this->first_name . ' ' . ($this->middle_name ? $this->middle_name . ' ' : '') . $this->last_name);
    }

    public function scopeActive($query){
        return $query->where('status',1);
    }

    public function title(){
        return $this->belongsTo(Title::class);
    }

    public function userable()
    {
        return $this->morphTo();
    }
    
}
