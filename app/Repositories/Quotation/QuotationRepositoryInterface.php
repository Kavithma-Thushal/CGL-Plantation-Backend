<?php

namespace App\Repositories\Quotation;

use App\Repositories\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface QuotationRepositoryInterface extends CrudRepositoryInterface
{
    public function getAll(array $filters,array $relations = [],array $sortBy = []): Collection;
}
