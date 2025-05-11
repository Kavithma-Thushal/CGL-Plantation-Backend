<?php

namespace Database\Factories;

use App\Models\BankAccount;
use App\Models\Employee;
use App\Models\EmployeeBankDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeBankDetail>
 */
class EmployeeBankDetailFactory extends Factory
{
    protected $model = EmployeeBankDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'bank_account_id' => BankAccount::factory(),
            'status' => $this->faker->randomElement([0, 1]), // Randomly set status
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
