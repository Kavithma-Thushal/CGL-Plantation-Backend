<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ErrorResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Services\EmployeeService;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\EmployeeAddRequest;
use App\Http\Requests\EmployeeGetRequest;
use App\Http\Requests\EmployeeDeleteRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Imports\EmployeeImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeService $employeeService)
    {
    }

    public function add(EmployeeAddRequest $request)
    {
        try {
            $data = $this->employeeService->add($request->validated());
            return new SuccessResource([
                'message' => 'Employee created',
                'data' => new EmployeeResource($data)
            ]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getAll(EmployeeGetRequest $request)
    {
        try {
            $data = $this->employeeService->getAll($request->validated());
            return new SuccessResource(['data' => EmployeeResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function update(int $id, EmployeeUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->employeeService->update($id, $request->validated());
            DB::commit();
            return new SuccessResource(['data' => ['message' => 'Employee updated']]);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }


    public function getByNIC($nic, Request $request)
    {
        try {
            $data = $this->employeeService->getByNIC($nic);
            return new SuccessResource(['data' => new EmployeeResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }


    public function getById(int $id)
    {
        try {
            $data = $this->employeeService->getById($id);
            return new SuccessResource(['data' => new EmployeeResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function delete(EmployeeDeleteRequest $request)
    {
        try {
            $this->employeeService->delete($request->id);
            return new SuccessResource(['message' => 'Employee deleted']);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function bulkImport(Request $request) {

        $validator = Validator::make($request->all(), [
            'file' => ['required'],
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        try {
            Excel::import(new EmployeeImport(), $request->file('file'));

            return response()->json(['message' => 'Employees imported successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to import employees', 'details' => $e->getMessage()], 500);
        }
    }
}
