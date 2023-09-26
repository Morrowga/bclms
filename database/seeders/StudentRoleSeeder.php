<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class StudentRoleSeeder extends Seeder
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
                'role_id' => 6,
                'first_name' => 'Student',
                'last_name' => 'One',
                'email' => 'studentone@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '1234567890',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ],
        ];

        foreach ($users as $user) {
            $userCreate = UserEloquentModel::create($user);
            $studentData = [
                'user_id' => $userCreate->id,
                'dob' => now(),
                'gender' => 'Male',
                'education_level' => 'G1',
            ];
            $studentCreate = StudentEloquentModel::create($studentData);

        }
    }
}
