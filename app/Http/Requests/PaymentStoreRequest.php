<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Enums\PaymentMethodsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PaymentStoreRequest extends FormRequest
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
        $paymentMethods =  implode(',', PaymentMethodsEnum::values());
        return [
            'user_package_id'=>'required|exists:user_packages,id',
            'amount'=>'required|min:0|not_in:0',
            'reference'=>'required|max:255',
            'payment_date'=>'required|date',
            'payment_method'=>'required|in:'.$paymentMethods,
            'note'=>'nullable',
            'send_receipt'=>'nullable',
            'download_receipt'=>'nullable',
        ];
    }
}
