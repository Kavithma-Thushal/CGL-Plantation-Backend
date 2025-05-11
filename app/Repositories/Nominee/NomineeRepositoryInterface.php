<?php

namespace App\Repositories\Nominee;

use App\Repositories\CrudRepositoryInterface;

interface NomineeRepositoryInterface extends CrudRepositoryInterface
{
    public function deleteNotInArray(int $userPackageId,array $IdArray);
}