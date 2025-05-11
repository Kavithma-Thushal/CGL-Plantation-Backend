<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ErrorResponse;
use App\Http\Resources\BankResource;
use App\Http\Resources\RaceResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\TitleResource;
use App\Http\Resources\BranchResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\SuccessResource;
use App\Http\Services\MasterDataService;
use App\Http\Resources\NationalityResource;
use App\Http\Resources\OccupationResource;
use App\Http\Resources\TreeBrandResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MasterDataController extends Controller
{
    public function __construct(private MasterDataService $masterDataService)
    {
    }

    public function getTitles(Request $request)
    {
        try {
            $data = $this->masterDataService->getTitles($request->all());
            return new SuccessResource(['data' => TitleResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getBanks(Request $request)
    {
        try {
            $data = $this->masterDataService->getBanks($request->all());
            return new SuccessResource(['data' => BankResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getBranches(Request $request)
    {
        try {
            $data = $this->masterDataService->getBranches($request->all());
            return new SuccessResource(['data' => BranchResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getRoles(Request $request)
    {
        try {
            $filters = $request->all();
            $filters['status'] = 1;
            $data = $this->masterDataService->getRoles($filters);
            return new SuccessResource(['data' => RoleResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getRaces(Request $request)
    {
        try {
            $data = $this->masterDataService->getRaces($request->all());
            return new SuccessResource(['data' => RaceResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getNationalities(Request $request)
    {
        try {
            $data = $this->masterDataService->getNationalities($request->all());
            return new SuccessResource(['data' => NationalityResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getOccupations(Request $request)
    {
        try {
            $data = $this->masterDataService->getOccupations($request->all());
            return new SuccessResource(['data' => OccupationResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
  
    public function getCountries(Request $request)
    {
        try {
            $data = $this->masterDataService->getCountries($request->all());
            return new SuccessResource(['data' => CountryResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
  
    public function getTreeBrands(Request $request)
    {
        try {
            $data = $this->masterDataService->getTreeBrands($request->all());
            return new SuccessResource(['data' => TreeBrandResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
}
