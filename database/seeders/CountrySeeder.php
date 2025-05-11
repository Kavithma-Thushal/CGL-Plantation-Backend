<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            ['name' => 'Sri Lanka'],
            ['name' => 'India'],
            ['name' => 'Australia'],
            ['name' => 'UK'],
            ['name' => 'USA'],
        ];
        Country::insert($records);
    }
}
