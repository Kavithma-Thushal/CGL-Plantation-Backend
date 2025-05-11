<?php

namespace App\Repositories\Plan;

use App\Models\Plan;
use App\Repositories\CrudRepository;

class PlanRepository extends CrudRepository implements PlanRepositoryInterface
{
    public function __construct(Plan $model)
    {
        parent::__construct($model);
    }

    public function getByCode($code): ?Plan
    {
        return Plan::where('code',$code)->first();
    }
}
