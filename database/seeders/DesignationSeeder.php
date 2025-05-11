<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $designations = [
        //     ['id' => 1, 'parent_id' => null, 'name' => 'Chairman', 'orc' => 0],
        //     ['id' => 2, 'parent_id' => 1, 'name' => 'Director of Human Resources', 'orc' => 0],
        //     ['id' => 3, 'parent_id' => 1, 'name' => 'Director Export', 'orc' => 0],
        //     ['id' => 4, 'parent_id' => 2, 'name' => 'Chief Executive Officer', 'orc' => 0],
        //     ['id' => 5, 'parent_id' => 4, 'name' => 'Senior General Manager', 'orc' => 0],
        //     ['id' => 6, 'parent_id' => 5, 'name' => 'General Manager', 'orc' => 0.25],
        //     ['id' => 7, 'parent_id' => 5, 'name' => 'Operations Manager', 'orc' => 0],
        //     ['id' => 8, 'parent_id' => 5, 'name' => 'Marketing Manager', 'orc' => 0],
        //     ['id' => 9, 'parent_id' => 5, 'name' => 'Chief Technical Officer', 'orc' => 0],
        //     ['id' => 10, 'parent_id' => 5, 'name' => 'HR Manager', 'orc' => 0],
        //     ['id' => 11, 'parent_id' => 5, 'name' => 'Admin Manager', 'orc' => 0],
        //     ['id' => 12, 'parent_id' => 6, 'name' => 'Assistant General Manager', 'orc' => 0.25],
        //     ['id' => 13, 'parent_id' => 12, 'name' => 'Zonal Manager', 'orc' => 0.5],
        //     ['id' => 14, 'parent_id' => 13, 'name' => 'Regional Manager', 'orc' => 0.75],
        //     ['id' => 15, 'parent_id' => 14, 'name' => 'Branch Manager', 'orc' => 1],
        //     ['id' => 16, 'parent_id' => 15, 'name' => 'Sales Executive', 'orc' => 1.5],
        //     ['id' => 17, 'parent_id' => 16, 'name' => 'Sales Consultant', 'orc' => 0],
        //     ['id' => 18, 'parent_id' => 7, 'name' => 'Receptionist', 'orc' => 0],
        //     ['id' => 19, 'parent_id' => 7, 'name' => 'Office Coordinator', 'orc' => 0],
        //     ['id' => 20, 'parent_id' => 7, 'name' => 'House Keeping', 'orc' => 0],
        //     ['id' => 21, 'parent_id' => 9, 'name' => 'IT Assistant', 'orc' => 0],
        //     ['id' => 22, 'parent_id' => 10, 'name' => 'HR Executive', 'orc' => 0],
        //     ['id' => 23, 'parent_id' => 11, 'name' => 'Admin Executive', 'orc' => 0],
        //     ['id' => 24, 'parent_id' => 23, 'name' => 'Admin Assistant', 'orc' => 0],
        // ];
        $designations = [
            ['id' => 1, 'parent_id' => null, 'name' => 'Chairman', 'orc' => 0],
            ['id' => 2, 'parent_id' => 1, 'name' => 'Deputy CEO', 'orc' => 0],
            ['id' => 3, 'parent_id' => 1, 'name' => 'Director of Human Resources', 'orc' => 0],
            ['id' => 4, 'parent_id' => 1, 'name' => 'Director Export', 'orc' => 0],
            ['id' => 5, 'parent_id' => 3, 'name' => 'Chief Executive Officer', 'orc' => 0],
            ['id' => 6, 'parent_id' => 5, 'name' => 'Senior General Manager', 'orc' => 0],
            ['id' => 7, 'parent_id' => 6, 'name' => 'General Manager', 'orc' => 0.25],
            ['id' => 8, 'parent_id' => 6, 'name' => 'Operations Manager', 'orc' => 0],
            ['id' => 9, 'parent_id' => 6, 'name' => 'Marketing Manager', 'orc' => 0],
            ['id' => 10, 'parent_id' => 6, 'name' => 'Chief Technical Officer', 'orc' => 0],
            ['id' => 11, 'parent_id' => 6, 'name' => 'HR Manager', 'orc' => 0],
            ['id' => 12, 'parent_id' => 6, 'name' => 'Admin Manager', 'orc' => 0],
            ['id' => 13, 'parent_id' => 7, 'name' => 'Assistant General Manager', 'orc' => 0.25],
            ['id' => 14, 'parent_id' => 13, 'name' => 'Zonal Manager', 'orc' => 0.5],
            ['id' => 15, 'parent_id' => 14, 'name' => 'Regional Manager', 'orc' => 0.75],
            ['id' => 16, 'parent_id' => 15, 'name' => 'Administration Coordinator', 'orc' => 1],
            ['id' => 17, 'parent_id' => 16, 'name' => 'Sales Executive', 'orc' => 1.5],
            ['id' => 18, 'parent_id' => 17, 'name' => 'Sales Consultant', 'orc' => 0],
            ['id' => 19, 'parent_id' => 8, 'name' => 'Receptionist', 'orc' => 0],
            ['id' => 20, 'parent_id' => 8, 'name' => 'Office Coordinator', 'orc' => 0],
            ['id' => 21, 'parent_id' => 8, 'name' => 'House Keeping', 'orc' => 0],
            ['id' => 22, 'parent_id' => 10, 'name' => 'IT Assistant', 'orc' => 0],
            ['id' => 23, 'parent_id' => 11, 'name' => 'HR Executive', 'orc' => 0],
            ['id' => 24, 'parent_id' => 12, 'name' => 'Admin Executive', 'orc' => 0],
            ['id' => 25, 'parent_id' => 24, 'name' => 'Admin Assistant', 'orc' => 0],
        ];

        foreach ($designations as $designation) {
            Designation::updateOrCreate([
                'id' => $designation['id'],
            ], [
                'parent_id' => $designation['parent_id'],
                'name' => $designation['name'],
                'orc' => $designation['orc'],
                'code' => str_replace(' ', '_', strtoupper($designation['name'])),
            ]);
        }

        // Set the sequence value to max ID + 1
        $maxId = DB::table('designations')->max('id');
        DB::select("SELECT setval(pg_get_serial_sequence('designations', 'id'), ?, false)", [$maxId + 1]);
    }
}
