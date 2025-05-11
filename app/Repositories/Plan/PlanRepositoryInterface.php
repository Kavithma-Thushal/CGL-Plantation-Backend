<?php

namespace App\Repositories\Plan;

use App\Models\Plan;
use App\Repositories\CrudRepositoryInterface;

interface PlanRepositoryInterface extends CrudRepositoryInterface
{
    public function getByCode($code) : ?Plan;
}
