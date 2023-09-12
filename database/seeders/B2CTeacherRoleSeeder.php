<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2cSubscriptionEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2cUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

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
            ],
            [
                'role_id' => 2,
                'first_name' => 'Teacher',
                'last_name' => 'Two',
                'email' => 'teachertwo@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '234234',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ],
            [
                'role_id' => 2,
                'first_name' => 'Teacher',
                'last_name' => 'Three',
                'email' => 'teacherthree@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '2344523',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ],
            [
                'role_id' => 2,
                'first_name' => 'Teacher',
                'last_name' => 'One',
                'email' => 'teacherfour@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '2323423',
                'status' => 'INACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            ],

        ];

        foreach ($users as $user) {
            $userCreate = UserEloquentModel::create($user);
            $planEloquent = PlanEloquentModel::find(1);
            $subscriptionData = [
                'start_date' => now(),
                'end_date' => now(),
                'payment_date' => now(),
                'payment_status' => 'PAID',
                'stripe_status' => 'ACTIVE',
                'stripe_price' => $planEloquent->price,
            ];
            $subscriptionOne = SubscriptionEloquentModel::create($subscriptionData);
            B2cUserEloquentModel::create([
                'user_id' => $userCreate->id,
                'current_subscription_id' => $subscriptionOne->id,
            ]);
            B2cSubscriptionEloquentModel::create([
                'subscription_id' => $subscriptionOne->id,
                'user_id' => $userCreate->id,
                'plan_id' => $planEloquent->id,
            ]);
        }
    }
}
