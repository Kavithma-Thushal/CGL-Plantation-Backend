<?php

namespace App\Http\Services;

use App\Classes\CodeGenerator;
use App\Classes\ErrorResponse;
use App\Repositories\Plan\PlanRepositoryInterface;
use App\Repositories\PlanBenefitRate\PlanBenefitRateRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PlanService
{
    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private PlanBenefitRateRepositoryInterface $planBenefitRateRepositoryInterface
    ) {
    }

    public function find(int $id): ?object
    {
        return $this->planRepository->find($id, ['planBenefitRates', 'planTemplate']);
    }

    public function getAll(array $filters): object
    {
        return $this->planRepository->getAll($filters);
    }

    public function add(array $data)
    {
        DB::beginTransaction();
        try {
            $data['interest_rates'] = isset($data['interest_rates']) && !empty($data['interest_rates']) ? $data['interest_rates']: [];
            $planData = [
                'plan_template_id'=>$data['plan_template_id'],
                'name'=>$data['name'],
                'duration'=>$data['duration'],
                'minimum_amount'=> round($data['minimum_amount'],2),
                'description'=>$data['description'] ?? null,
                'profit_per_month'=>$data['profit_per_month'] ?? null,
                'benefit_per_month'=>$data['benefit_per_month'] ?? null
            ];
            $planData['code'] = $this->createUniqueCode($data['name']);
            $plan = $this->planRepository->add($planData);
            foreach ($data['interest_rates'] as $interestRate) {
                $interestRate['plan_id'] = $plan['id'];
                $this->planBenefitRateRepositoryInterface->add($interestRate);
            }
            DB::commit();
            return $plan;
        } catch (\Exception $e) {
            ErrorResponse::rollback($e);
        }
    }

    public function update(int $id, array $data)
    {
        $data['minimum_amount'] = round($data['minimum_amount'],2);
        return $this->planRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $this->planBenefitRateRepositoryInterface->deleteByPlanId($id);
        return $this->planRepository->delete($id);
    }

    public function hasChildren(int $id): bool
    {
        $obj = $this->planRepository->find($id);
        return $obj->children()->exists();
    }

    public function isIdExist(int $id)
    {
        return $this->planRepository->isIdExist($id);
    }

    public function createUniqueCode($name, $attempt = 0)
    {
        $code = CodeGenerator::getUniqueCharacter(3);

        $plan =  $this->planRepository->getByCode($code);
        if ($plan != null) {
            $code = $this->createUniqueCode($name, $attempt + 1);
        }
        return $code;
    }
}
