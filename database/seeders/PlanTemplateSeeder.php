<?php

namespace Database\Seeders;

use App\Models\PlanTemplate;
use Illuminate\Database\Seeder;

class PlanTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            [
                'name' => 'Benefit Only',
                'type' => 'INVESTMENT',
                'does_return_capital' => 0,
                'does_return_profit' => 0,
                'does_return_benefit' => 1
            ],

            [
                'name' => 'Benefit + Capital',
                'type' => 'INVESTMENT',
                'does_return_capital' => 1,
                'does_return_profit' => 0,
                'does_return_benefit' => 1
            ],

            [
                'name' => 'Benefit + Profit + Capital',
                'type' => 'INVESTMENT',
                'does_return_capital' => 1,
                'does_return_profit' => 1,
                'does_return_benefit' => 1
            ],

            [
                'name' => 'Benefit + Maturity',
                'type' => 'INVESTMENT',
                'does_return_capital' => 1,
                'does_return_profit' => 0,
                'does_return_benefit' => 1
            ],


        ];

        PlanTemplate::insert($records);
    }
}
