<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\CrudRepository;

class UserRepository extends CrudRepository implements UserRepositoryInterface
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByUsername(string $username): ?User
    {
        return User::where('username',$username)->first();
    }

    public function findById($id): ?User
    {
        return User::where('id',$id)->first();
    }

    public function findByNIC(string $nic): ?User
    {
        return User::where('nic',$nic)->first();
    }
}
