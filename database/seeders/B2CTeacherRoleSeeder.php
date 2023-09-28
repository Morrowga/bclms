<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2cSubscriptionEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2cUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;

class B2CTeacherRoleSeeder extends Seeder
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
                'role_id' => 2,
                'first_name' => 'Teacher',
                'last_name' => 'One',
                'email' => 'teacherone@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '1234567890',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ]
        ];

        foreach ($users as $user) {
            $userEloquent = UserEloquentModel::create($user);
            $planEloquent = PlanEloquentModel::find(1);
            $subscriptionEloquent = [
                'start_date' => now(),
                'end_date' => now(),
                'payment_date' => now(),
                'payment_status' => 'PAID',
                'stripe_status' => 'ACTIVE',
                'stripe_price' => $planEloquent->price,
            ];
            $subscriptionEloquent = SubscriptionEloquentModel::create($subscriptionEloquent);
            $teacherEloquent = TeacherEloquentModel::create([
                "user_id" => $userEloquent->id,
                "curr_subscription_id" => $subscriptionEloquent->id,
            ]);
            $b2cSubscripton = B2cSubscriptionEloquentModel::create([
                "teacher_id" => $teacherEloquent->teacher_id,
                "subscription_id" => $subscriptionEloquent->id,
                "plan_id" => $planEloquent->id
            ]);
        }
    }
}
