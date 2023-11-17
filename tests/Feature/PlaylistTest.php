<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentUserEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2cSubscriptionEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');
});

test('without login not access playlist', function () {

    Auth::logout();

    $reponse = $this->get('/playlists');
    $reponse->assertRedirect('/login');
});

test('except parent and teacher, without other role not access playlist', function () {

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
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [$createStoryBook->id],
    ]);

    $response->assertStatus(302);

    $storeData = $this->post('/playlists', []);

    $storeData->assertSessionHasErrors(['name', 'student_id', 'image', 'storybooks']);

    $response->assertRedirect('/playlists');
});

test('create playlist with parent roles', function () {
    $user = [
        'role_id' => 8,
        'first_name' => 'B2C',
        'last_name' => 'Parent',
        'email' => 'b2cparent@mail.com',
        'password' => bcrypt('password'),
        'contact_number' => '1234567890',
        'status' => 'ACTIVE',
        'email_verification_send_on' => now(),
        'profile_pic' => 'images/profile/profilefive.png',
    ];

    $userEloquent = UserEloquentModel::create($user);
    $planEloquent = PlanEloquentModel::find(1);
    $subscriptionEloquent = [
        'start_date' => now(),
        'end_date' => now(),
        'payment_date' => now(),
        'payment_status' => 'PAID',
        'stripe_status' => 'ACTIVE',
        'stripe_price' => $planEloquent->price,
    ];
    $subscriptionEloquent = SubscriptionEloquentModel::create($subscriptionEloquent);
    $parentEloquent = ParentUserEloquentModel::create([
        "user_id" => $userEloquent->id,
        "curr_subscription_id" => $subscriptionEloquent->id,
    ]);
    $b2cSubscripton = B2cSubscriptionEloquentModel::create([
        "parent_id" => $parentEloquent->teacher_id,
        "subscription_id" => $subscriptionEloquent->id,
        "plan_id" => $planEloquent->id
    ]);

    $this->actingAs($userEloquent);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [$createStoryBook->id],
    ]);

    $response->assertStatus(302);

    $storeData = $this->post('/playlists', []);

    $storeData->assertSessionHasErrors(['name', 'student_id', 'image', 'storybooks']);

    $response->assertRedirect('/playlists');
})->skip('disabled features');

test('create playlist with b2c teacher roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [$createStoryBook->id],
    ]);

    $response->assertStatus(302);

    $storeData = $this->post('/playlists', []);

    $storeData->assertSessionHasErrors(['name', 'student_id', 'image', 'storybooks']);

    $response->assertRedirect('/playlists');
});

test('update playlist with org teacher roles', function () {
    // Start a database transaction for the test
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [$createStoryBook->id],
    ]);

    $response->assertStatus(302);

    // Extract the teacher ID from the response or retrieve it from the database
    $playlistId = 1; // Retrieve the teacher ID as needed

    $updatePlaylistImage = UploadedFile::fake()->image('updatePlaylistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    // Attempt to update the playlist


    $otherStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 2',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $updateResponse = $this->put("/playlists/{$playlistId}", [
        'name' => 'Update Example Device',
        'student_id' => 1,
        'image' => $updatePlaylistImage,
        'teacher_id' => 11,
        'storybooks' => [$otherStoryBook->id],
        // Add other fields you want to update here
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/playlists/{$playlistId}", []);

    $updateData->assertSessionHasErrors(['name', 'student_id', 'storybooks']);

    $response->assertRedirect('/playlists');
});

