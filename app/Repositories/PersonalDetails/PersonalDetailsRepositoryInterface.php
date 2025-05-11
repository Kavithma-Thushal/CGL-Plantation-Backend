<?php

namespace App\Repositories\PersonalDetails;

use App\Repositories\CrudRepositoryInterface;

interface PersonalDetailsRepositoryInterface extends CrudRepositoryInterface
{
    public function deactivateOldRecords($modelId,$model) : void;
}
