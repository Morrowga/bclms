<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            SuperAdminSeeder::class,
            PageBuilderSeeder::class,
            SiteSettingSeeder::class,
            B2CTeacherRoleSeeder::class,
            OrganizationAdminSeeder::class,
            OrganizationSeeder::class,
            B2BTeacherRoleSeeder::class,
            BCStaffRoleSeeder::class,
            StudentRoleSeeder::class,
            SurveySeeder::class,
        ]);
    }
}
