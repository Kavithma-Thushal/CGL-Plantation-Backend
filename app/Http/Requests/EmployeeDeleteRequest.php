<?php

namespace App\Http\Requests;

use App\Models\Employee;
use App\Classes\ErrorResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class EmployeeDeleteRequest extends FormRequest
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

    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            if (!$this->isExists()) return $validator->errors()->add(config('common.generic_error'), 'Invalid id');

            if ($this->isOwnAccount()) return $validator->errors()->add(config('common.generic_error'), 'You cannot delete your own account');

            $relationExistsMessage = $this->anyRelationExists();
            if ($relationExistsMessage !=  null) return $validator->errors()->add(config('common.generic_error'), $relationExistsMessage);
        });
    }

    private function isExists()
    {
        return Employee::where('id', $this->id)->exists();
    }

    private function isOwnAccount()
    {
        if ($this->isExists()) return false;
        return Auth::id() == Employee::find($this->id)->user->id;
    }

    private function anyRelationExists()
    {
        $employee = Employee::find($this->id);
        if (isset($employee->user->customer)) {
            return 'Cannot delete this employee because they are associated with a customer account';
        }

        $reportingPersons = $employee->reportingPersons()->exists();
        if ($reportingPersons != null) {
            return 'Cannot delete this employee because they are assigned as the reporting person for another employee';
        }

        $reportingPersons = $employee->reportingPersons()->exists();
        if ($reportingPersons != null) {
            return 'Cannot delete this employee because they are assigned as the reporting person for another employee';
        }

        $reportingPersons = $employee->userPackages()->exists();
        if ($reportingPersons != null) {
            return 'Cannot delete this employee because employee has created user packages';
        }
        return null;
    }
}
