<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeGetRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        return ErrorResponse::validationError($validator);
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'name'=>'nullable',
           'mobile_number'=>'nullable',
           'nic'=>'nullable',
           'username'=>'nullable',
           'employee_code'=>'nullable',
           'branch_id'=>'nullable',
        ];
    }
}
