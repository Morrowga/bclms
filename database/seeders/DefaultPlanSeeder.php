<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;

class DefaultPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planDatas = [
            [
                'name' => 'Free',
                'description' => '$$0/month',
                'storage_limit' => 0.00,
                'num_student_profiles' => 1,
                'allow_customisation' => false,
                'allow_personalisation' => false,
                'full_library_access' => false,
                'concurrent_access' => false,
                'weekly_learning_report' => false,
                'dedicated_student_report' => true,
                'status' => 'ACTIVE',
                'price' => 0,
                'payment_period' => 'MONTHLY',
            ],
            [
                'name' => 'Base',
                'description' => 'Free for 1 month.Then start at $$10/month',
                'storage_limit' => 0.00,
                'num_student_profiles' => 1,
                'allow_customisation' => false,
                'allow_personalisation' => false,
                'full_library_access' => true,
                'concurrent_access' => false,
                'weekly_learning_report' => true,
                'dedicated_student_report' => true,
                'status' => 'ACTIVE',
                'price' => 10,
                'payment_period' => 'MONTHLY',
            ],
            [
                'name' => 'Pro',
                'description' => 'Free for 1 month.Then start at $$50/month',
                'storage_limit' => 1,
                'num_student_profiles' => 1,
                'allow_customisation' => false,
                'allow_personalisation' => true,
                'full_library_access' => true,
                'concurrent_access' => false,
                'weekly_learning_report' => true,
                'dedicated_student_report' => true,
                'status' => 'ACTIVE',
                'price' => 50,
                'payment_period' => 'MONTHLY',
            ],
            [
                'name' => 'Premium',
                'description' => 'Free for 1 month.Then start at $$100/month',
                'storage_limit' => 5,
                'num_student_profiles' => 1,
                'allow_customisation' => true,
                'allow_personalisation' => true,
                'full_library_access' => true,
                'concurrent_access' => false,
                'weekly_learning_report' => true,
                'dedicated_student_report' => true,
                'status' => 'ACTIVE',
                'price' => 100,
                'payment_period' => 'MONTHLY',
            ],
        ];

        foreach ($planDatas as $data) {
            $planEloquent = PlanEloquentModel::create($data);
        }
    }
}
