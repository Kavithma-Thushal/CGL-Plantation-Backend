<?php

namespace App\Repositories\Introducer;

use App\Models\Introducer;
use App\Repositories\CrudRepository;

class IntroducerRepository extends CrudRepository implements IntroducerRepositoryInterface
{
    public function __construct(Introducer $model)
    {
        parent::__construct($model);
    }
}