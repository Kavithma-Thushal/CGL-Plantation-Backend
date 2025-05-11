<?php

namespace App\Repositories\PackageStatus;

use App\Models\PackageStatus;
use App\Repositories\CrudRepositoryInterface;

interface PackageStatusRepositoryInterface extends CrudRepositoryInterface
{
    public function getByName(string $name): ?PackageStatus;
    public function getIdByName(string $name): ?int;
}
