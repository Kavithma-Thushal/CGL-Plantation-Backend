<?php

namespace App\Repositories\Race;

use App\Models\Race;
use App\Repositories\CrudRepository;

class RaceRepository extends CrudRepository implements RaceRepositoryInterface
{
    public function __construct(Race $model)
    {
        parent::__construct($model);
    }
}
