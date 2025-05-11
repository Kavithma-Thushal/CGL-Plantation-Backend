<?php

namespace App\Http\Services;

use App\Models\PackageTimeline;
use App\Enums\PackageStatusesEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Repositories\PackageStatus\PackageStatusRepositoryInterface;
use App\Repositories\PackageTimeline\PackageTimelineRepositoryInterface;
use Illuminate\Support\Facades\App;

class PackageTimelineService
{
    public function __construct(
        private PackageTimelineRepositoryInterface $packageTimelineRepositoryInterface,
        private PackageStatusRepositoryInterface $packageStatusRepositoryInterface,
    ) {
    }

    public function add(int $userPackageId, string $statusText, int $userId): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($userPackageId, $statusText, $userId);
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function addInitialRecords(int $userPackageId): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::PROPOSAL_CREATED, Auth::id());
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::SUBMITTED_FOR_SUPERVISOR, Auth::id());
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function supervisorApprove(int $userPackageId): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::SUPERVISOR_APPROVED, Auth::id());
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::DOCUMENT_VERIFICATION, Auth::id());
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    public function agreementPrint(int $userPackageId): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::AGREEMENT_PRINT, Auth::id());
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }
   
    public function readyToSign(int $userPackageId): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::READY_TO_SIGN, Auth::id());
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function supervisorReject(int $userPackageId, string $reason): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::SUPERVISOR_REJECTED, Auth::id(), $reason);
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }
   
    public function readyToSupervisorApproval(int $userPackageId): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::SUBMITTED_FOR_SUPERVISOR, Auth::id());
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }
  
    public function readyToDocumentVerify(int $userPackageId): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::DOCUMENT_VERIFICATION, Auth::id());
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function verifyDocuments(int $userPackageId): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::DOCUMENT_VERIFIED, Auth::id());
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    public function rejectDocuments(int $userPackageId, string $reason): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::DOCUMENT_REJECTED, Auth::id(), $reason);
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function markSigned(int $userPackageId): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::SIGNED, Auth::id());
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }
 
    public function markStarted(int $userPackageId): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($userPackageId, PackageStatusesEnum::STARTED, Auth::id());
            $userPackageService = App::make(UserPackageService::class);
            $userPackageService->updatePaymentTerm($userPackageId);
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function matured(array $data): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($data['proposal_id'], PackageStatusesEnum::MATURED, Auth::id());
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }
   
    public function cancel(array $data): PackageTimeline
    {
        DB::beginTransaction();
        try {
            $record = $this->addNewTimelineRecord($data['proposal_id'], PackageStatusesEnum::CANCELLED, Auth::id());
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function addNewTimelineRecord($userPackageId, $statusName, $userId, $reason = null)
    {
        $this->packageTimelineRepositoryInterface->deactivateOldRecords($userPackageId);
        $timelineData = [
            'user_package_id' => $userPackageId,
            'package_status_id' => $this->packageStatusRepositoryInterface->getIdByName($statusName),
            'created_user_id' =>  $userId,
            'reason' =>  $reason,
            'status' =>  1
        ];
        return $this->packageTimelineRepositoryInterface->add($timelineData);
    }
   
    public function getByPackageId($userPackageId)
    {
        $data['user_package_id'] = $userPackageId;
        return $this->packageTimelineRepositoryInterface->getAll($data,['packageStatus'],['created_at'=>'desc']);
    }
}
