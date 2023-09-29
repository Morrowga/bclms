<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\Tenant;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationAdminEloquentModel;

class OrganisationAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
                'role_id' => 5,
                'first_name' => 'Org',
                'last_name' => 'One',
                'email' => 'orgone@mail.com',
                'password' => bcrypt('password'),
                'contact_number' => '1234567890',
                'status' => 'ACTIVE',
                'email_verification_send_on' => now(),
                'profile_pic' => 'images/profile/profilefive.png',
            // [
            //     'role_id' => 5,
            //     'first_name' => 'Org',
            //     'last_name' => 'Two',
            //     'email' => 'orgtwo@mail.com',
            //     'password' => bcrypt('password'),
            //     'contact_number' => '1234567890',
            //     'status' => 'ACTIVE',
            //     'email_verification_send_on' => now(),
            //     'profile_pic' => 'images/profile/profilefive.png',
            // ],
        ];

        $userCreate = UserEloquentModel::create($user);
        // [
        //     'curr_subscription_id' => $subscriptionTwo->id,
        //     'org_admin_id' => 10,
        //     'name' => 'organisation two',
        //     'contact_name' => 'org two',
        //     'contact_email' => 'orgtwo@mail.com',
        //     'contact_number' => '973434533',
        //     'sub_domain' => 'orgtwo',
        //     'logo' => null,
        //     'status' => 'INACTIVE',
        // ]

        $subscriptionData = [
            'start_date' => now(),
            'end_date' => now(),
            'payment_date' => now(),
            'payment_status' => 'PAID',
            'stripe_status' => null,
            'stripe_price' => null,
        ];

        $subscriptionOne = SubscriptionEloquentModel::create($subscriptionData);

        $organisationData = [
            'curr_subscription_id' => $subscriptionOne->id,
            'org_admin_id' => $userCreate->id,
            'name' => 'organisation one',
            'contact_name' => 'org one',
            'contact_email' => 'orgone@mail.com',
            'contact_number' => '973434533',
            'sub_domain' => 'orgone',
            'logo' => null,
            'status' => 'ACTIVE',
        ];

        $organisationModel = OrganisationEloquentModel::create($organisationData);

        $subdomain = Tenant::create([
            'id' => $organisationModel->sub_domain,
            'organisation_id' => $organisationModel->id,
        ]);

        $subdomain->domains()->create(['domain' => $subdomain->id.'.'.env('CENTERAL_DOMAIN')]);

    $org_admin = OrganisationAdminEloquentModel::create([
            'user_id' => $userCreate->id,
            'organisation_id' => $organisationModel->id
        ]);
    }
}
