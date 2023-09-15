<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\Tenant;

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
            [
                'role_id' => 5,
                'first_name' => 'Org',
                'last_name' => 'Two',
                'email' => 'orgtwo@mail.com',
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

        $subscriptionData = [
            'start_date' => now(),
            'end_date' => now(),
            'payment_date' => now(),
            'payment_status' => 'PAID',
            'stripe_status' => null,
            'stripe_price' => null,
        ];

        $subscriptionOne = SubscriptionEloquentModel::create($subscriptionData);
        $subscriptionTwo = SubscriptionEloquentModel::create($subscriptionData);

        $organizationData = [
            [
                'curr_subscription_id' => $subscriptionOne->id,
                'org_admin_id' => 6,
                'name' => 'organization one',
                'contact_name' => 'org one',
                'contact_email' => 'orgone@mail.com',
                'contact_number' => '973434533',
                'sub_domain' => 'orgone',
                'logo' => null,
                'status' => 'ACTIVE',
            ],
            [
                'curr_subscription_id' => $subscriptionTwo->id,
                'org_admin_id' => 10,
                'name' => 'organization two',
                'contact_name' => 'org two',
                'contact_email' => 'orgtwo@mail.com',
                'contact_number' => '973434533',
                'sub_domain' => 'orgtwo',
                'logo' => null,
                'status' => 'INACTIVE',
            ],
        ];

        foreach ($organizationData as $data) {

            $organizationModel = OrganizationEloquentModel::create($data);

            $subdomain = Tenant::create([
                'id' => $organizationModel->sub_domain,
                'organization_id' => $organizationModel->id,
            ]);

            $subdomain->domains()->create(['domain' => $subdomain->id.'.'.env('CENTERAL_DOMAIN')]);
        }

        $orgUserFetch = UserEloquentModel::where('role_id', 5)->get();

        foreach($orgUserFetch as $org){
            B2bUserEloquentModel::create([
                'user_id' => $org->id,
                'organization_id' => 1,
                'allocated_storage_limit' => 0,
                'has_full_library_access' => false,
            ]);
        }
    }
}
