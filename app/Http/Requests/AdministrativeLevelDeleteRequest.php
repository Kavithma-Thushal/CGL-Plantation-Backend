<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Models\AdministrativeLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Services\AdministrativeLevelService;

class AdministrativeLevelDeleteRequest extends FormRequest
{
    public function __construct(private AdministrativeLevelService $service)
    {
    }

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
        $validator->after(function ($validator) {
            if (!$this->isExists()) $validator->errors()->add(config('common.generic_error'), 'Invalid id');
            if ($this->hasChildren()) $validator->errors()->add(config('common.generic_error'), 'Administrative level can not be deleted');
        });
    }

    private function isExists(): bool
    {
        return AdministrativeLevel::where('id', $this->id)->exists();
    }

    private function hasChildren()
    {
        if (!$this->isExists()) return false;
        $administrativeLevel = AdministrativeLevel::find($this->id);
        if ($administrativeLevel == null) return true;
        return $administrativeLevel->AdministrativeHierarchies()->exists() || $administrativeLevel->hasChildren();
    }
}
