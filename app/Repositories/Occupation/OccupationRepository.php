<?php

namespace App\Repositories\Occupation;

use App\Models\Occupation;
use App\Repositories\CrudRepository;

class OccupationRepository extends CrudRepository implements OccupationRepositoryInterface
{
    public function __construct(Occupation $model)
    {
        parent::__construct($model);
    }
}