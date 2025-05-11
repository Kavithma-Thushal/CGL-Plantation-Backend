<?php

namespace App\Http\Services;

use App\Models\EmployeeBankDetail;
use App\Repositories\EmployeeBankDetail\EmployeeBankDetailRepositoryInterface;

class EmployeeBankDetailService
{
    public function __construct(
        private BankAccountService $bankAccountService,
        private EmployeeBankDetailRepositoryInterface $employeeBankDetailRepositoryInterface
    ) {
    }

    public function add(int $employeeId, array $data): EmployeeBankDetail
    {
        $this->employeeBankDetailRepositoryInterface->updateStatusByEmployee($employeeId);

        $bankAccountDetails = $data;
        $bankAccountDetails['branch_name'] = $data['branch'] ?? null;
        $bankAccount =  $this->bankAccountService->add($bankAccountDetails);

        $bankDetail = [
            'employee_id' => $employeeId,
            'bank_account_id' => $bankAccount->id,
            'status' => 1
        ];
        return $this->employeeBankDetailRepositoryInterface->add($bankDetail);
    }

    public function deleteByEmployee(int $employeeId): void
    {
        $this->employeeBankDetailRepositoryInterface->deleteByEmployee($employeeId);
    }
}
