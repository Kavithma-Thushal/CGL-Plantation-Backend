<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ErrorResponse;
use App\Http\Services\PlanService;
use App\Http\Resources\PlanResource;
use App\Http\Requests\PlanAddRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Requests\PlanDeleteRequest;
use App\Http\Requests\PlanUpdateRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PlanController extends Controller
{
    public function __construct(private PlanService $planService)
    {
    }

    public function getAll(Request $request)
    {
        try {
            $data = $this->planService->getAll($request->all());
            return new SuccessResource(['data' => PlanResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getById(int $id)
    {
        try {
            $data = $this->planService->find($id);
            return new SuccessResource(['data' => new PlanResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function add(PlanAddRequest $request)
    {
        try {
            $data = $this->planService->add($request->validated());
            return new SuccessResource([
                'message' => 'Plan created',
                'data' => new PlanResource($data)
            ]);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function update(int $id, PlanUpdateRequest $request)
    {
        try {
            $this->planService->update($id, $request->validated());
            return new SuccessResource(['message' => 'Plan updated']);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function delete(PlanDeleteRequest $request)
    {
        try {
            $this->planService->delete($request->id);
            return new SuccessResource(['message' => 'Plan deleted']);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }
}
