<?php

namespace App\Repositories\PlanBenefitRate;

use App\Models\PlanBenefitRate;
use App\Repositories\CrudRepository;

class PlanBenefitRateRepository extends CrudRepository implements PlanBenefitRateRepositoryInterface
{
    public function __construct(PlanBenefitRate $model)
    {
        parent::__construct($model);
    }

    public function deleteByPlanId(int $planId): void
    {
        $this->model->where('plan_id',$planId)->delete();
    }
}
