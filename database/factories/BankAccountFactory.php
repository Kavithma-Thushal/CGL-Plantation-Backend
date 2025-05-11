<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BankAccount>
 */
class BankAccountFactory extends Factory
{
    protected $model = BankAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bank_id' => Bank::factory(),
            'account_number' => $this->faker->bankAccountNumber,
            'branch_name' => $this->faker->optional()->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
