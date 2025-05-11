<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Http\Services\PlanService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;

class PlanUpdateRequest extends FormRequest
{
    public function __construct(private PlanService $service)
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
            //            'parent_id' => 'nullable|exists:administrative_levels,id',
            'name' => 'required|string|max:100',
            //            'duration' => 'required|numeric',
            'minimum_amount' => 'required|numeric',
            'description' => 'nullable|string',
            //            'interest_rates' => 'required|array',
            //            'interest_rates.*.id' => 'required|integer|exists:plan_benefit_rates,id',
            //            'interest_rates.*.year' => 'required|integer|min:1',
            //            'interest_rates.*.rate' => 'required|numeric|min:0',
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            if (!$this->isIdExists()) $validator->errors()->add(config('common.generic_error'), 'Invalid id');
        });
    }

    private function isIdExists(): bool
    {
        return $this->service->isIdExist($this->id);
    }
}
