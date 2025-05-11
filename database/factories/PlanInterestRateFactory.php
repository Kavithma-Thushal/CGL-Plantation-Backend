<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\PlanBenefitRate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanBenefitRate>
 */
class PlanBenefitRateFactory extends Factory
{
    protected $model = PlanBenefitRate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plan_id' => Plan::factory(), // or Plan::inRandomOrder()->first()->id if you want to use existing plans
            'year' => $this->faker->numberBetween(1, 10),
            'rate' => $this->faker->randomFloat(2, 0, 20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
