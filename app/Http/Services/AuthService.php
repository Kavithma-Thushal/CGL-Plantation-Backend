<?php

namespace App\Http\Services;

use App\Models\PasswordHistory;
use App\Enums\HttpStatus;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthService
{
    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface,
        private EmployeeBranchService $employeeBranchService,
        private UserService $userService,
    ) {}

    public function getAuthUser(): ?Authenticatable
    {
        return Auth::user();
    }

    public function login(array $data): array
    {
        $user =  $this->userRepositoryInterface->findByUsername($data['username']);
        if (!$user) throw new HttpException(HttpStatus::UNPROCESSABLE_CONTENT, 'Username or password invalid');

        // Match user password and login
        if (!Hash::check($data['password'], $user->password))
            throw new HttpException(HttpStatus::UNPROCESSABLE_CONTENT, 'Username or password invalid');

        // Create personal access token
        $token = $user->createToken('cgl')->accessToken;
        if ($token == null)
            throw new HttpException(HttpStatus::INTERNAL_SERVER_ERROR, 'User authentication failed');
        // if user not authenticated at this point it will consider as unhandled server error
        if ($user->employee) {
            $userBranches = $this->employeeBranchService->getBranchesForEmployee($user->employee->id);
        } else {
            $userBranches = [];
        }
        // returning user data array
        return ['user' => $user, 'access_token' => $token, 'branches' => $userBranches];
    }


    public function changePassword(array $data)
    {
        // Retrieve the currently authenticated user
        $user = auth()->user();

        // Verify that the provided current password matches the stored password
        if (!Hash::check($data['current_password'], $user->password)) {
            throw new HttpException(HttpStatus::UNPROCESSABLE_CONTENT, 'Current password is incorrect');
        }

        // Check if the new password has been used before
        if ($this->isPasswordUsedBefore($user->id, $data['new_password'])) {
            throw new HttpException(HttpStatus::UNPROCESSABLE_CONTENT, 'You have already used this password');
        }

        // Ensure that the new password is not the same as the current password
        if (Hash::check($data['new_password'], $user->password)) {
            throw new HttpException(HttpStatus::UNPROCESSABLE_CONTENT, 'New password cannot be the same as the current password');
        }

        // Record the current password in the password history before updating
        PasswordHistory::create([
            'user_id' => $user->id,
            'old_password' => $user->password,
        ]);

        // Update the user's password with the new hashed password
        $user->password = Hash::make($data['new_password']);
        $user->password_reset_at = now();
        $user->save();
    }

    private function isPasswordUsedBefore($userId, $newPassword)
    {
        // Retrieve all password histories for the specified user
        $passwordHistories = PasswordHistory::where('user_id', $userId)->get();

        // Check if the new password matches any of the old passwords
        foreach ($passwordHistories as $history) {
            if (Hash::check($newPassword, $history->old_password)) {
                return true;
            }
        }

        return false;
    }
}
