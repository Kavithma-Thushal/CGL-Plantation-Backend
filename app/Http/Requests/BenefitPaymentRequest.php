<?php

namespace App\Http\Requests;

use App\Models\Benefit;
use App\Classes\ErrorResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BenefitPaymentRequest extends FormRequest
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
            'benefit_id' => 'required|exists:benefits,id',
            'reference' => 'required|string|max:255'
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            if ($this->alreadyPaid()) $validator->errors()->add(config('common.generic_error'), 'Already Paid');
        });
    }

    private function alreadyPaid()
    {
        $benefit = Benefit::find($this->benefit_id);
        return $benefit->paid_at != null;
    }

}
