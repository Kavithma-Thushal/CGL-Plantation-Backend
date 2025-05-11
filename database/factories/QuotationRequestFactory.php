<?php

namespace Database\Factories;

use App\Models\QuotationRequest;
use App\Models\Title;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuotationRequest>
 */
class QuotationRequestFactory extends Factory
{
    protected $model = QuotationRequest::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title_id' => Title::factory(), // or Title::inRandomOrder()->first()->id if you want to use existing titles
            'nic' => $this->faker->bothify('##########'), // Adjust the pattern as needed
            'mobile_number' => $this->faker->phoneNumber,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'last_name' => $this->faker->optional()->lastName,
            'email' => $this->faker->optional()->safeEmail,
            'landline_number' => $this->faker->optional()->phoneNumber,
            'address' => $this->faker->optional()->address,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
