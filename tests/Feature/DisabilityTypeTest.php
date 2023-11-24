<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Disability\Application\Policies\DisabilityTypePolicy;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');

    $this->post('/login', [
        'email' => 'bcstaff@mail.com',
        'password' => 'password',
    ]);

});

test('can log out an authenticated user', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertStatus(302);
    $this->assertGuest();
});

test('without login not access disability type', function () {

    Auth::logout();

    $reponse = $this->get('/disability_type');
    $reponse->assertRedirect('/login');
});

test('without other role not access disability type', function () {

    Auth::logout();

    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 6,
        'email_verification_send_on' => Carbon::now(),
    ]);

    if (Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password'])) {
        $reponse = $this->get('/disability_type');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/disability_type');
    $reponse->assertStatus(403);
});

test('read disability type with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('view', DisabilityTypePolicy::class)); // permission check

    $reponse = $this->get('/disability_type');

    $reponse->assertStatus(200);
});

test('cannot access read disability type with other roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertTrue(authorize('view', DisabilityTypePolicy::class)); // permission check

    $response = $this->get('/disability_type');

    $response->assertStatus(403);

});

test('create disability type with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('store', DisabilityTypePolicy::class)); // permission check

    $disability_type = $this->post('/disability_type', [
        'name' => 'Example',
        'description' => 'Disability type Description',
    ]);

    $disability_type->assertStatus(302);

    $storeData = $this->post('/disability_type', []);

    $storeData->assertSessionHasErrors(['name']);

    $disability_type->assertRedirect('/disability_type');
});

test('update disability type with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('update', DisabilityTypePolicy::class)); // permission check

    $disability_type = $this->post('/disability_type', [
        'name' => 'Example',
        'description' => 'Disability Type Description',
    ]);
    $id = 1;
    $disability_type->assertStatus(302);

    // Attempt to update the disability type

    $updateResponse = $this->put("/disability_type/{$id}", [
        'name' => 'Example disability type Update',
        'description' => 'disability type Description Update'
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/disability_type/{$id}", []);

    $updateData->assertSessionHasErrors(['name']);

    $disability_type->assertRedirect('/disability_type');
});

test('delete disability type with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('update', DisabilityTypePolicy::class)); // permission check

    $disability_type = $this->post('/disability_type', [
        'name' => 'Example',
        'description' => 'Disability Type Description',
    ]);

    $disability_type->assertStatus(302);

    $disability_type_id = 1; // Retrieve the survey ID as needed

    $deleteResponse = $this->delete("/disability_type/{$disability_type_id}");

    $deleteResponse->assertStatus(302);

    $disability_type->assertRedirect('/disability_type');
});
