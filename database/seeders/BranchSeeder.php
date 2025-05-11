<?php

namespace Database\Seeders;

use App\Models\AdministrativeHierarchy;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment(['production'])) return;
        Branch::truncate();

        // Retrieve Region IDs
        $regionId = AdministrativeHierarchy::whereIn('name', [
            'Colombo Region'
        ])->first()->id;

        $branches = [
            [
                'administrative_hierarchy_id' => $regionId,
                'name' => 'Head Office',
                'branch_code' => 'HO',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_hierarchy_id' => $regionId,
                'name' => 'Piliyandala',
                'branch_code' => 'PL',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_hierarchy_id' => $regionId,
                'name' => 'Moraturwa',
                'branch_code' => 'MR',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_hierarchy_id' => $regionId,
                'name' => 'Maharagama',
                'branch_code' => 'MH',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        Branch::insert($branches);
    }
}
