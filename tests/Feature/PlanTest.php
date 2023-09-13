<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Security\Application\Mappers\UserMapper;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');

    //login as superadmin
    $this->post('/login', [
        'email' => 'superadmin@mail.com',
        'password' => 'password',
    ]);
});

test('superadmin create plan', function () {

    $this->assertTrue(Auth::check());

    $reponse = $this->get('/plans');
    $reponse->assertStatus(200);
});

test('without login not access plan', function () {

    Auth::logout();

    $reponse = $this->get('/plans');
    $reponse->assertRedirect('/login');
});

test('without other role not access plans  ', function () {

    Auth::logout();
    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 6,
        'email_verified_at' => Carbon::now(),
    ]);

    if (Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password'])) {
        $reponse = $this->get('/plans');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/plans');
    $reponse->assertStatus(403);
});

test('form submit as plan with superadmin role', function () {

    $this->assertTrue(Auth::check());

    $response = $this->get('/plans');
    $response->assertStatus(200);
    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 1,
        'email_verified_at' => Carbon::now(),
    ]);

    $postData = $this->post('/plans', [
        'name' => 'Test',
        'description' => '$$0/month',
        'storage_limit' => null,
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
    ]);

    $postData->assertStatus(302);

    $this->assertDatabaseHas(
        'plans',
        [
            'name' => 'Free',
            'description' => '$$0/month',
            'storage_limit' => null,
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
        ]
    );

    $postData = $this->post('/plans', []);
    $postData->assertSessionHasErrors(['name', 'storage_limit', 'num_student_profiles', 'price']);
});

test('form update as plan with superadmin role', function () {

    $this->assertTrue(Auth::check());

    $response = $this->get('/plans');
    $response->assertStatus(200);
    $planData =  [
        'name' => 'Free',
        'description' => '$$0/month',
        'storage_limit' => null,
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
    ];
    $planEloquent = PlanEloquentModel::create($planData);
    $updateData = $this->put("/plans/$planEloquent->id", [
        'name' => 'Premium',
        'description' => '$$0/month',
        'storage_limit' => null,
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
    ]);
    $updateData->assertStatus(302);

    $this->assertDatabaseHas(
        'plans',
        [
            'name' => 'Free',
            'description' => '$$0/month',
            'storage_limit' => null,
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
        ]
    );

    $postData = $this->put("/plans/$planEloquent->id", []);
    $postData->assertSessionHasErrors(['name', 'storage_limit', 'num_student_profiles', 'price']);
});

test('activate plan status', function () {
    $planData =  [
        'name' => 'Free',
        'description' => '$$0/month',
        'storage_limit' => null,
        'num_student_profiles' => 1,
        'allow_customisation' => false,
        'allow_personalisation' => false,
        'full_library_access' => false,
        'concurrent_access' => false,
        'weekly_learning_report' => false,
        'dedicated_student_report' => true,
        'status' => 'INACTIVE',
        'price' => 0,
        'payment_period' => 'MONTHLY',
    ];
    $planEloquent = PlanEloquentModel::create($planData);
    $updateData = $this->put("/plans/$planEloquent->id/change_status", [
        "status" => "ACTIVE"
    ]);
    $updateData->assertStatus(302);
});

test('inactivate plan status', function () {
    $planData =  [
        'name' => 'Free',
        'description' => '$$0/month',
        'storage_limit' => null,
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
    ];
    $planEloquent = PlanEloquentModel::create($planData);
    $updateData = $this->put("/plans/$planEloquent->id/change_status", [
        "status" => "INACTIVE"
    ]);
    $updateData->assertStatus(302);
});
