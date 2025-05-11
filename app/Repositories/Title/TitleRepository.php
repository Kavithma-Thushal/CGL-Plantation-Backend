<?php

namespace App\Repositories\Title;

use App\Models\Title;
use App\Repositories\CrudRepository;

class TitleRepository extends CrudRepository implements TitleRepositoryInterface
{
    public function __construct(Title $model)
    {
        parent::__construct($model);
    }
}
