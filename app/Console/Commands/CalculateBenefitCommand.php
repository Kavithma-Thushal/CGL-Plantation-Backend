<?php

namespace App\Console\Commands;

use App\Enums\BenefitTypeEnum;
use App\Enums\PackageStatusesEnum;
use App\Models\Benefit;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateBenefitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-benefit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and generate benefit record';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get outstanding payment user packages but excluding not started yet , matured or cancelled packages.
        $userPackages = $this->getOutstandingUserPackages();

        if ($userPackages->isEmpty()) {
            $this->error("No packages found");
            return;
        }

        foreach ($userPackages as $userPackage) {
            $startDate = $this->getPackageStartDate($userPackage);

            if ($userPackage->plan->planTemplate->does_return_benefit) {
                $this->addBenefits($userPackage, $startDate);
            }

            if ($userPackage->plan->planTemplate->does_return_profit) {
                $this->addProfits($userPackage, $startDate);
            }
        }
    }

    private function getOutstandingUserPackages()
    {
        return UserPackage::query()
            ->with(['packageTimeline.packageStatus', 'receipts'])
            ->whereHas('packageTimeline.packageStatus', function ($q) {
                $q->where('name', PackageStatusesEnum::STARTED);
            })
            ->whereDoesntHave('packageTimeline.packageStatus', function ($q) {
                $q->whereIn('name', [PackageStatusesEnum::MATURED, PackageStatusesEnum::CANCELLED]);
            })
            ->get()
            ->filter(function ($package) {
                //get only outstanding payment packages
                return $package->receipts->sum('amount') >= $package->total;
            });
    }

    private function getPackageStartDate($userPackage)
    {
        return $userPackage->packageTimeline()
            ->whereHas('packageStatus', function ($q) {
                $q->where('name', PackageStatusesEnum::STARTED);
            })
            ->first()
            ->created_at;
    }

    private function addProfits($userPackage, $startDate)
    {
        if (!$this->isPaymentDue($userPackage)) return;

        $benefitAmount = $this->calculateProfitAmount($userPackage);
        $this->storeBenefitOrProfit($userPackage, $benefitAmount, BenefitTypeEnum::PROFIT, 'Profit', $startDate);
    }

    private function addBenefits($userPackage, $startDate)
    {
        if (!$this->isPaymentDue($userPackage)) return;

        $benefitAmount = $this->calculateBenefitAmount($userPackage, $startDate);
        $this->storeBenefitOrProfit($userPackage, $benefitAmount, BenefitTypeEnum::MONTHLY_BENEFIT, 'Benefit', $startDate);
    }

    private function isPaymentDue($userPackage)
    {
        $currentDate = now()->startOfDay();
        return $currentDate->isSameDay($userPackage->benefit_term_date);
    }

    private function calculateProfitAmount($userPackage)
    {
        return $userPackage->total_amount * ($userPackage->profit_per_month / 100);
    }

    private function calculateBenefitAmount($userPackage, $startDate)
    {
        $startDate = Carbon::parse($startDate);
        $today = Carbon::now();

        $numberOfYears = round(floor($startDate->diffInYears($today)) + 1);

        $rateRecord = $userPackage->plan->planBenefitRates()->where('year', $numberOfYears)->first();
        if ($rateRecord != null) {
            $rate = $rateRecord->rate;
        } else {
            if (isset($userPackage->plan->benefit_per_month)) {
                $rate = $userPackage->plan->benefit_per_month;
            } else {
                $rate = 0;
            }
        }
        return $userPackage->total_amount * ($rate / 100);
    }

    private function storeBenefitOrProfit($userPackage, $amount, $type, $namePrefix, $startDate)
    {
        $startDate = Carbon::parse($startDate);
        $today = Carbon::now();
        $diffInMonths = floor($startDate->diffInMonths($today)) + 1;
        // Get the current month name
        $monthName = $today->format('F Y');

        // Concatenate the name prefix with the month name
        $benefitName = $namePrefix . ' ' . $monthName;

        $benefitKeys = [
            'user_package_id' => $userPackage->id,
            'benefit_type' => $type,
            'term_count' => $diffInMonths,
            'term_name' => $benefitName
        ];

        $benefitData = ['amount' => $amount];

        Benefit::updateOrCreate($benefitKeys, $benefitData);
    }
}
