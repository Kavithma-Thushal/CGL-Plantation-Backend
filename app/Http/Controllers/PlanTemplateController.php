<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ErrorResponse;
use App\Http\Resources\SuccessResource;
use App\Http\Services\PlanTemplateService;
use App\Http\Resources\PlanTemplateResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Requests\AdministrativeHierarchyStoreRequest;

class PlanTemplateController extends Controller
{
    public function __construct(private PlanTemplateService $planTemplateService)
    {
    }

    public function getAll(Request $request)
    {
        try {
            $data = $this->planTemplateService->getAll($request->all());
            return new SuccessResource(['data' => PlanTemplateResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getById(int $id)
    {
        try {
            $data = $this->planTemplateService->find($id);
            return new SuccessResource(['data' => new PlanTemplateResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function add(AdministrativeHierarchyStoreRequest $request)
    {
        try {
            $this->planTemplateService->add($request->validated());
            return new SuccessResource(['message' => 'Plan template created']);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function update(int $id, AdministrativeHierarchyStoreRequest $request)
    {
        try {
            $this->planTemplateService->update($id, $request->validated());
            return new SuccessResource(['message' => 'Plan template updated']);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function delete(int $id)
    {
        try {
            $this->planTemplateService->delete($id);
            return new SuccessResource(['message' => 'Plan template deleted']);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }
}
