<?php

namespace App\Http\Controllers;

use App\Classes\ErrorResponse;
use App\Http\Requests\BenefitRequest;
use App\Http\Services\BenefitService;
use App\Http\Resources\BenefitResource;
use App\Http\Resources\SuccessResource;
use App\Http\Requests\GetBenefitsByPackage;
use App\Http\Requests\BenefitPaymentRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BenefitController extends Controller
{
    public function __construct(private BenefitService $benefitService)
    {
    }

    public function getAll(BenefitRequest $request)
    {
        try {
            $data = $this->benefitService->getAll($request->all());
            return new SuccessResource(['data' => BenefitResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
    
    public function markPayment(BenefitPaymentRequest $request)
    {
        try {
            $this->benefitService->markPayment($request['benefit_id'], $request['reference']);
            return new SuccessResource(['data' => ['message' => 'Marked as paid']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
}
