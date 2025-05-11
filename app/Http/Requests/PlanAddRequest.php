<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;

class PlanAddRequest extends FormRequest
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
            'plan_template_id' => 'required|int|exists:plan_templates,id',
            'name' => 'required|string|max:255',
            'duration' => 'required|numeric|min:0|not_in:0',
            'minimum_amount' => 'required|numeric|min:0|not_in:0',
            'description' => 'nullable|string',
            'benefit_per_month' => 'required_if:plan_template_id,3,4|numeric|min:0',//Benefit + Profit + Capital & Benefit + Maturity
            'profit_per_month' => 'required_if:plan_template_id,3|numeric|min:0',//Benefit + Profit + Capital
            'interest_rates' => 'nullable|array',
            'interest_rates.*.year' => 'required|integer|min:1',
            'interest_rates.*.rate' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'interest_rates.*.year.min'=>'Interest year must be grater than 0',
            'interest_rates.*.year.required'=>'Interest year is required',
            'interest_rates.*.year.numeric'=>'Interest year must be a number',

            'interest_rates.*.rate.min'=>'Interest rate can not have negative values',
            'interest_rates.*.rate.required'=>'Interest rate is required',
            'interest_rates.*.rate.numeric'=>'Interest rate must be a number',
            'benefit_per_month.required_if'=>'Benefit per month field is required for selected plan template'
        ];
    }
}
