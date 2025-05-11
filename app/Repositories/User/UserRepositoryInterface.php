<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\CrudRepositoryInterface;

interface UserRepositoryInterface extends CrudRepositoryInterface
{
    public function findById($id): ?User;

    public function findByUsername(string $username): ?User;

    public function findByNIC(string $username): ?User;
}
