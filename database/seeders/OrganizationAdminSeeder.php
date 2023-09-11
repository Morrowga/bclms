<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
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
                'role_id' => 5,
                'first_name' => 'Org',
                'last_name' => 'One',
                'email' => 'orgone@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '1234567890',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ],
            [
                'role_id' => 5,
                'first_name' => 'Org',
                'last_name' => 'One Partner One',
                'email' => 'orgptnerone@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '3453345',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ],
            [
                'role_id' => 5,
                'first_name' => 'Org',
                'last_name' => 'One Partner Two',
                'email' => 'orgonepartwo@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '23525',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ],
            [
                'role_id' => 5,
                'first_name' => 'Org',
                'last_name' => 'One Partner Three',
                'email' => 'orgonepartthree@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '23423',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ],
        ];

        foreach ($users as $user) {
            $userCreate = UserEloquentModel::create($user);
            B2bUserEloquentModel::create([
                "user_id" => $userCreate->id,
                "organization_id" => 1,
                "allocated_storage_limit" => 0,
                "has_full_library_access" => false
            ]);
        }
    }
}
