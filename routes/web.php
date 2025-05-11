<?php

use App\Http\Services\QuotationRequestService;
use App\Http\Services\QuotationService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/pdf', function () {
    $quotationService = App::make(QuotationService::class);
    $quotationRequestService = App::make(QuotationRequestService::class);
    $quotation = $quotationService->getById(25);
    $quotationRequest = $quotationRequestService->getFullDetail($quotation->quotation_request_id);
    return view('pdf.quotation-request',['quotationRequest'=>$quotationRequest]);
});
