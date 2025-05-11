<?php

namespace App\Http\Controllers;

use App\Classes\ErrorResponse;
use App\Http\Requests\PackageMediaDeleteRequest;
use App\Http\Requests\PackageMediaGetPackageIdRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Requests\PackageMediaRequest;
use App\Http\Services\PackageMediaService;
use App\Http\Resources\PackageMediaResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PackageMediaController extends Controller
{
    public function __construct(
        private PackageMediaService $packageMediaService
    ) {
    }

    public function updateOrCreate(PackageMediaRequest $request)
    {
        try {
            $data = $this->packageMediaService->updateOrCreate($request->validated());
            return new SuccessResource(['data' => new PackageMediaResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getByPackageId($packageId,PackageMediaGetPackageIdRequest $request)
    {
        try {
            $data = $this->packageMediaService->getByPackageId($packageId);
            return new SuccessResource(['data' => new PackageMediaResource($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
   
    public function destroy($packageMediaId,PackageMediaDeleteRequest $request)
    {
        try {
            $this->packageMediaService->delete($packageMediaId);
            return new SuccessResource(['data' => 'Deleted']);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
}
