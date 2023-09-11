<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        ];

        foreach ($users as $user) {
            $userCreate = UserEloquentModel::create($user);
        }
    }
}
