<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ErrorResponse;
use App\Http\Resources\SuccessResource;
use App\Http\Services\AdministrativeLevelService;
use App\Http\Resources\AdministrativeLevelResource;
use App\Http\Requests\AdministrativeLevelAddRequest;
use App\Http\Requests\AdministrativeLevelDeleteRequest;
use App\Http\Requests\AdministrativeLevelUpdateRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdministrativeLevelController extends Controller
{
    public function __construct(private AdministrativeLevelService $administrativeLevelService)
    {
    }

    public function getAll(Request $request)
    {
        try {
            $data = $this->administrativeLevelService->getAll($request->all());
            return new SuccessResource(['data' => AdministrativeLevelResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getById(int $id)
    {
        try {
            $data = $this->administrativeLevelService->find($id);
            return new SuccessResource(['data' => new AdministrativeLevelResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function add(AdministrativeLevelAddRequest $request)
    {
        try {
            $data = $this->administrativeLevelService->add($request->validated());
            return new SuccessResource([
                'message' => 'Administrative level created',
                'data' => new AdministrativeLevelResource($data)
            ]);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function update(int $id, AdministrativeLevelUpdateRequest $request)
    {
        try {
            $this->administrativeLevelService->update($id, $request->validated());
            return new SuccessResource(['message' => 'Administrative level update']);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function delete(AdministrativeLevelDeleteRequest $request)
    {
        try {
            $this->administrativeLevelService->delete($request->id);
            return new SuccessResource(['message' => 'Administrative level deleted']);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }
}
