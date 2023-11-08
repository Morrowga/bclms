<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Symfony\Component\HttpFoundation\Response;

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

test('without login not access organisation teacher', function () {

    Auth::logout();

    $reponse = $this->get('/organisations-teacher');
    $reponse->assertRedirect('/login');
});

test('without other role not access organisations teacher', function () {

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
        $reponse = $this->get('/organisations-teacher');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/organisations-teacher');
    $reponse->assertStatus(403);
});

test('create org teacher with org admin roles', function () {

    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $image = UploadedFile::fake()->image('image.jpg'); // Change 'test.jpg' to the desired file name and extension

    $response = $this->post('/organisations-teacher', [
        'first_name' => 'Example',
        'last_name' => 'Teacher',
        'email' => 'teacher@mail.com',
        'contact_number' => '0912345678',
        'image' => $image,
    ]);

    $response->assertStatus(302);

    $storeData = $this->post('/organisations-teacher', []);

    $storeData->assertSessionHasErrors(['first_name', 'last_name', 'email', 'contact_number']);

    // Roll back the transaction to undo any database changes made during the test
});

test('update teacher with org admin roles', function () {
    // Start a database transaction for the test
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    // Extract the teacher ID from the response or retrieve it from the database
    $teacherId = 1; // Retrieve the teacher ID as needed

    $updateImage = UploadedFile::fake()->image('updateacher.jpg'); // Change 'test.jpg' to the desired file name and extension

    $updateResponse = $this->put("/organisations-teacher/{$teacherId}", [
        'first_name' => 'Example',
        'last_name' => 'Device',
        'email' => 'teacher@mail.com',
        'contact_number' => '0912345678',
        'image' => null,
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/organisations-teacher/{$teacherId}", []);

    $updateData->assertSessionHasErrors(['first_name', 'last_name', 'email', 'contact_number']);
});

test('delete org teacher with org admin roles', function () {
    // Start a database transaction for the test
$user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated
    // Extract the survey ID from the response or retrieve it from the database
    $teacherId = 1; // Retrieve the teacher ID as needed

    // Attempt to delete the teacher
    $deleteResponse = $this->delete("/organisations-teacher/{$teacherId}");

    $deleteResponse->assertStatus(302);
});
