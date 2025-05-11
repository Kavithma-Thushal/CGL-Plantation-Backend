<?php

namespace App\Http\Controllers;

use App\Classes\ErrorResponse;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{

    public function __construct(
        private UserService $userService,
    ) {}

    public function getUser() {
        try {
            $data = $this->userService->getUser();
            return new SuccessResource(['data' => new UserResource($data)]);
        } catch (HttpException $e) {
            return ErrorResponse::throwException($e);
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $this->userService->updateProfile($request->validated());
            return new SuccessResource(['message' => 'Profile updated']);
        } catch (HttpException $e) {
            return ErrorResponse::throwException($e);
        }
    }



}
