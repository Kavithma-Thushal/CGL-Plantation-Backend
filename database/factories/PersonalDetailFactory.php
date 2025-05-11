<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\PersonalDetails;
use App\Models\Title;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalDetailFactory>
 */
class PersonalDetailFactory extends Factory
{
    protected $model = PersonalDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userableType = $this->faker->randomElement([User::class, Employee::class, Customer::class]);

        return [
            'title_id' => Title::factory(),
            'userable_id' => $userableType::factory(),
            'userable_type' => $userableType,
            'name_with_initials' => $this->faker->name,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'last_name' => $this->faker->lastName,
            'address' => $this->faker->optional()->address,
            'mobile_number' => $this->faker->optional()->phoneNumber,
            'status' => $this->faker->randomElement([0, 1]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
