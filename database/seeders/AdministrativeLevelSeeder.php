<?php

namespace Database\Seeders;

use App\Models\AdministrativeLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministrativeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrativeLevels = [
            ['id' => 1, 'parent_id' => null, 'name' => 'HEAD OFFICE'],
            ['id' => 2, 'parent_id' => 1, 'name' => 'PROVINCE'],
            ['id' => 3, 'parent_id' => 2, 'name' => 'ZONE'],
            ['id' => 4, 'parent_id' => 3, 'name' => 'REGION'],
        ];

        foreach ($administrativeLevels as $level) {
            AdministrativeLevel::updateOrCreate([
                'id' => $level['id'],
            ], [
                'parent_id' => $level['parent_id'],
                'name' => $level['name'],
            ]);
        }

        // Set the sequence value to max ID + 1
        $maxId = DB::table('administrative_levels')->max('id');
        DB::select("SELECT setval(pg_get_serial_sequence('administrative_levels', 'id'), ?, false)", [$maxId + 1]);
    }
}
