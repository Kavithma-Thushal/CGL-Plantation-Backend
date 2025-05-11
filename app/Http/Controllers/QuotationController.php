<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Classes\ErrorResponse;
use Illuminate\Support\Facades\App;
use App\Http\Resources\SuccessResource;
use App\Http\Services\QuotationService;
use App\Http\Resources\QuotationResource;
use App\Http\Requests\QuotationAddRequest;
use App\Http\Requests\QuotationFindRequest;
use App\Http\Services\QuotationRequestService;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QuotationController extends Controller
{
    public function __construct(private QuotationService $quotationService, private QuotationRequestService $quotationRequestService) {}

    public function getAll(Request $request)
    {
        try {
            $data = $this->quotationService->getAll($request->all());
            return new SuccessResource(['data' => QuotationResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function add(QuotationAddRequest $request)
    {
        try {
            $quotationRequest = $this->quotationService->add($request->validated());
            $pdf = App::make(PDF::class);
            $pdf->loadView('pdf.quotation-request', ['quotationRequest' => $quotationRequest]);
            return $pdf->download('quotation.pdf');
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getById(int  $id, QuotationFindRequest $request)
    {
        try {
            $data = $this->quotationService->getById($id);
            return new SuccessResource(['data' => new QuotationResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getPDF(int $id, QuotationFindRequest $request)
    {
        try {
            $quotation = $this->quotationService->getById($id);
            $quotationRequest = $this->quotationRequestService->getFullDetail($quotation->quotation_request_id);
            $pdf = App::make(PDF::class);
            $pdf->loadView('pdf.quotation-request', ['quotationRequest' => $quotationRequest]);
            return $pdf->download('quotation.pdf');
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
}
