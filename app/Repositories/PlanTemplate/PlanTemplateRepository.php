<?php

namespace App\Repositories\PlanTemplate;

use App\Models\PlanTemplate;
use App\Repositories\CrudRepository;

class PlanTemplateRepository extends CrudRepository implements PlanTemplateRepositoryInterface
{
    public function __construct(PlanTemplate $model)
    {
        parent::__construct($model);
    }
}
