<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $personalDetail = $this->getPersonalDetail();
        $bankDetail = $this->employeeBankDetails()->latest()->first();
        $designation = $this->getActiveEmployeeDesignation();
        $role = $this->user->roles()->where('guard_name', 'web')->first();
        return [
            'id' => $this->id,
            'user_id' => $this->user->id,
            'title_id' => $personalDetail->title_id,
            'designation_id' => $designation->designation_id,
            'base_branch_id' => $designation->base_branch_id,
            'has_system_access' => $this->user->has_system_access,
            'nic' => $this->user->nic,
            'dob' => $this->user->dob,
            'epf_number' => $this->epf_number,
            'employee_code' => $this->employee_code,
            'commenced_date' => $this->commenced_date,
            'title' => $personalDetail != null ? $personalDetail->title->name : null,
            'name_with_initials' => $personalDetail->name_with_initials ?: null,
            'first_name' => $personalDetail->first_name ?: null,
            'last_name' => $personalDetail->last_name ?: null,
            'middle_name' => $personalDetail->middle_name ?: null,
            'family_name' => $personalDetail->family_name ?: null,
            'address' => $personalDetail->address ?: null,
            'mobile_number' => $personalDetail->mobile_number ?: null,
            'bank_id' => $bankDetail->bankAccount->bank_id ?? null,
            'bank_name' =>  $bankDetail->bankAccount->bank->name ?? null,
            'branch' =>  $bankDetail->bankAccount->branch_name ?? null,
            'account_number' =>  $bankDetail->bankAccount->account_number ?? null,
            'base_branch_name' => $designation->baseBranch->name ?? null,
            'designation_name' => $designation->designation->name ?? null,
            'reporting_person_id' => $designation->reporting_person_id ?? null,
            'reporting_person_name' => $designation->reportingPerson->name ?? null,
            'letter_date' => $designation->start_date ?? null,
            'username' => $this->user->has_system_access ? $this->user->username : null,
            'user_role' => $this->user->has_system_access ? new RoleResource($role) : null,
            'media_array' => new MediaResource($this->user->avatar),
            'operation_branches' => EmployeeBranchResource::collection($this->operationBranches),
            'email' => $this->email,
        ];
    }
}
