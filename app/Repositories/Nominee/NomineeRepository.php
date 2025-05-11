<?php

namespace App\Repositories\Nominee;

use App\Models\Nominee;
use App\Repositories\CrudRepository;

class NomineeRepository extends CrudRepository implements NomineeRepositoryInterface
{
    public function __construct(Nominee $model)
    {
        parent::__construct($model);
    }

    public function deleteNotInArray(int $userPackageId, array $idArray)
    {
        $this->model->whereNotIn('id',$idArray)->delete();
    }
}