<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationAdminEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');
});

test('superadmin create organisation', function () {

    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

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

    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $postData = $this->post('/organisations', [
        'login_email' => 'testorgadmin@gmail.com',
        'login_password' => 'password',
        'org_admin_name' => 'testing name',
        'org_admin_contact_number' => '09234244',
        'name' => 'organisation test',
        'contact_name' => 'org test',
        'contact_email' => 'orgtest@mail.com',
        'contact_number' => '97343453',
        'sub_domain' => 'orgtest',
        'logo' => null,
        'status' => 'ACTIVE',
    ]);

    $postData->assertStatus(302);

    $postData = $this->post('/organisations', []);

    $postData->assertSessionHasErrors(['name', 'contact_email', 'org_admin_name', 'org_admin_contact_number', 'login_email', 'login_password']);
});

test('form update as organisation with superadmin role', function () {

    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $response = $this->get('/organisations');

    $response->assertStatus(200);

    $postData = $this->post('/organisations', [
        'login_email' => 'testorgadmin@gmail.com',
        'login_password' => 'password',
        'org_admin_name' => 'testing name',
        'org_admin_contact_number' => '09234244',
        'name' => 'organisation test',
        'contact_name' => 'org test',
        'contact_email' => 'orgtest@mail.com',
        'contact_number' => '97343453',
        'sub_domain' => 'orgtest',
        'logo' => null,
        'status' => 'ACTIVE',
    ]);

    $postData->assertStatus(302);

    $updateData = $this->put("/organisations/2", [
        'name' => 'organisation test update',
        'contact_name' => 'org test update',
        'contact_email' => 'orgtestupate@mail.com',
        'contact_number' => '23423423',
        'sub_domain' => 'orgtestupdate',
        'logo' => null,
        'status' => 'INACTIVE',
    ]);

    $updateData->assertStatus(302);

    $updateData = $this->put("/organisations/2", []);

    $updateData->assertSessionHasErrors(['name', 'contact_email', 'org_admin_name', 'org_admin_contact_number', 'login_email']);
});

test('delete organisation', function () {
    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $response = $this->get('/organisations');
    $response->assertStatus(200);

    $postData = $this->post('/organisations', [
        'login_email' => 'testorgadmin@gmail.com',
        'login_password' => 'password',
        'org_admin_name' => 'testing name',
        'org_admin_contact_number' => '09234244',
        'name' => 'organisation test',
        'contact_name' => 'org test',
        'contact_email' => 'orgtest@mail.com',
        'contact_number' => '97343453',
        'sub_domain' => 'orgtest',
        'logo' => null,
        'status' => 'ACTIVE',
    ]);

    $postData->assertStatus(302);

    $deletePost = $this->delete("/organisations/2");

    $deletePost->assertStatus(302);
});
