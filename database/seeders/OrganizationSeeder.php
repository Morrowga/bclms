<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\PlanEloquentModel;
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
        $planData = [
                'name' => "default plan",
                'description' => "This is the description for the default plan.",
                'price' => 9.99,
                'payment_period' => 'monthly',
                'allocated_storage' => 10,
                'teacher_license' => true,
                'student_license' => true,
        ];

        $plan = PlanEloquentModel::create($planData);
        $organizationData = [
            [
                'plan_id' => $plan->id,
                'name' => "hmm",
                'description' => "This is the description for Organization 1.",
                'type' => "Type 1",
                'contact_person' => "Hmm ",
                'contact_email' => "hmm@gmail.com",
                'contact_number' => "1234567890",
            ],
            [
                'plan_id' => $plan->id,
                'name' => "hostmm",
                'description' => "This is the description for Organization 2.",
                'type' => "Type 2",
                'contact_person' => "Host Admin",
                'contact_email' => "hostadmin@gmail.com",
                'contact_number' => "0987654321",
            ],
        ];

        foreach ($organizationData as $data) {

            $organizationModel = OrganizationEloquentModel::create($data);

            $subdomain = Tenant::create([
                'id' => $organizationModel->name,
                'organization_id' => $organizationModel->id
            ]);

            $subdomain->domains()->create(['domain' => $subdomain->id . "." . env('CENTERAL_DOMAIN')]);

        }
    }
}
