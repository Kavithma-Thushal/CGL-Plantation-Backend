<?php

namespace App\Http\Services;

use App\Classes\TextConverter;
use App\Models\Plan;
use App\Models\PlanTemplate;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\QuotationRequest\QuotationRequestRepositoryInterface;

class QuotationRequestService
{
    public function __construct(
        private QuotationRequestRepositoryInterface $quotationRequestRepositoryInterface,
        private EmployeeService $employeeService,
    ) {}

    public function getById(int $id)
    {
        return $this->quotationRequestRepositoryInterface->find($id);
    }

    public function getFullDetail(int $id)
    {
        $quotationRequest = $this->quotationRequestRepositoryInterface->find($id, ['quotations.plan.planTemplate', 'title']);
        $quotations = [];
        foreach ($quotationRequest['quotations'] as $quotation) {
            $quotation['duration_text'] = TextConverter::getDurationText($quotation->duration);
            $quotation['benefits'] = $this->getBenefits($quotation->plan, $quotation->amount);
            $quotation['profits'] = $this->getProfits($quotation->plan, $quotation->amount);
            $quotation['capital_return'] = $this->getCapital($quotation->plan, $quotation->amount);
            array_push($quotations, $quotation);
        }
        $quotationRequest['quotations'] = $quotations;
        return $quotationRequest;
    }

    private function getProfits(object $plan, float $amount): array
    {
        if ($plan->plan_template_id == 3) { // Benefit + Profit + Capital
            $yearText = number_format($amount) . ' * ' . $plan->profit_per_month . '% * ' . $plan->duration . " Months";
            $totalAmount = round((($amount * $plan->profit_per_month) / 100) * $plan->duration, 2);
            return ['name' => $yearText, 'rate' => $plan->profit_per_month, 'amount' => $totalAmount];
        }
        return [];
    }

    private function getCapital(object $plan, float $amount): array
    {
        if ($plan->plan_template_id == 3) { // Benefit + Profit + Capital
            return ['amount' => $amount, 'name' => 'Maturity Capital Return'];
        }
        return [];
    }

    private function getBenefits(object $plan, float $amount): array
    {
        if ($plan->plan_template_id == 1) { // Benefit Only
            return $this->getBenefitsForDifferentYearlyRates($plan, $amount);
        } else if ($plan->plan_template_id == 2) { // Benefit + Capital
            return $this->getBenefitsForDifferentYearlyRates($plan, $amount);
        } else if ($plan->plan_template_id == 3 || $plan->plan_template_id == 4) { // Benefit + Profit + Capital , // Benefit + Maturity
            $yearText = number_format($amount) . ' * ' . $plan->benefit_per_month . '% * ' . $plan->duration . " Months";
            $benefitAmount = round((($amount * $plan->benefit_per_month) / 100) * $plan->duration, 2);
            return ['name' => $yearText, 'rate' => $plan->benefit_per_month, 'amount' => $benefitAmount];
        }
        return [];
    }

    private function getProfitForDifferentYearlyRates($plan, $amount): array
    {
        $benefits = [];

        if ($plan->planTemplate->does_return_capital) {
            array_push($benefits, ['name' => 'Capital Return', 'amount' => $amount]);
        }

        if ($plan->planTemplate->does_return_benefit) {
            foreach ($plan->planBenefitRates as $planBenefit) {
                $yearText =  $this->getOrdinalSuffix($planBenefit->year) . " year";
                $benefitAmount = round(($amount * $planBenefit->rate) / 100, 2);
                array_push($benefits, ['name' => $yearText, 'rate' => $planBenefit->rate, 'amount' => $benefitAmount]);
            }
        }

        return $benefits;
    }

    private function getBenefitsForDifferentYearlyRates($plan, $amount): array
    {
        // $yearsCount = $this->getYearsCount($plan->duration);
        $benefits = [];

        if ($plan->planTemplate->does_return_capital) {
            array_push($benefits, ['name' => 'Capital Return', 'amount' => $amount]);
        }

        if ($plan->planTemplate->does_return_benefit) {
            foreach ($plan->planBenefitRates as $planBenefit) {
                $yearText =  $this->getOrdinalSuffix($planBenefit->year) . " year";
                $benefitAmount = round(($amount * $planBenefit->rate) / 100, 2);
                array_push($benefits, ['name' => $yearText, 'rate' => $planBenefit->rate, 'amount' => $benefitAmount]);
            }
        }

        return $benefits;
    }

    public function getYearsCount($months)
    {
        return $months % 12 == 0  ? $months / 12 : ceil($months / 12);
    }

    public function getAll(array $data)
    {
        return $this->quotationRequestRepositoryInterface->getAll($data);
    }

    private function getOrdinalSuffix($number)
    {
        $mod100 = $number % 100;

        // Special case for 11, 12, 13
        if ($mod100 >= 11 && $mod100 <= 13) {
            return $number . 'th';
        }

        switch ($number % 10) {
            case 1:
                return $number . 'st';
            case 2:
                return $number . 'nd';
            case 3:
                return $number . 'rd';
            default:
                return $number . 'th';
        }
    }
}
