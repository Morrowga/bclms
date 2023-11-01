<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\OrganisationAdminSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DefaultPlanSeeder::class,
            PermissionTableSeeder::class,
            PermissionRoleTableSeeder::class,
            DeviceSeeder::class,
            SuperAdminSeeder::class,
            PageBuilderSeeder::class,
            SiteSettingSeeder::class,
            B2CTeacherRoleSeeder::class,
            OrganisationAdminSeeder::class,
            B2BTeacherRoleSeeder::class,
            BCStaffRoleSeeder::class,
            StudentRoleSeeder::class,
            SurveySeeder::class,
            // StorybookSeeder::class,
            // ReviewSeeder::class,
        ]);
    }
}
