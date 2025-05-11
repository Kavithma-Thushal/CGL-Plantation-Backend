<?php

namespace App\Repositories\TreeBrand;

use App\Models\TreeBrand;
use App\Repositories\CrudRepository;

class TreeBrandRepository extends CrudRepository implements TreeBrandRepositoryInterface
{
    public function __construct(TreeBrand $model)
    {
        parent::__construct($model);
    }
}