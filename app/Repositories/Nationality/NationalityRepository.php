<?php

namespace App\Repositories\Nationality;

use App\Models\Nationality;
use App\Repositories\CrudRepository;

class NationalityRepository extends CrudRepository implements NationalityRepositoryInterface
{
    public function __construct(Nationality $model)
    {
        parent::__construct($model);
    }
}