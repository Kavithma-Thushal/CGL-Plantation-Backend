<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Models\AdministrativeHierarchy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;

class AdministrativeHierarchyUpdateRequest extends FormRequest
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
            if (!$this->isExists()) $validator->errors()->add(config('common.generic_error'), 'Invalid id');
            if (!$this->isValidParentId()) $validator->errors()->add('parent_id', 'The provided parent ID is already assigned as a administrative hierarchy within this administrative hierarchy.');
        });
    }

    private function isExists()
    {
        return AdministrativeHierarchy::where('id', $this->id)->exists();
    }

    public function isValidParentId()
    {
        if (!$this->parent_id) return true;
        if (!$this->isExists()) return true;
        $administrativeHierarchy = AdministrativeHierarchy::find($this->id);
        return $administrativeHierarchy->checkValidParentId($this->parent_id);
    }
}
