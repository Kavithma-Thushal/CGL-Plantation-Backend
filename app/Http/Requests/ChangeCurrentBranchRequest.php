<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Http\Services\EmployeeBranchService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ChangeCurrentBranchRequest extends FormRequest
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
            'id'=>'required|exists:employee_branches,id'
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            $employeeBranchService = App::make(EmployeeBranchService::class);
            $employeeBranch = $employeeBranchService->find($this->id);
            if ($employeeBranch->employee_id != Auth::user()->employee->id) $validator->errors()->add(config('common.generic_error'), 'Unauthorized id');
        });
    }

}
