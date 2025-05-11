<?php

namespace App\Repositories\AdministrativeHierarchy;

use App\Models\AdministrativeHierarchy;
use App\Repositories\CrudRepository;

class AdministrativeHierarchyRepository extends CrudRepository implements AdministrativeHierarchyRepositoryInterface
{
    public function __construct(AdministrativeHierarchy $model)
    {
        parent::__construct($model);
    }
}
