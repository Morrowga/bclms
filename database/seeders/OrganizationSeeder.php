<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\Tenant;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
                'org_admin_id' => 5,
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
                'org_admin_id' => 6,
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
                'id' => $organizationModel->name,
                'organization_id' => $organizationModel->id,
            ]);

            $subdomain->domains()->create(['domain' => $subdomain->id . '.' . env('CENTERAL_DOMAIN')]);
        }
    }
}
