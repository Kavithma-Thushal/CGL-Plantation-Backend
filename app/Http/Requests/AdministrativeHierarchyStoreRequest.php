<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Models\AdministrativeHierarchy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Services\AdministrativeHierarchyService;

class AdministrativeHierarchyStoreRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'administrative_level_id' => 'required|int|exists:administrative_levels,id',
            'parent_id' => 'nullable|int|exists:administrative_hierarchies,id',
            'name' => 'required|string|max:45'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->isParentAdministrativeLevelValid()) $validator->errors()->add('administrative_level_id', 'Invalid administrative level');
        });
    }

    private function isParentAdministrativeLevelValid()
    {
        if (!$this->parent_id) return true;
        $administrativeHierarchy = AdministrativeHierarchy::find($this->parent_id);
        if ($administrativeHierarchy == null) return true;
        return $administrativeHierarchy->administrative_level_id = $this->administrative_level_id - 1;
    }
}
