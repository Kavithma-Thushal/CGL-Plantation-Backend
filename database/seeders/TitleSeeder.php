<?php

namespace Database\Seeders;

use App\Models\Title;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            ['name' => 'Mr.'],
            ['name' => 'Mrs.'],
            ['name' => 'Ms.'],
            ['name' => 'Miss.'],
            ['name' => 'Dr.'],
            ['name' => 'Prof.'],
            ['name' => 'Rev.'],
            ['name' => 'Hon.'],
            ['name' => 'Sir'],
            ['name' => 'Dame'],
            ['name' => 'Lady'],
            ['name' => 'Lord'],
        ];
        Title::insert($records);
    }
}
