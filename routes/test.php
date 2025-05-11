<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;


Route::get('/', [TestController::class, 'index']);
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/auth-user', [TestController::class, 'authUser']);
});

Route::get('/pdf/{id}', [TestController::class, 'testPDF']);
Route::get('/schedule/{id}', [TestController::class, 'testSchedule']);
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('', [TestController::class, 'getAll']);
    Route::get('package-timeline/{package_id}', [TestController::class, 'packageTimeline']);
    Route::get('start-all-packages', [TestController::class, 'startAllPackages']);
    Route::post('create-multiple-packages', [TestController::class, 'createMultiplePackages']);
    Route::get('', [TestController::class, 'save']);
    Route::patch('/{id}', [TestController::class, 'update']);
    Route::delete('/{id}', [TestController::class, 'delete']);
    Route::get('/{id}', [TestController::class, 'getById']);
});