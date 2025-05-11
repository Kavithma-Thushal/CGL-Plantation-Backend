<?php

namespace App\Http\Services;

use App\Models\Nominee;
use App\Models\Introducer;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\DB;
use App\Repositories\Nominee\NomineeRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Repositories\Introducer\IntroducerRepositoryInterface;
use App\Repositories\Beneficiary\BeneficiaryRepositoryInterface;

class StakeholderService
{
    public function __construct(
        private PersonalDetailService $personalDetailService,
        private BeneficiaryRepositoryInterface $beneficiaryRepositoryInterface,
        private NomineeRepositoryInterface $nomineeRepositoryInterface,
        private IntroducerRepositoryInterface $introducerRepositoryInterface
    ) {
    }

    public function addBeneficiary(int $userPackageId, array $data)
    {
        DB::beginTransaction();
        try {
            $userPackageKeys = [
                'user_package_id' => $userPackageId,
            ];

            $userPackageData = [
                'bank_account_id' => $data['bank_account_id'] ?? null,
                'nic' => $data['nic'] ?? null,
                'relationship' => isset($data['beneficiary']['relationship']) ? $data['beneficiary']['relationship'] : null,
            ];

            $record = $this->beneficiaryRepositoryInterface->updateOrCreate($userPackageKeys, $userPackageData);
            $this->addPersonalData($record->id, $data['beneficiary'], Beneficiary::class);

            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function addNominees(int $userPackageId, array $data)
    {
        DB::beginTransaction();
        try {
            $idArray = array_column($data['nominees'], 'id');
            $this->nomineeRepositoryInterface->deleteNotInArray($userPackageId, $idArray);
            foreach ($data['nominees'] as $nominee) {
                $userPackageData = [
                    'user_package_id'=>$userPackageId,
                    'percentage' => $nominee['percentage'] ?? null,
                    'nic' => $nominee['nic'] ?? null,
                    'relationship' => $nominee['relationship'] ?? null
                ];

                $record = $this->nomineeRepositoryInterface->add($userPackageData);
                $this->addPersonalData($record->id, $nominee, Nominee::class);
            }
            DB::commit();
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateOrCreateIntroducer(int $userPackageId, array $data)
    {
        DB::beginTransaction();
        try {
            $userPackageKeys = [
                'user_package_id' => $userPackageId,
            ];

            $introducerData = [
                'nic' => isset($data['introducer']['nic']) ? $data['introducer']['nic'] : null,
                'relationship' => isset($data['introducer']['relationship']) ? $data['introducer']['relationship'] : null,
                'reason' => isset($data['introducer']['reason']) ? $data['introducer']['reason'] : null,
            ];

            $record = $this->introducerRepositoryInterface->updateOrCreate($userPackageKeys, $introducerData);
            $this->addPersonalData($record->id, $data['introducer'], Introducer::class);
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /* store personal details in polymorphic table */
    private function addPersonalData($recordId, $data, $model)
    {
        $personalData = [
            'title_id' => $data['title_id'] ?? null,
            'name_with_initials' => $data['name_with_initials'] ?? null,
            'family_name' => $data['family_name'] ?? null,
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
        ];
        $this->personalDetailService->add($recordId, $model, $personalData);
    }
}
