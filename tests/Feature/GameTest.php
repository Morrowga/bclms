<?php

use Carbon\Carbon;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');
});

test('without login not access game', function () {

    Auth::logout();

    $reponse = $this->get('/games');
    $reponse->assertRedirect('/login');
});

test('without other role not access games', function () {

    Auth::logout();

    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 4,
        'email_verification_send_on' => Carbon::now(),
    ]);

    if (Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password'])) {
        $reponse = $this->get('/games');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/games');
    $reponse->assertStatus(403);
});

test('can access game with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // check if the user is authenticated

    $response = $this->get('/games');

    $response->assertStatus(200);
});

test('create game with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $thumbFile = UploadedFile::fake()->image('thumb.jpg'); // Change 'test.jpg' to the desired file name and extension

    $gameFile = UploadedFile::fake()->create('game.zip', 1024); // Change 'test.zip' to the desired filename

    $disability_type = $this->post('/disability_type', [
        'name' => 'Example',
        'description' => 'Disability Type Description',
    ]);

    $disability_type->assertStatus(302);

    $device = $this->post('/accessibility_device', [
        'name' => 'Example Device',
        'description' => 'Device Description',
        'disability_types' => [1],
        'status' => 'INACTIVE',
    ]);

    $device->assertStatus(302);

    $response = $this->post('/games', [
        'name' => 'Example Game',
        'description' => 'Game Description',
        'thumb' => $thumbFile, // Use the created file instance
        'game' => $gameFile, // Use the created file instance
        'disability_type_id' => [1],
        'devices' => [1],
        'num_gold_coins' => 0,
        'num_silver_coins' => 0,
        'tags' => ['example', 'example2'],
    ]);

    $response->assertStatus(302);

    $storeData = $this->post('/games', []);

    $storeData->assertSessionHasErrors(['name', 'description', 'thumb', 'game', 'disability_type_id', 'devices', 'tags']);

    $response->assertRedirect('/games');
});

test('update game with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $thumbFile = UploadedFile::fake()->image('thumb.jpg'); // Change 'test.jpg' to the desired file name and extension

    $gameFile = UploadedFile::fake()->create('game.zip', 1024); // Change 'test.zip' to the desired filename

    $disability_type = $this->post('/disability_type', [
        'name' => 'Example',
        'description' => 'Disability Type Description',
    ]);

    $disability_type->assertStatus(302);

    $device = $this->post('/accessibility_device', [
        'name' => 'Example Device',
        'description' => 'Device Description',
        'disability_types' => [1],
        'status' => 'INACTIVE',
    ]);

    $device->assertStatus(302);

    $response = $this->post('/games', [
        'name' => 'Example Game',
        'description' => 'Game Description',
        'thumb' => $thumbFile, // Use the created file instance
        'game' => $gameFile, // Use the created file instance
        'disability_type_id' => [1],
        'devices' => [1],
        'num_gold_coins' => 0,
        'num_silver_coins' => 0,
        'tags' => ['example', 'example2'],
    ]);

    $response->assertStatus(302);

    // Extract the teacher ID from the response or retrieve it from the database
    $gameId = 1; // Retrieve the teacher ID as needed
    $thumbUpdateFile = UploadedFile::fake()->image('thumbUpdate.jpg'); // Change 'test.jpg' to the desired file name and extension

    $gameUpdateFile = UploadedFile::fake()->create('gameUpdate.zip', 1024); // Change 'test.zip' to the desired filename

    $update_disability_type = $this->post('/disability_type', [
        'name' => 'Example Update',
        'description' => 'Disability Type Description Update',
    ]);

    $update_disability_type->assertStatus(302);

    $update_device = $this->post('/accessibility_device', [
        'name' => 'Example Device Update',
        'description' => 'Device Description Update',
        'disability_types' => [2],
        'status' => 'INACTIVE',
    ]);

    $update_device->assertStatus(302);

    // Attempt to update the teacher

    $updateResponse = $this->put("/games/{$gameId}", [
        'name' => 'Example Game Update',
        'description' => 'Game Description Update',
        'thumb' => $thumbUpdateFile, // Use the created file instance
        'game' => $gameUpdateFile, // Use the created file instance
        'disability_type_id' => [2],
        'devices' => [2],
        'num_gold_coins' => 0,
        'num_silver_coins' => 0,
        'tags' => ['example update', 'example2 update'],
        // Add other fields you want to update here
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/games/{$gameId}", []);

    $updateData->assertSessionHasErrors(['name', 'description']);

    $response->assertRedirect('/games');
});

test('delete game with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $thumbFile = UploadedFile::fake()->image('thumb.jpg'); // Change 'test.jpg' to the desired file name and extension

    $gameFile = UploadedFile::fake()->create('gameUpdate.zip', 1024); // Change 'test.zip' to the desired filename

    $disability_type = $this->post('/disability_type', [
        'name' => 'Example',
        'description' => 'Disability Type Description',
    ]);

    $disability_type->assertStatus(302);

    $device = $this->post('/accessibility_device', [
        'name' => 'Example Device',
        'description' => 'Device Description',
        'disability_types' => [1],
        'status' => "INACTIVE",
    ]);

    $device->assertStatus(302);

    $response = $this->post('/games', [
        'name' => 'Example Game',
        'description' => 'Game Description',
        'thumb' => $thumbFile, // Use the created file instance
        'game' => $gameFile, // Use the created file instance
        'disability_type_id' => [1],
        'devices' => [1],
        'num_gold_coins' => 0,
        'num_silver_coins' => 0,
        'tags' => ['example', 'example2'],
    ]);

    $response->assertStatus(302);

    $gameId = 1; // Retrieve the survey ID as needed

    $deleteResponse = $this->delete("/games/{$gameId}");

    $deleteResponse->assertStatus(302);

    $response->assertRedirect('/games');
});
