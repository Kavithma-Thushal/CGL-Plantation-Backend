<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            ['name' => 'Software Engineer'],
            ['name' => 'Graphic Designer'],
            ['name' => 'Quality Assurance Engineer'],
            ['name' => 'Accountant'],
            ['name' => 'Banker']
        ];
        Occupation::insert($records);
    }
}
