<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Models\AdministrativeLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Services\AdministrativeLevelService;
use Illuminate\Contracts\Validation\ValidationRule;

class AdministrativeLevelUpdateRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|int|exists:administrative_levels,id',
            'name' => 'required|string|max:100'
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            if (!$this->isExists()) $validator->errors()->add(config('common.generic_error'), 'Invalid id');
            if (!$this->isValidParentId()) $validator->errors()->add('parent_id', 'The provided parent ID is already assigned as a administrative level within this administrative level.');
        });
    }

    private function isExists()
    {
        return AdministrativeLevel::where('id', $this->id)->exists();
    }

    public function isValidParentId()
    {
        if (!$this->isExists()) return false;
        if (!$this->parent_id) return true;
        $administrativeLevel = AdministrativeLevel::find($this->id);
        return $administrativeLevel->checkValidParentId($this->parent_id);
    }
}
