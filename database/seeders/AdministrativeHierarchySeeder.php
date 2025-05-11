<?php

namespace Database\Seeders;

use App\Models\AdministrativeHierarchy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class AdministrativeHierarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (AdministrativeHierarchy::count() > 12 && App::environment(['production'])) return;
        AdministrativeHierarchy::truncate();
        // Insert Provinces
        $provinces = [
            [
                'administrative_level_id' => 1, 'name' => 'Head Office', 'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 2, 'name' => 'Western Province', 'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 2, 'name' => 'Central Province', 'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 2, 'name' => 'Southern Province', 'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 2, 'name' => 'Northern Province', 'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 2, 'name' => 'Eastern Province', 'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 2, 'name' => 'North Western Province', 'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 2, 'name' => 'North Central Province', 'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 2, 'name' => 'Uva Province', 'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'administrative_level_id' => 2, 'name' => 'Sabaragamuwa Province', 'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        AdministrativeHierarchy::insert($provinces);

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
        $districts = [
            // Western Province
            ['administrative_level_id' => 3, 'name' => 'Colombo Zone', 'parent_id' => $provinceIds['Western Province'],
                'created_at'=>now(),
                'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Gampaha Zone', 'parent_id' => $provinceIds['Western Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Kalutara Zone', 'parent_id' => $provinceIds['Western Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // // Central Province
            // ['administrative_level_id' => 3, 'name' => 'Kandy Zone', 'parent_id' => $provinceIds['Central Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Matale Zone', 'parent_id' => $provinceIds['Central Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Nuwara Eliya Zone', 'parent_id' => $provinceIds['Central Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // // Southern Province
            // ['administrative_level_id' => 3, 'name' => 'Galle Zone', 'parent_id' => $provinceIds['Southern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Matara Zone', 'parent_id' => $provinceIds['Southern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Hambantota Zone', 'parent_id' => $provinceIds['Southern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // // Northern Province
            // ['administrative_level_id' => 3, 'name' => 'Jaffna Zone', 'parent_id' => $provinceIds['Northern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Kilinochchi Zone', 'parent_id' => $provinceIds['Northern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Mannar Zone', 'parent_id' => $provinceIds['Northern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Vavuniya Zone', 'parent_id' => $provinceIds['Northern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Mullaitivu Zone', 'parent_id' => $provinceIds['Northern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // // Eastern Province
            // ['administrative_level_id' => 3, 'name' => 'Batticaloa Zone', 'parent_id' => $provinceIds['Eastern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Ampara Zone', 'parent_id' => $provinceIds['Eastern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Trincomalee Zone', 'parent_id' => $provinceIds['Eastern Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // // North Western Province
            // ['administrative_level_id' => 3, 'name' => 'Kurunegala Zone', 'parent_id' => $provinceIds['North Western Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Puttalam Zone', 'parent_id' => $provinceIds['North Western Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // // North Central Province
            // ['administrative_level_id' => 3, 'name' => 'Anuradhapura Zone', 'parent_id' => $provinceIds['North Central Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Polonnaruwa Zone', 'parent_id' => $provinceIds['North Central Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // // Uva Province
            // ['administrative_level_id' => 3, 'name' => 'Badulla Zone', 'parent_id' => $provinceIds['Uva Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Moneragala Zone', 'parent_id' => $provinceIds['Uva Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // // Sabaragamuwa Province
            // ['administrative_level_id' => 3, 'name' => 'Ratnapura Zone', 'parent_id' => $provinceIds['Sabaragamuwa Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 3, 'name' => 'Kegalle Zone', 'parent_id' => $provinceIds['Sabaragamuwa Province'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
        ];

        AdministrativeHierarchy::insert($districts);

        // Retrieve District IDs (Zones)
        $zoneIds = AdministrativeHierarchy::whereIn('name', [
            'Colombo Zone',
            // 'Gampaha Zone',
            // 'Kandy Zone',
            // 'Matale Zone',
            // 'Galle Zone',
            // 'Matara Zone',
            // 'Anuradhapura Zone',
            // 'Polonnaruwa Zone',
            // 'Kegalle Zone',
        ])->pluck('id', 'name');

        // Insert Regions with the retrieved district IDs as parent_id
        $regions = [
            ['administrative_level_id' => 4, 'name' => 'Colombo Region', 'parent_id' => $zoneIds['Colombo Zone'],
                'created_at'=>now(),
                'updated_at'=>now()],
            // ['administrative_level_id' => 4, 'name' => 'Gampaha Region', 'parent_id' => $zoneIds['Gampaha Zone'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 4, 'name' => 'Kandy Region', 'parent_id' => $zoneIds['Kandy Zone'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 4, 'name' => 'Matale Region', 'parent_id' => $zoneIds['Matale Zone'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 4, 'name' => 'Galle Region', 'parent_id' => $zoneIds['Galle Zone'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 4, 'name' => 'Matara Region', 'parent_id' => $zoneIds['Matara Zone'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 4, 'name' => 'Anuradhapura Region', 'parent_id' => $zoneIds['Anuradhapura Zone'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 4, 'name' => 'Polonnaruwa Region', 'parent_id' => $zoneIds['Polonnaruwa Zone'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
            // ['administrative_level_id' => 4, 'name' => 'Kegalle Region', 'parent_id' => $zoneIds['Kegalle Zone'],
                // 'created_at'=>now(),
                // 'updated_at'=>now()],
        ];

        AdministrativeHierarchy::insert($regions);
    }
}
