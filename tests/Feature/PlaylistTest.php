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
        'email' => 'b2bteacher@mail.com',
        'password' => 'password',
    ]);
});

test('without login not access playlist', function () {

    Auth::logout();

    $reponse = $this->get('/playlists');
    $reponse->assertRedirect('/login');
});

test('without other role not access playlist', function () {

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
        $reponse = $this->get('/playlists');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/playlists');
    $reponse->assertStatus(403);
});


test('create playlist with org teacher roles', function () {
    $this->assertTrue(Auth::check());

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [1,2]
    ]);

    $response->assertStatus(302);

    $storeData = $this->post("/playlists", []);

    $storeData->assertSessionHasErrors(['name', 'student_id', 'image', 'storybooks']);

    $response->assertRedirect('/playlists');

    // Roll back the transaction to undo any database changes made during the test
});

test('update playlist with org teacher roles', function () {
    // Start a database transaction for the test
    $this->assertTrue(Auth::check());

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [1,2]
    ]);

    $response->assertStatus(302);

    // Extract the teacher ID from the response or retrieve it from the database
    $playlistId = 1; // Retrieve the teacher ID as needed

    $updatePlaylistImage = UploadedFile::fake()->image('updatePlaylistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    // Attempt to update the playlist

    $updateResponse = $this->put("/playlists/{$playlistId}", [
        'name' => 'Update Example Device',
        'student_id' => 1,
        'image' => $updatePlaylistImage,
        'teacher_id' => 11,
        'storybooks' => [3,4]
        // Add other fields you want to update here
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/playlists/{$playlistId}", []);

    $updateData->assertSessionHasErrors(['name', 'student_id', 'storybooks']);

    $response->assertRedirect('/playlists');
});

test('delete playlist with org teacher roles', function () {
    // Start a database transaction for the test
    $this->assertTrue(Auth::check());

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [1,2]
    ]);

    $response->assertStatus(302);

    // Extract the survey ID from the response or retrieve it from the database
    $playlistId = 1; // Retrieve the survey ID as needed

    // Attempt to delete the survey
    $deleteResponse = $this->delete("/playlists/{$playlistId}");

    $deleteResponse->assertStatus(302);
});

