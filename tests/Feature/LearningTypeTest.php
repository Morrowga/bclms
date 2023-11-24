<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Disability\Application\Policies\DisabilityTypePolicy;
use Src\BlendedConcept\Disability\Application\Policies\LearningNeedPolicy;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
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

test('without login not access learning_need', function () {

    Auth::logout();

    $reponse = $this->get('/learning_need');
    $reponse->assertRedirect('/login');
});

test('without other role not access learning need', function () {

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
        $reponse = $this->get('/learning_need');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/learning_need');
    $reponse->assertStatus(403);
});

test('read learning need with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('view', LearningNeedPolicy::class)); // permission check

    $reponse = $this->get('/learning_need');

    $reponse->assertStatus(200);
});

test('cannot access read learning need with other roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertTrue(authorize('view', LearningNeedPolicy::class)); // permission check

    $response = $this->get('/learning_need');

    $response->assertStatus(403);

});

test('create learning need with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('store', LearningNeedPolicy::class)); // permission check

    $learning_need = $this->post('/learning_need', [
        'name' => 'Example',
        'description' => 'learning need Description',
        'sub_learnings' => ['test sub learning type']
    ]);

    $learning_need->assertStatus(302);

    $storeData = $this->post('/learning_need', []);

    $storeData->assertSessionHasErrors(['name']);

    $learning_need->assertRedirect('/learning_need');
});

test('update learning need with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('update', LearningNeedPolicy::class)); // permission check

    $learning_need = $this->post('/learning_need', [
        'name' => 'Example',
        'description' => 'learning need Description',
        'sub_learnings' => ['sub learning type'],
    ]);
    $id = 1;
    $learning_need->assertStatus(302);

    // Attempt to update the learning need

    $updateResponse = $this->put("/learning_need/{$id}", [
        'name' => 'Example learning need Update',
        'description' => 'learning need Description Update',
        'sub_learnings' => [['id'=> null, 'name' => 'test sub leaening type']],
        'delete_sub_learnings' => [1]
    ]);
    $updateResponse->assertStatus(302);

    $updateData = $this->put("/learning_need/{$id}", []);

    $updateData->assertSessionHasErrors(['name']);

    $learning_need->assertRedirect('/learning_need');
});

test('delete learning need with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('update', LearningNeedPolicy::class)); // permission check

    $learning_need = $this->post('/learning_need', [
        'name' => 'Example',
        'description' => 'Disability Type Description',
        'sub_learnings' => ['Test Sub Learning Type']
    ]);

    $learning_need->assertStatus(302);

    $learning_need_id = 1; // Retrieve the learning ID as needed

    $deleteResponse = $this->delete("/learning_need/{$learning_need_id}");

    $deleteResponse->assertStatus(302);

    $learning_need->assertRedirect('/learning_need');
});
