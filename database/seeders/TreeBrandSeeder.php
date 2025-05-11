<?php

namespace Database\Seeders;

use App\Models\Title;
use App\Models\TreeBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreeBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            ['name' => 'Guava','created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Coconut','created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Teak','created_at'=>now(),'updated_at'=>now()]
        ];
        TreeBrand::insert($records);
    }
}
