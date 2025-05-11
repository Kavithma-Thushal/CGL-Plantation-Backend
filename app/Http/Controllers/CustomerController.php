<?php

namespace App\Http\Controllers;

use App\Classes\ErrorResponse;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\CustomerResource;
use App\Http\Services\CustomerService;
use App\Http\Requests\CustomerGetRequest;
use App\Http\Requests\CustomerUpdateRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CustomerController extends Controller
{
    private CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function getAll(CustomerGetRequest $request)
    {
        try {
            $data = $this->customerService->getAll($request->validated());
            return new SuccessResource(['data' => CustomerResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getById(int $id)
    {
        try {
            $data = $this->customerService->find($id);
            return new SuccessResource(['data' => new CustomerResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function update($customerId,CustomerUpdateRequest $request){
        try {
            $data = $this->customerService->update($customerId,$request->validated());
            return new SuccessResource(['message' => 'Status updated']);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
}
