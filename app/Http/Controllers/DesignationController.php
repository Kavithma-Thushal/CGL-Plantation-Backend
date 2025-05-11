<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ErrorResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\SuccessResource;
use App\Http\Services\DesignationService;
use App\Http\Resources\DesignationResource;
use App\Http\Requests\DesignationAddRequest;
use App\Http\Requests\DesignationDeleteRequest;
use App\Http\Requests\DesignationUpdateRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DesignationController extends Controller
{
    public function __construct(private DesignationService $designationService)
    {
    }

    public function getTree()
    {
        try {
            $data = $this->designationService->getTree();
            return new SuccessResource(['data' => $data]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $data = $this->designationService->getAll($request->all());
            return new SuccessResource(['data' => DesignationResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getById(int $id)
    {
        try {
            $data = $this->designationService->find($id);
            return new SuccessResource(['data' => new DesignationResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function add(DesignationAddRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->designationService->add($request->validated());
            DB::commit();
            return new SuccessResource([
                'message' => 'Designation created',
                'data' =>new DesignationResource($data)
            ]);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function update(int $id, DesignationUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->designationService->update($id, $request->validated());
            DB::commit();
            return new SuccessResource(['data' => ['message' => 'Designation updated']]);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function delete(int $id, DesignationDeleteRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->designationService->delete($id);
            DB::commit();
            return new SuccessResource(['data' => ['message' => 'Designation deleted']]);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }
}
