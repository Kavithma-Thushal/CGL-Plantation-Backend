<?php

namespace App\Repositories\AdministrativeLevel;

use App\Models\AdministrativeLevel;
use App\Repositories\CrudRepository;

class AdministrativeLevelRepository extends CrudRepository implements AdministrativeLevelRepositoryInterface
{
    public function __construct(AdministrativeLevel $model)
    {
        parent::__construct($model);
    }
}
