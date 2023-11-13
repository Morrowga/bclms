<?php

use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\System\Application\Policies\TechSupportPolicy;
use Src\BlendedConcept\System\Domain\Model\Entities\TechnicalSupport;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');
});

test('can log out an authenticated user', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertStatus(302);
    $this->assertGuest();
});

test('access technical support with bcsubscriber roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('view', TechSupportPolicy::class)); // permission check

    $reponse = $this->get('/techsupports');

    $reponse->assertStatus(200);
});

test('cannot access technical support with other roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertTrue(authorize('view', TechSupportPolicy::class)); // permission check

    $response = $this->get('/techsupports');

    $response->assertStatus(403);

});

test('create support ticket with bcsubscriber roles', function() {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $this->assertFalse(authorize('create', TechSupportPolicy::class));

    $response = $this->post('/techsupports', [
        'question'=> 'Test Question'
    ]);
    $response->assertStatus(302);

    $storeEmptyData = $this->post('techsupports', []);

    $storeEmptyData->assertSessionHasErrors(['question']);

    $response->assertRedirect('/techsupports');

});

test('access support ticket with super admin roles', function() {
    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $this->assertFalse(authorize('edit', TechSupportPolicy::class));

    $response = $this->get('/supports');

    $response->assertStatus(200);
});

test('answer support ticket with super admin roles', function() {
    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $this->assertFalse(authorize('edit', TechSupportPolicy::class));

    $response = $this->post('/techsupports', [
        'question'=> 'Test Question'
    ]);
    $response->assertStatus(302);

    $ticketId = 1;

    $updateResponse = $this->put("techsupports/{$ticketId}", [
        'response' => 'Test Response'
    ]);

    $updateResponse->assertStatus(200);

    $updateEmptyData = $this->put("/techsupports/{$ticketId}", []);

    $updateEmptyData->assertSessionHasErrors(['response']);

});


test('delete support ticket with super admin roles', function() {
    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $this->assertFalse(authorize('destroy', TechSupportPolicy::class));

    $response = $this->post('/techsupports', [
        'question'=> 'Test Question'
    ]);
    $response->assertStatus(302);

    $ticketId = 1;

    $deleteResponse = $this->delete("/techsupports/{$ticketId}");

    $deleteResponse->assertStatus(302);

});
