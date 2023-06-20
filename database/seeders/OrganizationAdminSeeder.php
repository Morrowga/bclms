<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class OrganizationAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [

                'name' => "Org One",
                'organization_id' => 1,
                'email_verified_at' => now(),
                'dob' => now(),
                'contact_number' => "1234567890",
                'storage_limit' => 100,
                'is_active' => true,
                'email' => "orgone@mail.com",
                'password' => 'password',
            ],
            [

                'name' => "Org Two",
                'organization_id' => 2,
                'email_verified_at' => now(),
                'dob' => now(),
                'contact_number' => "1234567890",
                'storage_limit' => 100,
                'is_active' => true,
                'email' => "orgtwo@mail.com",
                'password' => 'password',
            ]
        ];


        foreach ($users as $user) {
            $userModel  = UserEloquentModel::create($user);
            $userModel->roles()->sync([5]);


        }
    }
}
