<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ErrorResponse;
use App\Http\Resources\SuccessResource;
use App\Http\Services\AdministrativeHierarchyService;
use App\Http\Resources\AdministrativeHierarchyResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Requests\AdministrativeHierarchyStoreRequest;
use App\Http\Requests\AdministrativeHierarchyDeleteRequest;
use App\Http\Requests\AdministrativeHierarchyUpdateRequest;

class AdministrativeHierarchyController extends Controller
{
    public function __construct(private AdministrativeHierarchyService $administrativeHierarchyService)
    {
    }

    public function getAll(Request $request)
    {
        try {
            $data = $this->administrativeHierarchyService->getAll($request->all());
            return new SuccessResource(['data' => AdministrativeHierarchyResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getById(int $id)
    {
        try {
            $data = $this->administrativeHierarchyService->find($id);
            return new SuccessResource(['data' => new AdministrativeHierarchyResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function add(AdministrativeHierarchyStoreRequest $request)
    {
        try {
            $this->administrativeHierarchyService->add($request->validated());
            return new SuccessResource(['message' => 'Administrative hierarchy created']);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function update(int $id, AdministrativeHierarchyUpdateRequest $request)
    {
        try {
            $this->administrativeHierarchyService->update($id, $request->validated());
            return new SuccessResource(['message' => 'Administrative hierarchy updated']);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function delete(AdministrativeHierarchyDeleteRequest $request)
    {
        try {
            $this->administrativeHierarchyService->delete($request->id);
            return new SuccessResource(['message' => 'Administrative hierarchy deleted']);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }
}
