<?php

namespace App\Repositories\Branch;

use App\Models\Branch;
use App\Repositories\CrudRepository;

class BranchRepository extends CrudRepository implements BranchRepositoryInterface
{
    public function __construct(Branch $model)
    {
        parent::__construct($model);
    }
}
