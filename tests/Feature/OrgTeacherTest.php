<?php

use Carbon\Carbon;
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

    //login as superadmin
    $this->post('/login', [
        'email' => 'orgone@mail.com',
        'password' => 'password',
    ]);
});

test('without login not access organization teacher', function () {

    Auth::logout();

    $reponse = $this->get('/organizations-teacher');
    $reponse->assertRedirect('/login');
});

test('without other role not access organizations teacher', function () {

    Auth::logout();

    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 3,
        'email_verification_send_on' => Carbon::now(),
    ]);

    if (Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password'])) {
        $reponse = $this->get('/organizations-teacher');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/organizations-teacher');
    $reponse->assertStatus(403);
});


test('create org teacher with org admin roles', function () {
    $this->assertTrue(Auth::check());

    $image = UploadedFile::fake()->image('image.jpg'); // Change 'test.jpg' to the desired file name and extension

    $response = $this->post('/organizations-teacher', [
        'first_name' => 'Example',
        'last_name' => 'Teacher',
        'email' => 'teacher@mail.com',
        'contact_number' => '0912345678',
        'image' => $image,
    ]);

    $response->assertStatus(302);

    $storeData = $this->post("/organizations-teacher", []);

    $storeData->assertSessionHasErrors(['first_name', 'last_name', 'email', 'contact_number', 'image']);

    $response->assertRedirect('/organizations-teacher');

    // Roll back the transaction to undo any database changes made during the test
});

test('update teacher with org admin roles', function () {
    // Start a database transaction for the test
    $this->assertTrue(Auth::check());

    $image = UploadedFile::fake()->image('image.jpg'); // Change 'test.jpg' to the desired file name and extension

    $response = $this->post('/organizations-teacher', [
        'first_name' => 'Example Update',
        'last_name' => 'Teacher',
        'email' => 'teacher@mail.com',
        'contact_number' => '987654321',
        'image' => $image,
    ]);

    $response->assertStatus(302);

    // Extract the survey ID from the response or retrieve it from the database
    $teacherId = 1; // Retrieve the survey ID as needed
    $updateImage = UploadedFile::fake()->image('updateacher.jpg'); // Change 'test.jpg' to the desired file name and extension

    $updateResponse = $this->put("/organizations-teacher/{$teacherId}", [
        'first_name' => 'Example',
        'last_name' => 'Device',
        'email' => 'teacher@mail.com',
        'contact_number' => '0912345678',
        'image' => $updateImage,
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/organizations-teacher/{$teacherId}", []);

    $updateData->assertSessionHasErrors(['first_name', 'last_name', 'email', 'contact_number']);

    $response->assertRedirect('/organizations-teachers');
});

// test('delete game with bcstaff roles', function () {
//     // Start a database transaction for the test
//     $this->assertTrue(Auth::check());

//     $thumbFile = UploadedFile::fake()->image('thumb.jpg'); // Change 'test.jpg' to the desired file name and extension

//     $gameFile = UploadedFile::fake()->image('game.jpg'); // Change 'test.jpg' to the desired file name and extension

//     $disability_type = $this->post('/disability_type', [
//         'name' => 'Example',
//         'description' => 'Disability Type Description',
//     ]);

//     $disability_type->assertStatus(302);

//     $device = $this->post('/accessibility_device', [
//         'name' => 'Example Device',
//         'description' => 'Device Description',
//         'disability_types' => [1],
//         'status' => "INACTIVE",
//     ]);

//     $device->assertStatus(302);

//     $response = $this->post('/games', [
//         'name' => 'Example Game',
//         'description' => 'Game Description',
//         'thumb' => $thumbFile, // Use the created file instance
//         'game' => $gameFile, // Use the created file instance
//         'disability_type_id' => [1],
//         'devices' => [1],
//         'num_gold_coins' => 0,
//         'num_silver_coins' => 0,
//         'tags' => ['example', 'example2'],
//     ]);

//     $response->assertStatus(302);

//     // Extract the survey ID from the response or retrieve it from the database
//     $gameId = 1; // Retrieve the survey ID as needed

//     // Attempt to delete the survey
//     $deleteResponse = $this->delete("/games/{$gameId}");

//     $deleteResponse->assertStatus(302);
// });

