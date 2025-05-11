<?php

namespace App\Repositories\Designation;

use App\Repositories\CrudRepositoryInterface;

interface DesignationRepositoryInterface  extends CrudRepositoryInterface
{
    public function getAllWithRelations(array $relations);
}
