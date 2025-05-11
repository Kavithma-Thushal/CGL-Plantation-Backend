<?php

namespace App\Repositories\PersonalDetails;

use App\Models\PersonalDetails;
use App\Repositories\CrudRepository;

class PersonalDetailsRepository extends CrudRepository implements PersonalDetailsRepositoryInterface
{

    public function __construct(PersonalDetails $model)
    {
        parent::__construct($model);
    }

    public function deactivateOldRecords($modelId, $model) : void
    {
       $this->model->where('userable_id',$modelId)->where('userable_type',$model)->update(['status'=>0]);
    }
}
