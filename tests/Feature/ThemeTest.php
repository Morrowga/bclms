<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use Src\BlendedConcept\Disability\Application\Policies\ThemePolicy;
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

test('without login not access theme', function () {

    Auth::logout();

    $reponse = $this->get('/disability_themes');
    $reponse->assertRedirect('/login');
});

test('without other role not access themes', function () {

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
        $reponse = $this->get('/disability_themes');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/disability_themes');
    $reponse->assertStatus(403);
});

test('read theme with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('view', ThemePolicy::class)); // permission check

    $reponse = $this->get('/disability_themes');

    $reponse->assertStatus(200);
});

test('cannot access read theme with other roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertTrue(authorize('view', ThemePolicy::class)); // permission check

    $response = $this->get('/disability_themes');

    $response->assertStatus(403);

});

test('create theme with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('store', ThemePolicy::class)); // permission check

    $disability_theme = $this->post('/disability_themes', [
        'name' => 'Example',
        'description' => 'Disability Theme Description',
    ]);

    $disability_theme->assertStatus(302);

    $storeData = $this->post('/disability_themes', []);

    $storeData->assertSessionHasErrors(['name']);

    $disability_theme->assertRedirect('/disability_themes');
});

test('update Themes with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('update', ThemePolicy::class)); // permission check

    $disability_themes = $this->post('/disability_themes', [
        'name' => 'Example',
        'description' => 'Disability Type Description',
    ]);
    $id = 1;
    $disability_themes->assertStatus(302);

    // Attempt to update the themes

    $updateResponse = $this->put("/disability_themes/{$id}", [
        'name' => 'Example Game Update',
        'description' => 'Game Description Update'
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/disability_themes/{$id}", []);

    $updateData->assertSessionHasErrors(['name']);

    $disability_themes->assertRedirect('/disability_themes');
});

test('delete theme with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('update', ThemePolicy::class)); // permission check

    $disability_themes = $this->post('/disability_themes', [
        'name' => 'Example',
        'description' => 'Disability Type Description',
    ]);

    $disability_themes->assertStatus(302);

    $themeIds = 1; // Retrieve the survey ID as needed

    $deleteResponse = $this->delete("/disability_themes/{$themeIds}");

    $deleteResponse->assertStatus(302);

    $disability_themes->assertRedirect('/disability_themes');
});
