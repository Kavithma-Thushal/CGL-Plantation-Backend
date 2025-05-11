<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ErrorResponse;
use App\Http\Requests\GetPaymentsByPackage;
use App\Http\Requests\PaymentFindRequest;
use App\Http\Services\ReceiptService;
use App\Http\Resources\ReceiptResource;
use App\Http\Resources\SuccessResource;
use App\Http\Requests\PaymentStoreRequest;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PaymentController extends Controller
{
    public function __construct(private ReceiptService $receiptService)
    {
    }

    public function getAll(Request $request)
    {
        try {
            $data = $this->receiptService->getAll($request->all());
            return new SuccessResource(['data' => ReceiptResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getByPackageId($packageId,GetPaymentsByPackage $request)
    {
        try {
            $data = $this->receiptService->getByPackageId($packageId);
            return new SuccessResource(['data' => ReceiptResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function add(PaymentStoreRequest $request)
    {
        try {
            $data = $this->receiptService->add($request->validated());

            // Log::info($request->download_receipt);
            if ($request->download_receipt) {
                $pdf = App::make(PDF::class);
                $pdf->loadView('pdf.receipt', ['receiptRequest' => $data]);
                return $pdf->download('receipt.pdf');
                // Return the PDF as a download
                // return response()->streamDownload(function () use ($pdf) {
                //     // echo $pdf->output();
                // }, 'receipt.pdf');
            }
            return new SuccessResource([
                'message' => 'Receipt created',
                'data' => new ReceiptResource($data)
            ]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getPDF(int $id,PaymentFindRequest $request)
    {
        try {
            $receipt = $this->receiptService->find($id);
            $pdf = App::make(PDF::class);
            $pdf->loadView('pdf.receipt', ['receipt' => $receipt]);
            return $pdf->download('receipt.pdf');
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
}
