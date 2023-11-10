<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2cSubscriptionEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2cUserEloquentModel;
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

// comment coz of disabled features
// test('superadmin create subscription', function () {

//     $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

//     $this->actingAs($user);

//     $this->assertAuthenticated(); // Check if the user is authenticated

//     $reponse = $this->get('/subscribptioninvoice');
//     $reponse->assertStatus(200);
// });

test('without login not access subscription', function () {

    Auth::logout();

    $reponse = $this->get('/subscribptioninvoice');
    $reponse->assertRedirect('/login');
});

test('without other role not access subscribptioninvoice  ', function () {

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
        $reponse = $this->get('/subscribptioninvoice');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/subscribptioninvoice');
    $reponse->assertStatus(403);
});

test('update b2b subscription', function () {
    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated
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
        'org_admin_id' => 1,
        'name' => 'organisation one',
        'contact_name' => 'org one',
        'contact_email' => 'orgone@mail.com',
        'contact_number' => '973434533',
        'sub_domain' => 'orgone',
        'logo' => null,
        'status' => 'ACTIVE',
    ];
    $userData = [
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 1,
        'email_verified_at' => Carbon::now(),
    ];
    $organisationEloquent = OrganisationEloquentModel::create($organisationData);
    $userCreate = UserEloquentModel::create($userData);
    // B2bUserEloquentModel::create([
    //     'user_id' => $userCreate->id,
    //     'organisation_id' => $organisationEloquent->id,
    //     'allocated_storage_limit' => 0,
    //     'has_full_library_access' => false,
    // ]);
    $updateSubscription = $this->put("subscribptioninvoice/$subscriptionOne->id/update/b2b", [
        'start_date' => now(),
        'end_date' => now(),
        'payment_status' => 'PAID',
        'stripe_status' => 'ACTIVE',
        'b2b_subscription' => [
            'storage_limit' => 10,
            'num_teacher_license' => 10,
            'num_student_license' => 10,
        ],
    ]);
    $updateSubscription->assertStatus(302);
});
test('update b2c subscription', function () {
    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $subscriptionData = [
        'start_date' => now(),
        'end_date' => now(),
        'payment_date' => now(),
        'payment_status' => 'PAID',
        'stripe_status' => null,
        'stripe_price' => null,
    ];
    $plan_data = [
        'name' => 'Free',
        'description' => '$$0/month',
        'storage_limit' => 1.00,
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
    $userData = [
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 1,
        'email_verified_at' => Carbon::now(),
    ];
    $planEloquent = PlanEloquentModel::create($plan_data);
    $subscriptionOne = SubscriptionEloquentModel::create($subscriptionData);
    $userCreate = UserEloquentModel::create($userData);
    // B2cUserEloquentModel::create([
    //     'user_id' => $userCreate->id,
    //     'current_subscription_id' => $subscriptionOne->id,
    // ]);
    B2cSubscriptionEloquentModel::create([
        'subscription_id' => $subscriptionOne->id,
        'user_id' => $userCreate->id,
        'plan_id' => $planEloquent->id,
    ]);
    $updateSubscription = $this->put("subscribptioninvoice/$subscriptionOne->id/update/b2c", [
        'start_date' => now(),
        'end_date' => now(),
        'payment_status' => 'PAID',
        'stripe_status' => 'ACTIVE',
        'b2b_subscription' => [
            'storage_limit' => 10,
            'num_teacher_license' => 10,
            'num_student_license' => 10,
        ],
    ]);
    $updateSubscription->assertStatus(302);
});
