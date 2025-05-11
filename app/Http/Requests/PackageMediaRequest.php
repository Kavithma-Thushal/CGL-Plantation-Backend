<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Enums\PackageMediaTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PackageMediaRequest extends FormRequest
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
        $validTypes =  implode(',', PackageMediaTypeEnum::values());
        return [
            'user_package_id'=>'required|exists:user_packages,id',
            'media_id'=>'required|exists:media,id',
            'type'=>'required|in:'.$validTypes
        ];
    }
}
