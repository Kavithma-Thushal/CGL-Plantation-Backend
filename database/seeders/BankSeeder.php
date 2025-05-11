<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            ['name' => 'Bank of Ceylon'],
            ['name' => 'People\'s Bank'],
            ['name' => 'Commercial Bank of Ceylon'],
            ['name' => 'Hatton National Bank'],
            ['name' => 'Sampath Bank'],
            ['name' => 'Seylan Bank'],
            ['name' => 'National Savings Bank'],
            ['name' => 'DFCC Bank'],
            ['name' => 'Nations Trust Bank'],
            ['name' => 'Pan Asia Bank'],
            ['name' => 'Union Bank of Colombo'],
            ['name' => 'Amana Bank'],
        ];
        Bank::insert($records);
    }
}
