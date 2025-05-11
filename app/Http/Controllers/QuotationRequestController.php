<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use App\Classes\ErrorResponse;
use App\Http\Requests\QuotationRequestFindRequest;
use App\Http\Resources\QuotationRequestResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Support\Facades\App;
use App\Http\Services\QuotationRequestService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QuotationRequestController extends Controller
{
    public function __construct(private QuotationRequestService $quotationRequestService) {}

    public function getById(int $id, QuotationRequestFindRequest $request)
    {
        try {
            $quotationRequest = $this->quotationRequestService->getById($id);
            $pdf = App::make(PDF::class);
            $pdf->loadView('pdf.quotation-request', ['quotationRequest' => $quotationRequest]);
            return $pdf->download('quotation.pdf');
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $data = $this->quotationRequestService->getAll($request->all());
            return new SuccessResource(['data' => QuotationRequestResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getPDF(int $id, QuotationRequestFindRequest $request)
    {
        try {
            $quotationRequest = $this->quotationRequestService->getFullDetail($id);
            $pdf = App::make(PDF::class);
            $pdf->loadView('pdf.quotation-request', ['quotationRequest' => $quotationRequest]);
            return $pdf->download('quotation.pdf');
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
}
