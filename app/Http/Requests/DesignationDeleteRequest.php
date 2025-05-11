<?php

namespace App\Http\Requests;

use App\Models\Designation;
use App\Classes\ErrorResponse;
use Illuminate\Support\Facades\App;
use App\Http\Services\DesignationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class DesignationDeleteRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        ErrorResponse::validationError($validator);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            if ($validator->errors()->count() > 0) return;
            if (!$this->isExists()) $validator->errors()->add(config('common.generic_error'), 'Invalid id');
            if ($this->hasChildren()) $validator->errors()->add(config('common.generic_error'), 'Designation can not be deleted');
        });
    }

    private function isExists()
    {
        return Designation::where('id', $this->id)->exists();
    }

    private function hasChildren()
    {
        return Designation::where('parent_id',$this->id)->exists();
    }
}
