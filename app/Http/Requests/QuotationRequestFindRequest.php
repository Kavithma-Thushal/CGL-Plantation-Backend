<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Models\QuotationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class QuotationRequestFindRequest extends FormRequest
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
            //
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->isExists()) $validator->errors()->add(config('common.generic_error'), 'Invalid id');
        });
    }

    private function isExists()
    {
        return QuotationRequest::where('id', $this->id)->exists();
    }
}
