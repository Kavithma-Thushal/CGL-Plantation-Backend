<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\EmployeeBranch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeBranch>
 */
class EmployeeBranchFactory extends Factory
{
    protected $model = EmployeeBranch::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'branch_id' => Branch::factory(),
            'status' => $this->faker->randomElement([0, 1]), // Randomly set status as active or inactive
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
