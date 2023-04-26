<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Src\BlendedConcept\User\Domain\Model\User;

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
            PermissionTableSeeder::class,
            PermissionRoleTableSeeder::class,
            SuperAdminSeeder::class,
            PageBuilderSeeder::class
        ]);
    }
}
