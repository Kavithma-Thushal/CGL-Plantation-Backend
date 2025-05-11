<?php

namespace App\Repositories\Designation;

use App\Models\Designation;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Collection;

class DesignationRepository extends CrudRepository implements DesignationRepositoryInterface
{
    public function __construct(Designation $model)
    {
        parent::__construct($model);
    }

    public function getAllWithRelations(array $relations): Collection|array
    {
        return Designation::with($relations)->orderBy('id')->get();
    }
}
