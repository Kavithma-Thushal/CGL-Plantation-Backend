<?php

namespace Database\Seeders;

use App\Models\AdministrativeHierarchy;
use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve province IDs
        $provinceIds = AdministrativeHierarchy::whereIn('name', [
            'Western Province',
            'Central Province',
            'Southern Province',
            'Northern Province',
            'Eastern Province',
            'North Western Province',
            'North Central Province',
            'Uva Province',
            'Sabaragamuwa Province'
        ])->pluck('id', 'name');

        // Insert Districts with the correct parent_id and "Zone" suffix
        $zones = [
            // Western Province
            [
                'administrative_level_id' => 3,
                'name' => 'Central Zone',
                'parent_id' => $provinceIds['Central Province'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 3,
                'name' => 'Southern Zone',
                'parent_id' => $provinceIds['Southern Province'],
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        AdministrativeHierarchy::insert($zones);


        $zonesId = AdministrativeHierarchy::whereIn('name', [
            'Central Zone',
            'Southern Zone',
        ])->pluck('id', 'name');

        $zones = [
            [
                'administrative_level_id' => 4,
                'name' => 'Central Region',
                'parent_id' => $zonesId['Central Province'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 4,
                'name' => 'Southern Region',
                'parent_id' => $zonesId['Southern Province'],
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        AdministrativeHierarchy::insert($zones);

        // Retrieve Region IDs
        $regionId = AdministrativeHierarchy::whereIn('name', [
            'Central Region',
            'Southern Region',

        ])->first()->id;

        $branches = [
            [
                'administrative_hierarchy_id' => $regionId['Central Region'],
                'name' => 'Central Region Branch',
                'branch_code' => 'CRB',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        Branch::insert($branches);
    }
}
