<?php

namespace App\Repositories\UserPackage;

use App\Repositories\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface UserPackageRepositoryInterface extends CrudRepositoryInterface
{
    public function getPaginate(array $filters = [], array $relations = [],array $sortBy = []);
    public function getAll(array $filters = [], array $relations = [],array $sortBy = []) : Collection;
    public function getPaymentPending(array $filters = [], array $relations = []) : Collection;
}
