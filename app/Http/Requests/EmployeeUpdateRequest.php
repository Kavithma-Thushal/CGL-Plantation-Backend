<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Employee;
use App\Classes\ErrorResponse;
use App\Classes\NICConverter;
use Illuminate\Support\Facades\App;
use App\Rules\CaseInsensitiveExists;
use App\Http\Services\EmployeeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class EmployeeUpdateRequest extends FormRequest
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
            'title_id' => 'required|int|exists:titles,id',
            'name_with_initials' => 'nullable|string|max:255',
            'family_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'middle_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'epf_number' => ['required', 'string', 'max:45', new CaseInsensitiveExists('employees', 'epf_number', $this->id)],
            'media_id' => 'nullable|int|exists:media,id',
            'commenced_date' => 'required|date',
            'mobile_number' => 'required|max:17|string',
            'nic' => 'required|max:45|string',
            'dob' => 'required|date',
            'address' => 'nullable|max:2000|string',
            'has_system_access' => 'required|bool',
            'user_role_id' => 'required_if:has_system_access,1|int|exists:roles,id',
            'bank_id' => 'required|int|exists:banks,id',
            'branch' => 'required|string|max:255',
            'account_number' => 'required',
            'base_branch_id' => 'required|int|exists:branches,id',
            'designation_id' => 'required|int|exists:designations,id',
            'reporting_person_id' => 'nullable|int|exists:employees,id',
            'letter_date' => 'required|date',
            'operating_branches' => 'required|array',
            'operating_branches.*.branch_id' => 'required|int|exists:branches,id',
            'email' => 'required|email|unique:employees,email,' . $this->id,
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            if ($validator->errors()->count() > 0) return;
            if (!$this->isExists()) $validator->errors()->add(config('common.generic_error'), 'Invalid id');
            if ($this->hasEmployeeWithSameMobile()) $validator->errors()->add('mobile_number', 'Employee account already exist with same mobile number');
            if ($this->hasEmployeeWithSameNIC()) $validator->errors()->add('nic', 'Employee account already exist with same NIC number');
            if (!$this->isValidNicFormat()) $validator->errors()->add('nic', 'Invalid NIC number');
        });
    }

    private function isValidNicFormat() : bool
    {
        return NICConverter::validate($this->nic);
    }

    private function hasEmployeeWithSameMobile(): bool
    {
        $service = App::make(EmployeeService::class);
        $record = $service->getByMobile($this->mobile_number);
        if ($record == null) return false;
        return $record->id != $this->id;
    }

    private function hasEmployeeWithSameNIC(): bool
    {
        $service = App::make(EmployeeService::class);
        $record = $service->getByNIC($this->nic);
        if ($record == null) return false;
        return $record->id != $this->id;
    }

    private function isExists(): bool
    {
        return Employee::where('id', $this->id)->exists();
    }

    public function messages()
    {
        return [
            'user_role_id.required_if' => 'User role is required',
        ];
    }
}
