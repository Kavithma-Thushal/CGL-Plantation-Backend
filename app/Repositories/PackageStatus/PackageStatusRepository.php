<?php

namespace App\Repositories\PackageStatus;

use App\Models\PackageStatus;
use App\Repositories\CrudRepository;

class PackageStatusRepository extends CrudRepository implements PackageStatusRepositoryInterface
{
    public function __construct(PackageStatus $model)
    {
        parent::__construct($model);
    }

    public function getByName(string $name): ?PackageStatus
    {
        return $this->model->where('name', $name)->first();
    }
   
    public function getIdByName(string $name): ?int
    {
        $record =  $this->model->where('name', $name)->first();
        if(isset($record)){
            return $record->id;
        }
        return null;
    }
}
