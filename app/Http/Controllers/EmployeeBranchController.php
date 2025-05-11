<?php

namespace App\Http\Controllers;

use App\Classes\ErrorResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Services\EmployeeService;
use App\Http\Resources\SuccessResource;
use App\Http\Requests\ChangeCurrentBranchRequest;
use App\Http\Resources\AuthUserBranchesResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EmployeeBranchController extends Controller
{
    public function __construct(private EmployeeService $employeeService)
    {
    }

    public function update(ChangeCurrentBranchRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->employeeService->changeAuthUserCurrentBranch($request['id']);
            DB::commit();
            return new SuccessResource(['data' => AuthUserBranchesResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }
}
