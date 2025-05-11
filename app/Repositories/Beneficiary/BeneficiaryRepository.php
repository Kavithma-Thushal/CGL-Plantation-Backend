<?php

namespace App\Repositories\Beneficiary;

use App\Models\Beneficiary;
use App\Repositories\CrudRepository;

class BeneficiaryRepository extends CrudRepository implements BeneficiaryRepositoryInterface
{
    public function __construct(Beneficiary $model)
    {
        parent::__construct($model);
    }
}