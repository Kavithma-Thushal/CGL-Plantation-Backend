<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            PermissionSeeder::class,
            CountrySeeder::class,
            RaceSeeder::class,
            NationalitySeeder::class,
            OccupationSeeder::class,
            TreeBrandSeeder::class,
            AdministrativeLevelSeeder::class,
            AdministrativeHierarchySeeder::class,
            BranchSeeder::class,
            DesignationSeeder::class,
            PlanTemplateSeeder::class,
            PlanSeeder::class,
            TitleSeeder::class,
            BankSeeder::class,
            PackageStatusSeeder::class,
            UserSeeder::class,
        ]);
    }
}
