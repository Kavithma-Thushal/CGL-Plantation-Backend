<?php

namespace App\Http\Requests;

use App\Models\UserPackage;
use App\Classes\ErrorResponse;
use App\Enums\PackageStatusesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProposalDocumentVerifyRequest extends FormRequest
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
            'proposal_id' => 'required|exists:user_packages,id',
        ];
    }


    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            if (!$this->packageCurrentStatusIsCorrect()) $validator->errors()->add(config('common.generic_error'), 'Package current status is invalid');
        });
    }

    private function packageCurrentStatusIsCorrect(): bool
    {
        $userPackage  = UserPackage::find($this->proposal_id);
        $packageTimeline = $userPackage->getActiveTimeline();
        return $packageTimeline->packageStatus->name == PackageStatusesEnum::DOCUMENT_VERIFICATION;
    }
}
