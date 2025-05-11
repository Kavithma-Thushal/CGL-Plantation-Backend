<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\PlanTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plan_template_id' => PlanTemplate::factory(), // or PlanTemplate::inRandomOrder()->first()->id if you want to use existing templates
            'name' => $this->faker->words(3, true),
            'code' => $this->faker->bothify('??-#####'),
            'duration' => $this->faker->randomFloat(2, 1, 60),
            'minimum_amount' => $this->faker->randomFloat(2, 1000, 100000),
            'profit_per_month' => $this->faker->randomFloat(2, 0, 100),
            'benefit_per_month' => $this->faker->randomFloat(2, 0, 100),
            'description' => $this->faker->optional()->paragraph,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
