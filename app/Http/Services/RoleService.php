<?php

namespace App\Http\Services;

use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class RoleService
{
    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface,
        private RoleRepositoryInterface $roleRepositoryInterface
    ) {
    }

    public function sync(int $userId, int $roleId)
    {
        Log::info('role sync',[$userId,$roleId]);
        $role = $this->roleRepositoryInterface->find($roleId);
        $user = $this->userRepositoryInterface->find($userId);
        Log::info('role get',[$role,$role]);
        $user->syncRoles([$role->name]);
    }
}
