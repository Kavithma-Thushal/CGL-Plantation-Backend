<?php

namespace App\Repositories\Receipt;

use App\Repositories\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ReceiptRepositoryInterface extends CrudRepositoryInterface
{
    public function getAll(array $filters,array $relations = [],array $sortBy = []): Collection;
}