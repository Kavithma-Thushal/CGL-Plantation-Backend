<?php

namespace App\Http\Services;

use App\Classes\CodeGenerator;
use Carbon\Carbon;
use App\Models\Quotation;
use App\Models\QuotationRequest;
use App\Repositories\Plan\PlanRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Repositories\Quotation\QuotationRepositoryInterface;
use App\Repositories\QuotationRequest\QuotationRequestRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class QuotationService
{
    public function __construct(
        private QuotationRequestRepositoryInterface $quotationRequestRepositoryInterface,
        private QuotationRepositoryInterface $quotationRepositoryInterface,
        private QuotationRequestService $quotationRequestService,
        private PlanRepositoryInterface $planRepositoryInterface,
        private EmployeeService $employeeService,
    ) {
    }

    public function getAll(array $filters)
    {
        return $this->quotationRepositoryInterface->getAll($filters);
    }

    public function getById(int $id)
    {
        return $this->quotationRepositoryInterface->find($id);
    }

    public function add(array $data): QuotationRequest
    {
        $employeeId = $data['agent_id'];
        $agent = $this->employeeService->getById($employeeId);

        DB::beginTransaction();
        try {
            $quotationRequestData = [
                'nic' => $data['nic'],
                'title_id' => $data['title_id'] ?? null,
                'first_name' => $data['first_name'],
                'name_with_initials' => $data['name_with_initials'] ?? null,
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'] ?? null,
                'mobile_number' => $data['mobile_number'],
                'email' => $data['email'] ?? null,
                'landline_number' => $data['landline_number'] ?? null,
                'address' => $data['address'] ?? null,
                'agent_id' => $employeeId ?? null,
                'employee_branch_id' => $agent->current_employee_branch_id ?? null,
            ];

            $quotationRequest = $this->quotationRequestRepositoryInterface->add($quotationRequestData);
            $expirationPeriod = config('common.quotation_expiration_period', 14); // Default to 14 days if not set
            $expireDate = Carbon::now()->addDays($expirationPeriod);

            foreach ($data['plans'] as $index => $plan) {
                $selectedPlan = $this->planRepositoryInterface->find($plan['plan_id']);
                $quotation = [
                    'quotation_request_id' => $quotationRequest->id,
                    'plan_id' => $plan['plan_id'],
                    'amount' => $plan['amount'],
                    'duration' =>  $plan['duration'] ?? $selectedPlan->duration, // default 1 year
                    'expire_date' => $data['expire_date'] ?? $expireDate->toDateString(),
                    'number_of_trees' => $plan['number_of_trees'] ?? null,
                    'land_size' => $plan['land_size'] ?? null,
                ];
                $quotation = $this->quotationRepositoryInterface->add($quotation);
                $this->quotationRepositoryInterface->update($quotation->id, ['quotation_number' => CodeGenerator::generateQuotationNumber($quotation->id)]);
            }
            $quotationRequest = $this->quotationRequestService->getFullDetail($quotationRequest->id, ['quotations']);
            DB::commit();
            return $quotationRequest;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
