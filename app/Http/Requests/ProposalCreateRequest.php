<?php

namespace App\Http\Requests;

use App\Enums\Languages;
use App\Classes\NICConverter;
use App\Classes\ErrorResponse;
use App\Enums\PaymentModesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class ProposalCreateRequest extends FormRequest
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
        $paymentModes =  implode(',', PaymentModesEnum::values());
        return [
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'nullable|email',
            'title_id' => 'required|exists:titles,id',
            'name_with_initials' => 'nullable|string|max:255',
            'family_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'license_number' => 'nullable|string|max:30',
            'agent_id' => 'required|exists:employees,id',
            'address' => 'nullable|string|max:255',
            'total_amount' => 'required|numeric|min:0|not_in:0',
            'lang' => 'required|in:' . implode(',', Languages::values()),
            'nic' => 'required|string|max:25',
            // 'mobile_number' => 'required|string|max:20|regex:/^[0-9]+$/',
            'mobile_number' => 'required|string|max:20',
            'country_id' => 'nullable|exists:countries,id',
            'race_id' => 'nullable|exists:races,id',
            'nationality_id' => 'nullable|exists:nationalities,id',
            'occupation_id' => 'nullable|exists:occupations,id',
            'passport_number' => 'nullable|string|max:35',
            'payment_mode' => 'required|in:' . $paymentModes,
            'name_with_initial_si' => 'required_if:lang,' . Languages::SINHALA . '|nullable|string|max:255',
            'family_name_si' => 'required_if:lang,' . Languages::SINHALA . '|nullable|string|max:255',
            'first_name_si' => 'required_if:lang,' . Languages::SINHALA . '|nullable|string|max:255',
            'middle_name_si' => 'required_if:lang,' . Languages::SINHALA . '|nullable|string|max:255',
            'last_name_si' => 'required_if:lang,' . Languages::SINHALA . '|nullable|string|max:255',
            'address_si' => 'required_if:lang,' . Languages::SINHALA . '|nullable|string|max:255',
            'nominees' => 'required|array',
            'plan_id' => 'required|exists:plans,id',
            'land_size' => 'nullable|numeric|min:0',
            'land_value' => 'nullable|numeric|min:0',
            'number_of_trees' => 'nullable|numeric|min:0',
            'term' => 'nullable',
            'tree_brand_id' => 'nullable|exists:tree_brands,id',
            'mode_of_payment' => 'nullable|exists:tree_brands,id',

            'beneficiary.title_id' => 'nullable|exists:titles,id',
            'beneficiary.name_with_initials' => 'nullable|string|max:255',
            'beneficiary.family_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'beneficiary.first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'beneficiary.middle_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'beneficiary.last_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'beneficiary.nic' => 'required|string|max:30',
            'beneficiary.relationship' => 'required|string|max:255',
            "beneficiary.bank_id" => "required|exists:banks,id",
            "beneficiary.account_number" => "required|string|max:30",
            "beneficiary.branch_name" => "nullable|string|max:50",

            'nominees.*.title_id' => 'required|exists:titles,id',
            'nominees.*.name_with_initials' => 'required|string|max:255',
            'nominees.*.family_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nominees.*.first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nominees.*.middle_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nominees.*.last_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nominees.*.nic' => 'required|string|max:30',
            'nominees.*.relationship' => 'required|string|max:255',
            'nominees.*.percentage' => 'required|min:0|not_in:0|numeric|max:100',

            'introducer.title_id' => 'nullable|exists:titles,id',
            'introducer.name_with_initials' => 'nullable|string|max:255',
            'introducer.family_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'introducer.first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'introducer.middle_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'introducer.last_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'introducer.nic' => 'required|string|max:30',
            'introducer.relationship' => 'required|string|max:255',
            'introducer.reason' => 'required|string|max:2000'
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            $percentageSum = $this->getPercentageSum();
            if ($percentageSum != 100) $validator->errors()->add('nominees', 'Nominee percentage sum need to be equal to 100%.Current sum is ' . $percentageSum . '%');
            // if (!$this->isValidNicFormat()) $validator->errors()->add('nic', 'Invalid NIC number');
            if (!$this->hasAuthBranch()) $validator->errors()->add(config('common.generic_error'), 'User branch is invalid');
        });
    }

    private function isValidNicFormat(): bool
    {
        return NICConverter::validate($this->nic);
    }
   
    private function hasAuthBranch()
    {
        return Auth::user()->employee->currentEmployeeBranch->branch_id ?? null;
    }

    private function getPercentageSum()
    {
        $percentages = array_column($this->nominees, 'percentage');
        return array_sum($percentages);
    }
}
