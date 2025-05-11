<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ErrorResponse;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\ProposalResource;
use App\Http\Services\UserPackageService;
use App\Http\Requests\ProposalCreateRequest;
use App\Http\Requests\ProposalUpdateRequest;
use App\Http\Resources\AgentProposalResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\PaymentPendingPackageResource;
use App\Http\Resources\ProposalGetAllResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserPackageController extends Controller
{
    public function __construct(private UserPackageService $userPackageService)
    {
    }

    public function getAll(Request $request)
    {
        try {
            $data = $this->userPackageService->getAll($request->all());
            return new SuccessResource(['data' => ProposalGetAllResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
   
    public function getPaginate(Request $request)
    {
        try {
            $data = $this->userPackageService->getPaginate($request->all());
            return new SuccessResource(['data' => ProposalGetAllResource::collection($data),'pagination' => new PaginationResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function add(ProposalCreateRequest $request)
    {
        try {
            $data =  $this->userPackageService->add($request->validated());
            return new SuccessResource(['data' => new ProposalResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function update(int $id, ProposalUpdateRequest $request)
    {
        try {
            $this->userPackageService->update($id, $request->validated());
            return new SuccessResource(['message' => 'Package updated']);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getById(int  $id, Request $request)
    {
        try {
            $data = $this->userPackageService->getById($id);
            return new SuccessResource(['data' => new ProposalResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getAgentProposals(Request $request)
    {
        try {
            $data = $this->userPackageService->getAgent();
            return new SuccessResource(['data' => AgentProposalResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getSupervisorProposals(Request $request)
    {
        try {
            $data = $this->userPackageService->getSupervisor();
            return new SuccessResource(['data' => AgentProposalResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getPaymentPending(Request $request)
    {
        try {
            $data = $this->userPackageService->getPaymentPending();
            return new SuccessResource(['data' => PaymentPendingPackageResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function delete($id, Request $request)
    {
        try {
            $this->userPackageService->delete($id);
            return new SuccessResource(['message' => 'Proposal deleted']);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
}
