<?php

namespace App\Http\Services;

use App\Models\BankAccount;
use App\Repositories\BankAccount\BankAccountRepositoryInterface;

class BankAccountService
{
    public function __construct(
        private BankAccountRepositoryInterface $bankAccountRepositoryInterface
    ) {
    }

    public function add(array $data): BankAccount
    {
        $bankAccountDetails = [
            'bank_id' => $data['bank_id'],
            'account_number' => $data['account_number'],
            'branch_name' => $data['branch_name'] ?? null
        ];
        return $this->bankAccountRepositoryInterface->add($bankAccountDetails);
    }
   
    public function update(int $id,array $data)
    {
        $bankAccountDetails = [
            'bank_id' => $data['bank_id'],
            'account_number' => $data['account_number'],
            'branch_name' => $data['branch_name'] ?? null
        ];
        return $this->bankAccountRepositoryInterface->update($id,$bankAccountDetails);
    }
}
