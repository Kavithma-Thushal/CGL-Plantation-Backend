<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CaseInsensitiveExists implements ValidationRule
{
    protected $table;
    protected $column;
    protected $exceptId;

    public function __construct($table, $column,$exceptId = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->exceptId = $exceptId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($this->exceptId == null){
            $exist = DB::table($this->table)
                ->whereRaw('LOWER('.$this->column.') = ?', [strtolower($value)])
                ->exists();
        }
        else{
            $exist = DB::table($this->table)
            ->where('id','!=',$this->exceptId)
            ->whereRaw('LOWER('.$this->column.') = ?', [strtolower($value)])
            ->exists();
        }

            if($exist){
                $fail($attribute ." is already taken");
            }
    }
}
