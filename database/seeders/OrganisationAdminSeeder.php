<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2bSubscriptionEloquentModel;
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
        ];

        $userCreate = UserEloquentModel::create($user);

        $subscriptionData = [
            'start_date' => now(),
            'end_date' => now(),
            'payment_date' => now(),
            'payment_status' => 'PAID',
            'stripe_status' => null,
            'stripe_price' => 1200.51,
        ];

        $subscriptionOne = SubscriptionEloquentModel::create($subscriptionData);

        $organisationData = [
            'curr_subscription_id' => $subscriptionOne->id,
            'org_admin_id' => null,
            'name' => 'organisation one',
            'contact_name' => 'org one',
            'contact_email' => 'orgone@mail.com',
            'contact_number' => '973434533',
            'sub_domain' => 'orgtwo',
            'logo' => null,
            'status' => 'ACTIVE',
        ];

        $organisationModel = OrganisationEloquentModel::create($organisationData);
        $b2bSubscriptionEloquent = new B2bSubscriptionEloquentModel();
        $b2bSubscriptionEloquent->subscription_id = $subscriptionOne->id;
        $b2bSubscriptionEloquent->organisation_id = $organisationModel->id;
        $b2bSubscriptionEloquent->storage_limit = 500;
        $b2bSubscriptionEloquent->num_student_license = 10;
        $b2bSubscriptionEloquent->num_teacher_license = 10;
        $b2bSubscriptionEloquent->save();
        $subdomain = Tenant::create([
            'id' => $organisationModel->sub_domain,
            'organisation_id' => $organisationModel->id,
        ]);

        $subdomain->domains()->create(['domain' => $subdomain->id . '.' . env('CENTERAL_DOMAIN')]);

        $org_admin = OrganisationAdminEloquentModel::create([
            'user_id' => $userCreate->id,
            'organisation_id' => $organisationModel->id
        ]);
        $organisationModel->update([
            "org_admin_id" => $org_admin->org_admin_id
        ]);
    }
}
