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

    // Extract the teacher ID from the response or retrieve it from the database
    $teacherId = 11; // Retrieve the teacher ID as needed

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
});

test('delete org teacher with org admin roles', function () {
    // Start a database transaction for the test
    $this->assertTrue(Auth::check());

    // Extract the survey ID from the response or retrieve it from the database
    $teacherId = 11; // Retrieve the teacher ID as needed

    // Attempt to delete the teacher
    $deleteResponse = $this->delete("/organizations-teacher/{$teacherId}");

    $deleteResponse->assertStatus(302);
});

