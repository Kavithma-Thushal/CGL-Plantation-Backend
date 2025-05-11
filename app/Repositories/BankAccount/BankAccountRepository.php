<?php

namespace App\Repositories\BankAccount;

use App\Models\BankAccount;
use App\Repositories\CrudRepository;

class BankAccountRepository extends CrudRepository implements BankAccountRepositoryInterface
{
    public function __construct(BankAccount $model)
    {
        parent::__construct($model);
    }
}
