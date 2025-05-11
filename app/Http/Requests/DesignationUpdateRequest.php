<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Models\Designation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class DesignationUpdateRequest extends FormRequest
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
            'parent_id' => 'nullable|int|exists:designations,id',
            'name' => 'required|string|max:65',
            'orc' => 'required|numeric|between:0,100',
            'code' => 'required|max:45',
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            if (!$this->isExists()) $validator->errors()->add(config('common.generic_error'), 'Invalid id');
            if (!$this->isValidParentId()) $validator->errors()->add('parent_id', 'The provided parent ID is already assigned as a designation within this designation.');
        });
    }

    private function isExists()
    {
        return Designation::where('id', $this->id)->exists();
    }

    public function isValidParentId()
    {
        if (!$this->parent_id) return true;
        $designation = Designation::find($this->id);
        return $designation->checkValidParentId($this->parent_id);
    }
}
