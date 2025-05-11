<?php

namespace App\Repositories\QuotationRequest;

use App\Repositories\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface QuotationRequestRepositoryInterface extends CrudRepositoryInterface
{
    public function getAll(array $filters,array $relations = [],array $sortBy = []): Collection;
}
