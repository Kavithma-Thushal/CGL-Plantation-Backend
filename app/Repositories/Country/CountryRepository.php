<?php

namespace App\Repositories\Country;

use App\Models\Country;
use App\Repositories\CrudRepository;

class CountryRepository extends CrudRepository implements CountryRepositoryInterface
{
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }
}