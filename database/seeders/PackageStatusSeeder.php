<?php

namespace Database\Seeders;

use App\Models\PackageStatus;
use Illuminate\Database\Seeder;
use App\Enums\PackageStatusesEnum;
use Illuminate\Support\Facades\Schema;

class PackageStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        PackageStatus::truncate();

        $statuses = PackageStatusesEnum::valuesWithColors();

        foreach ($statuses as $status => $color) {
            PackageStatus::insert([
                'name' => $status,
                'color' => $color,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
