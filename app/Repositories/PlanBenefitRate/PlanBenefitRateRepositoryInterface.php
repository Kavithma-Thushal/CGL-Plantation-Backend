<?php

namespace App\Repositories\PlanBenefitRate;

use App\Repositories\CrudRepositoryInterface;

interface PlanBenefitRateRepositoryInterface extends CrudRepositoryInterface
{
    public function deleteByPlanId(int $planId) : void;
}
