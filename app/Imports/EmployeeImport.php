<?php

namespace App\Imports;

use App\Http\Services\EmployeeService;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $employeeService = App::make(EmployeeService::class);
        Log::info($row);
        // foreach ($rows as $row) {
            $employee = ['title_id' => $row['title_id'],
                        'name_with_initials' => $row['name_with_initials'],
                        'family_name' => $row['family_name'],
                        'first_name' => $row['first_name'],
                        'middle_name' => $row['middle_name'],
                        'last_name' => $row['last_name'],
                        'epf_number' => $row['epf_number'],
                        'commenced_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['commenced_date']))->format('Y-m-d'),
                        'mobile_number' => $row['mobile_number'],
                        'nic' => $row['nic'],
                        'dob' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['dob']))->format('Y-m-d'),
                        'address' => $row['address'],
                        'has_system_access' => $row['has_system_access'],
                        'user_role_id' => $row['user_role_id'],
                        'bank_id' => $row['bank_id'],
                        'branch' => $row['branch'],
                        'account_number' => $row['account_number'],
                        'base_branch_id' => $row['base_branch_id'],
                        'designation_id' => $row['designation_id'],
                        'reporting_person_id' => $row['reporting_person_id'],
                        'letter_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['letter_date']))->format('Y-m-d'),
                        'operating_branches' => json_decode($row['operating_branches'], true),
                        'email' => $row['email'],
            ];
            $employeeService->add($employee);
    }

    // public function rules(): array
    // {
    //     return [
    //         'title_id' => 'required|int',
    //         'name_with_initials' => 'required|string|max:255',
    //         'family_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
    //         'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
    //         'middle_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
    //         'last_name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
    //         'epf_number' => ['required', 'string', 'max:45'],
    //         'commenced_date' => 'required|date',
    //         'mobile_number' => 'required|max:17|string',
    //         'nic' => 'required|max:25|string',
    //         'dob' => 'required|date',
    //         'address' => 'nullable|max:2000|string',
    //         'has_system_access' => 'required|bool',
    //         'user_role_id' => 'required_if:has_system_access,1|nullable|int|exists:roles,id',
    //         'bank_id' => 'required|int|exists:banks,id',
    //         'branch' => 'required|string|max:255',
    //         'account_number' => 'required',
    //         'base_branch_id' => 'required|int|exists:branches,id',
    //         'designation_id' => 'required|int|exists:designations,id',
    //         'reporting_person_id' => 'nullable|int|exists:employees,id',
    //         'letter_date' => 'required|date',
    //         'operating_branches' => 'required|array',
    //         'operating_branches.*.branch_id' => 'required|int|exists:branches,id',
    //         'email' => 'required|email|unique:employees,email',
    //     ];
    // }
}
