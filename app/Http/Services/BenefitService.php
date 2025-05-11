<?php

namespace App\Http\Services;

use App\Models\Benefit;
use App\Repositories\Benefit\BenefitRepositoryInterface;

class BenefitService
{
    public function __construct(
        private BenefitRepositoryInterface $benefitRepositoryInterface,
    ) {
    }

    public function getAll(array $data){
        return $this->benefitRepositoryInterface->getAll($data);
    }
 
    public function getByPackageId(array $data){
        // return $this->benefitRepositoryInterface->getByPackageId($data);
    }
 
    public function markPayment(int $benefitId,string $reference){
        $data['paid_at'] = now();
        $data['payment_reference'] = $reference;
        return $this->benefitRepositoryInterface->update($benefitId,$data);
    }
}
