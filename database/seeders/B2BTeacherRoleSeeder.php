<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class B2BTeacherRoleSeeder extends Seeder
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
                'role_id' => 4,
                'first_name' => 'B2b',
                'last_name' => 'Teacher',
                'email' => 'b2bteacher@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '1234567890',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ],
            [
                'role_id' => 4,
                'first_name' => 'B2b',
                'last_name' => 'Teacher Two',
                'email' => 'b2bteachertwo@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '234235234',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ],
            [
                'role_id' => 4,
                'first_name' => 'B2b',
                'last_name' => 'Teacher Three',
                'email' => 'b2bteacherthree@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '23434534',
                'status' => 'INACTIVE',
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
