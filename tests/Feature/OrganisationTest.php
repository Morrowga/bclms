<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
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

test('superadmin create organizagion', function () {

    $this->assertTrue(Auth::check());

    $reponse = $this->get('/organisations');
    $reponse->assertStatus(200);
});

test('without login not access organisation', function () {

    Auth::logout();

    $reponse = $this->get('/organisations');
    $reponse->assertRedirect('/login');
});

test('without other role not access organisation  ', function () {

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
        $reponse = $this->get('/organisations');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/organisations');
    $reponse->assertStatus(403);
});

test('form submit as organisation with superadmin role', function () {

    $this->assertTrue(Auth::check());

    $response = $this->get('/organisations');
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
    $subscriptionData = [
        'start_date' => now(),
        'end_date' => now(),
        'payment_date' => now(),
        'payment_status' => 'PAID',
        'stripe_status' => null,
        'stripe_price' => null,
    ];

    $subscriptionOne = SubscriptionEloquentModel::create($subscriptionData);
    $postData = $this->post('/organisations', [
        'curr_subscription_id' => $subscriptionOne->id,
        'org_admin_id' => $user->id,
        'name' => 'organisation test',
        'contact_name' => 'org test',
        'contact_email' => 'orgtest@mail.com',
        'contact_number' => '973434533',
        'sub_domain' => 'orgtest',
        'logo' => null,
        'status' => 'ACTIVE',
    ]);

    $postData->assertStatus(302);

    $this->assertDatabaseHas(
        'organisations',
        [
            'curr_subscription_id' => 5,
            'org_admin_id' => 1,
            'name' => 'organisation one',
            'contact_name' => 'org one',
            'contact_email' => 'orgone@mail.com',
            'contact_number' => '973434533',
            'sub_domain' => 'orgone',
            'logo' => null,
            'status' => 'ACTIVE',
        ]
    );

    $postData = $this->post('/organisations', []);
    $postData->assertSessionHasErrors(['name', 'contact_email', 'org_admin_name', 'org_admin_contact_number', 'login_email', 'login_password']);
});

test('form update as organisation with superadmin role', function () {

    $this->assertTrue(Auth::check());

    $response = $this->get('/organisations');
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
    $subscriptionData = [
        'start_date' => now(),
        'end_date' => now(),
        'payment_date' => now(),
        'payment_status' => 'PAID',
        'stripe_status' => null,
        'stripe_price' => null,
    ];

    $subscriptionOne = SubscriptionEloquentModel::create($subscriptionData);
    $organizatonData = OrganisationEloquentModel::create([
        'curr_subscription_id' => $subscriptionOne->id,
        'org_admin_id' => $user->id,
        'name' => 'organisation test',
        'contact_name' => 'org test',
        'contact_email' => 'orgtest@mail.com',
        'contact_number' => '973434533',
        'sub_domain' => 'orgtest',
        'logo' => null,
        'status' => 'ACTIVE',
    ]);
    $updateData = $this->put("/organisations/$organizatonData->id", [
        'name' => 'organisation test update',
        'contact_name' => 'org test update',
        'contact_email' => 'orgtestupate@mail.com',
        'contact_number' => '23423423',
        'sub_domain' => 'orgtestupdate',
        'logo' => null,
        'status' => 'INACTIVE',
    ]);
    $updateData->assertStatus(302);

    $this->assertDatabaseHas(
        'organisations',
        [
            'curr_subscription_id' => 5,
            'org_admin_id' => 1,
            'name' => 'organisation one',
            'contact_name' => 'org one',
            'contact_email' => 'orgone@mail.com',
            'contact_number' => '973434533',
            'sub_domain' => 'orgone',
            'logo' => null,
            'status' => 'ACTIVE',
        ]
    );

    $postData = $this->put("/organisations/$organizatonData->id", []);
    $postData->assertSessionHasErrors(['name', 'contact_email', 'org_admin_name', 'org_admin_contact_number', 'login_email']);
});

test('delete organisation', function () {
    $this->assertTrue(Auth::check());

    $response = $this->get('/organisations');
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
    $subscriptionData = [
        'start_date' => now(),
        'end_date' => now(),
        'payment_date' => now(),
        'payment_status' => 'PAID',
        'stripe_status' => null,
        'stripe_price' => null,
    ];

    $subscriptionOne = SubscriptionEloquentModel::create($subscriptionData);
    $organizatonData = OrganisationEloquentModel::create([
        'curr_subscription_id' => $subscriptionOne->id,
        'org_admin_id' => $user->id,
        'name' => 'organisation test',
        'contact_name' => 'org test',
        'contact_email' => 'orgtest@mail.com',
        'contact_number' => '973434533',
        'sub_domain' => 'orgtest',
        'logo' => null,
        'status' => 'ACTIVE',
    ]);
    $deletePost = $this->delete("/organisations/{$organizatonData->id}");
    $deletePost->assertStatus(302);
});