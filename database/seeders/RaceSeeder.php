<?php

namespace Database\Seeders;

use App\Models\Race;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            ['name' => 'Sinhalese'],
            ['name' => 'Sri Lankan Tamil'],
            ['name' => 'Indian Tamil'],
            ['name' => 'Muslim'],
            ['name' => 'Burger'],
        ];
        Race::insert($records);
    }
}
