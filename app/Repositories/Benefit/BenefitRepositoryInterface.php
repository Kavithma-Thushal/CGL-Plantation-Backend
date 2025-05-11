<?php

namespace App\Repositories\Benefit;

use App\Repositories\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface BenefitRepositoryInterface extends CrudRepositoryInterface
{
    public function getAll(array $filters = [], array $relations = [],array $sortBy = []) : Collection;
}