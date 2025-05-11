<?php

namespace App\Repositories\PackageMedia;

use App\Models\PackageMedia;
use App\Repositories\CrudRepository;

class PackageMediaRepository extends CrudRepository implements PackageMediaRepositoryInterface
{
    public function __construct(PackageMedia $model)
    {
        parent::__construct($model);
    }
}