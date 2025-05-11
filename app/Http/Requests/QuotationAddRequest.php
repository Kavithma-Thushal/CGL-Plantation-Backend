<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class QuotationAddRequest extends FormRequest
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
            'nic'=>'required|string|max:25',
            'title_id'=>'required|exists:titles,id',
            'name_with_initials' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'mobile_number' => 'required|max:17|string',
            'address' => 'nullable|max:2000|string',
            'email' => 'nullable|email|max:2000|string',
            'landline_number' => 'nullable|max:20|string',
            'plans' => 'array|required',
            'plans.*.plan_id' => 'required|exists:plans,id',
            'plans.*.amount' => 'required|numeric|min:0|not_in:0',
            'land_size' => 'nullable|numeric|min:0',
            'number_of_trees' => 'nullable|numeric|min:0',
            'agent_id'=> 'required'
        ];
    }
}
