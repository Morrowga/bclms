<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;

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
                'first_name' => 'B2B Teacher',
                'last_name' => 'One',
                'email' => 'b2bteacher@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '1234567890',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ]
        ];

        foreach ($users as $user) {
            $userEloquent = UserEloquentModel::create($user);
            $teacherEloquent = TeacherEloquentModel::create([
                "user_id" => $userEloquent->id,
                "allocated_storage_limit" => 100,
                "organisation_id" => 1,
            ]);
        }
    }
}
