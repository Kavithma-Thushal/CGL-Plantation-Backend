<?php

namespace App\Http\Services;

use App\Classes\ErrorResponse;
use App\Models\UserPackage;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserPackage\UserPackageRepositoryInterface;
use App\Repositories\PackageMedia\PackageMediaRepositoryInterface;

class PackageMediaService
{
    public function __construct(
        private PackageMediaRepositoryInterface $packageMediaRepositoryInterface,
        private UserPackageRepositoryInterface $userPackageRepositoryInterface,
    ) {
    }

    public function updateOrCreate(array $data): UserPackage
    {
        
        DB::beginTransaction();
        try {
            $this->packageMediaRepositoryInterface->updateOrCreate(['user_package_id' => $data['user_package_id'],'type'=>$data['type']], ['media_id'=>$data['media_id']]);
            $data = $this->getByPackageId($data['user_package_id']);
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function getByPackageId(int $packageId): UserPackage
    {
        return $this->userPackageRepositoryInterface->find($packageId, ['packageMedia']);
    }
  
    public function delete(int $packageMediaId) : void
    {
        $this->packageMediaRepositoryInterface->delete($packageMediaId);
    }
}
