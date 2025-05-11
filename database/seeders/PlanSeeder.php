<?php

namespace Database\Seeders;

use App\Http\Services\PlanService;
use App\Models\Plan;
use App\Models\PlanBenefitRate;
use App\Models\PlanTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = 'Benefit Only';

        // 1 Elegance Plan
        $name = 'Elegance Plan';
        $code = App::make(PlanService::class)->createUniqueCode($name);
        $planData = [
            'plan_template_id' => PlanTemplate::where('name', $category)->first()->id,
            'name' => $name,
            'duration' => 12 * 1,
            'code' => $code,
            'minimum_amount' => 100000,
            'description' => $name . ' - ' . $category . ' Category',
            'profit_per_month' => null,
            'benefit_per_month' => null
        ];
        $plan = Plan::create($planData);

        $benefitRates = [40];
        foreach ($benefitRates as $index => $benefitRate) {
            $rateData = [
                'plan_id' => $plan->id,
                'year' => $index + 1,
                'rate' => $benefitRate,
                'created_at' => now(),
                'updated_at' => now()
            ];
            PlanBenefitRate::create($rateData);
        }


        // 2 Wisdom Plan
        $name = 'Wisdom Plan';
        $code = App::make(PlanService::class)->createUniqueCode($name);
        $planData = [
            'plan_template_id' => PlanTemplate::where('name', $category)->first()->id,
            'name' => $name,
            'duration' => 12 * 5,
            'code' => $code,
            'minimum_amount' => 100000,
            'description' => $name . ' - ' . $category . ' Category',
            'profit_per_month' => null,
            'benefit_per_month' => null
        ];
        $plan = Plan::create($planData);

        $benefitRates = [43.2, 67.2, 91.2, 91.2, 115.2];
        foreach ($benefitRates as $index => $benefitRate) {
            $rateData = [
                'plan_id' => $plan->id,
                'year' => $index + 1,
                'rate' => $benefitRate,
                'created_at' => now(),
                'updated_at' => now()
            ];
            PlanBenefitRate::create($rateData);
        }


        // 3 Upadi Plan
        $name = 'Upadi Plan';
        $code = App::make(PlanService::class)->createUniqueCode($name);
        $planData = [
            'plan_template_id' => PlanTemplate::where('name', $category)->first()->id,
            'name' => $name,
            'duration' => 12 * 6,
            'code' => $code,
            'minimum_amount' => 100000,
            'description' => $name . ' - ' . $category . ' Category',
            'profit_per_month' => null,
            'benefit_per_month' => null
        ];
        $plan = Plan::create($planData);

        $benefitRates = [30, 50, 70, 90, 110, 150];
        foreach ($benefitRates as $index => $benefitRate) {
            $rateData = [
                'plan_id' => $plan->id,
                'year' => $index + 1,
                'rate' => $benefitRate,
                'created_at' => now(),
                'updated_at' => now()
            ];
            PlanBenefitRate::create($rateData);
        }


        $category = 'Benefit + Profit + Capital';

        // 4 Golden Harvest Plan
        $name = 'Golden Harvest Plan';
        $code = App::make(PlanService::class)->createUniqueCode($name);
        $planData = [
            'plan_template_id' => PlanTemplate::where('name', $category)->first()->id,
            'name' => $name,
            'duration' => 12 * 5,
            'code' => $code,
            'minimum_amount' => 100000,
            'description' => $name . ' - ' . $category . ' Category',
            'profit_per_month' => 25,
            'benefit_per_month' => 55
        ];
        $plan = Plan::create($planData);


        $category = 'Benefit + Maturity';

        // 5 Swift Growth Month Plan
        $name = 'Swift Growth Plan';
        $code = App::make(PlanService::class)->createUniqueCode($name);
        $planData = [
            'plan_template_id' => PlanTemplate::where('name', $category)->first()->id,
            'name' => $name,
            'duration' => 6,
            'code' => $code,
            'minimum_amount' => 100000,
            'description' => $name . ' - ' . $category . ' Category',
            'profit_per_month' => 0,
            'benefit_per_month' => 12.5
        ];
        $plan = Plan::create($planData);

        // 6 Double Growth Plan
        $name = 'Double Growth Plan';
        $code = App::make(PlanService::class)->createUniqueCode($name);
        $planData = [
            'plan_template_id' => PlanTemplate::where('name', $category)->first()->id,
            'name' => $name,
            'duration' => 12 * 2,
            'code' => $code,
            'minimum_amount' => 100000,
            'description' => $name . ' - ' . $category . ' Category',
            'profit_per_month' => 0,
            'benefit_per_month' => 12.5
        ];
        $plan = Plan::create($planData);


        // 7 Diamond Plan
        $name = 'Diamond Plan';
        $code = App::make(PlanService::class)->createUniqueCode($name);
        $planData = [
            'plan_template_id' => PlanTemplate::where('name', $category)->first()->id,
            'name' => $name,
            'duration' => 12 * 5,
            'code' => $code,
            'minimum_amount' => 100000,
            'description' => $name . ' - ' . $category . ' Category',
            'profit_per_month' => 0,
            'benefit_per_month' => 0
        ];
        $plan = Plan::create($planData);
    }
}
