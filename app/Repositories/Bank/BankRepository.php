<?php

namespace App\Repositories\Bank;

use App\Models\Bank;
use App\Repositories\CrudRepository;

class BankRepository extends CrudRepository implements BankRepositoryInterface
{
    public function __construct(Bank $model)
    {
        parent::__construct($model);
    }
}