test('update playlist with parent roles', function () {
    // Start a database transaction for the test
    $user = [
        'role_id' => 8,
        'first_name' => 'B2C',
        'last_name' => 'Parent',
        'email' => 'b2cparent@mail.com',
        'password' => bcrypt('password'),
        'contact_number' => '1234567890',
        'status' => 'ACTIVE',
        'email_verification_send_on' => now(),
        'profile_pic' => 'images/profile/profilefive.png',
    ];

    $userEloquent = UserEloquentModel::create($user);
    $planEloquent = PlanEloquentModel::find(1);
    $subscriptionEloquent = [
        'start_date' => now(),
        'end_date' => now(),
        'payment_date' => now(),
        'payment_status' => 'PAID',
        'stripe_status' => 'ACTIVE',
        'stripe_price' => $planEloquent->price,
    ];
    $subscriptionEloquent = SubscriptionEloquentModel::create($subscriptionEloquent);
    $parentEloquent = ParentUserEloquentModel::create([
        "user_id" => $userEloquent->id,
        "curr_subscription_id" => $subscriptionEloquent->id,
    ]);
    $b2cSubscripton = B2cSubscriptionEloquentModel::create([
        "parent_id" => $parentEloquent->teacher_id,
        "subscription_id" => $subscriptionEloquent->id,
        "plan_id" => $planEloquent->id
    ]);

    $this->actingAs($userEloquent);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [$createStoryBook->id],
    ]);

    $response->assertStatus(302);

    // Extract the teacher ID from the response or retrieve it from the database
    $playlistId = 1; // Retrieve the teacher ID as needed

    $updatePlaylistImage = UploadedFile::fake()->image('updatePlaylistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    // Attempt to update the playlist


    $otherStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 2',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $updateResponse = $this->put("/playlists/{$playlistId}", [
        'name' => 'Update Example Device',
        'student_id' => 1,
        'image' => $updatePlaylistImage,
        'teacher_id' => 11,
        'storybooks' => [$otherStoryBook->id],
        // Add other fields you want to update here
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/playlists/{$playlistId}", []);

    $updateData->assertSessionHasErrors(['name', 'student_id', 'storybooks']);

    $response->assertRedirect('/playlists');
})->skip('disabled feature');

test('update playlist with b2c teacher roles', function () {
    // Start a database transaction for the test
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [$createStoryBook->id],
    ]);

    $response->assertStatus(302);

    // Extract the teacher ID from the response or retrieve it from the database
    $playlistId = 1; // Retrieve the teacher ID as needed

    $updatePlaylistImage = UploadedFile::fake()->image('updatePlaylistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    // Attempt to update the playlist


    $otherStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 2',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $updateResponse = $this->put("/playlists/{$playlistId}", [
        'name' => 'Update Example Device',
        'student_id' => 1,
        'image' => $updatePlaylistImage,
        'teacher_id' => 11,
        'storybooks' => [$otherStoryBook->id],
        // Add other fields you want to update here
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/playlists/{$playlistId}", []);

    $updateData->assertSessionHasErrors(['name', 'student_id', 'storybooks']);

    $response->assertRedirect('/playlists');
});

test('delete playlist with org teacher roles', function () {
    // Start a database transaction for the test
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [$createStoryBook->id],
    ]);

    $response->assertStatus(302);

    // Extract the survey ID from the response or retrieve it from the database
    $playlistId = 1; // Retrieve the survey ID as needed

    // Attempt to delete the survey
    $deleteResponse = $this->delete("/playlists/{$playlistId}");

    $deleteResponse->assertStatus(302);
});

test('delete playlist with parent roles', function () {
    // Start a database transaction for the test
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [$createStoryBook->id],
    ]);

    $response->assertStatus(302);

    // Extract the survey ID from the response or retrieve it from the database
    $playlistId = 1; // Retrieve the survey ID as needed

    // Attempt to delete the survey
    $deleteResponse = $this->delete("/playlists/{$playlistId}");

    $deleteResponse->assertStatus(302);
});

test('delete playlist with b2c teacher roles', function () {
    // Start a database transaction for the test
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $playlistImage = UploadedFile::fake()->image('playlistimage.jpg'); // Change 'test.jpg' to the desired file name and extension

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $response = $this->post('/playlists', [
        'name' => 'Example Device',
        'student_id' => 1,
        'image' => $playlistImage,
        'storybooks' => [$createStoryBook->id],
    ]);

    $response->assertStatus(302);

    // Extract the survey ID from the response or retrieve it from the database
    $playlistId = 1; // Retrieve the survey ID as needed

    // Attempt to delete the survey
    $deleteResponse = $this->delete("/playlists/{$playlistId}");

    $deleteResponse->assertStatus(302);
});
