<?php

namespace App\Http\Services;

use App\Enums\HttpStatus;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface,
        private PersonalDetailService $personalDetailService,
        private RoleService $roleService
    ) {}

    public function getUser()
    {
        try {
            return auth()->user();
        } catch (HttpException $e) {
            throw new HttpException(HttpStatus::UNPROCESSABLE_CONTENT, $e->getMessage());
        }
    }


    public function add(array $data): User
    {
        $data = $this->formatCredentialsOnAdd($data);
        $userData = [
            'username' => str_replace(' ', '', $data['mobile_number']),
            'password' => Hash::make(str_replace(' ', '', $data['nic'])),
            'avatar_media_id' => $data['media_id'] ?? null,
            'nic' => $data['nic'],
            'dob' => $data['dob'],
            'has_system_access' => $data['has_system_access'] ?? 0
        ];
        $user =  $this->userRepositoryInterface->add($userData);
        $this->personalDetailService->add($user->id, User::class, $data);
        Log::info($data);
        if ((isset($data['has_system_access']) && $data['has_system_access']) || isset($data['user_role_id'])) {
            $this->roleService->sync($user->id, $data['user_role_id']);
        }
        return $user;
    }

    private function formatCredentialsOnAdd(array $data): array
    {
        if (!isset($data['has_system_access']) || !$data['has_system_access']) {
            $data['username'] = $data['first_name'] . '_' . uniqid();
            $data['password'] = $data['mobile_number'] . '_' . uniqid();
        }
        return $data;
    }

    // private function formatCredentialsOnUpdate(int $userId, array $data): array
    // {
    //     $user = $this->userRepositoryInterface->find($userId);
    //     if (!$data['has_system_access']) {
    //         $data['username'] = isset($data['username']) ? $data['username'] : $user['username'];
    //     }
    //     return $data;
    // }


    public function update(int $userId, array $data): void
    {

        // Fetch the user to check the password_reset_at field
        $user = $this->userRepositoryInterface->find($userId);

        // $data = $this->formatCredentialsOnUpdate($userId,$data);
        $userData = [
            // 'username' => strtolower($data['mobile_number']),
            'avatar_media_id' => $data['media_id'] ?? null,
            'nic' => $data['nic'],
            'dob' => $data['dob'],
            'has_system_access' => $data['has_system_access']
        ];
        // if(isset($data['password'])){
        //     $userData['password'] = Hash::make($data['password']);
        // }

        // If password_reset_at is null, set password to match nic
        if ($user->password_reset_at === null) {
            $userData['password'] = Hash::make($data['nic']);
        }

        $this->userRepositoryInterface->update($userId,$userData);
        $this->personalDetailService->add($userId, User::class, $data);
        if ($data['has_system_access']) {
            $this->roleService->sync($userId, $data['user_role_id']);
        }
    }

    public function updateProfile(array $data)
    {
        try {
            $user = auth()->user();
            $existingUser = $this->userRepositoryInterface->findByUsername($data['username']);

            if ($existingUser && $existingUser->id !== $user->id) {
                throw new HttpException(HttpStatus::UNPROCESSABLE_CONTENT, 'The username has already been taken.');
            }
            $userData = ['username' => $data['username']];
            if (!empty($data['media_id'])) {
                $userData['avatar_media_id'] = $data['media_id'];
            }
            $this->userRepositoryInterface->update($user->id, $userData);
            return $user;
        } catch (HttpException $e) {
            throw new HttpException(HttpStatus::UNPROCESSABLE_CONTENT, $e->getMessage());
        }
    }
}
