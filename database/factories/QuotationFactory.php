<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Quotation;
use App\Models\QuotationRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quotation>
 */
class QuotationFactory extends Factory
{
    protected $model = Quotation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plan_id' => Plan::factory(), // or Plan::inRandomOrder()->first()->id if you want to use existing plans
            'quotation_request_id' => QuotationRequest::factory(), // or QuotationRequest::inRandomOrder()->first()->id if you want to use existing requests
            'quotation_number' => $this->faker->unique()->bothify('Q-#####'),
            'amount' => $this->faker->randomFloat(2, 1000, 100000),
            'expire_date' => $this->faker->date('Y-m-d', '+1 month'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
