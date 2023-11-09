<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\StoryBook\Domain\Policies\RewardPolicy;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\RewardEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

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

test('without login not access rewards', function () {

    Auth::logout();

    $reponse = $this->get('/rewards');
    $reponse->assertRedirect('/login');
});

test('without other role not access rewards', function () {

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
        $reponse = $this->get('/rewards');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/rewards');
    $reponse->assertStatus(403);
});

test('read rewards with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('view', RewardPolicy::class)); // permission check

    $reponse = $this->get('/rewards');

    $reponse->assertStatus(200);
});

test('cannot access read rewards with other roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertTrue(authorize('view', RewardPolicy::class)); // permission check

    $response = $this->get('/rewards');

    $response->assertStatus(403);
});

test('create rewards with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $this->assertFalse(authorize('store', RewardPolicy::class)); // permission check

    $image = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension

    $reward = $this->post('/rewards', [
        'name' => 'Toy 1',
        'description' => 'nice Reward',
        'gold_coins_needed' => 1,
        'image' => $image,
        'silver_coins_needed' => 10,
        'rarity' => 'RARE',
    ])->assertStatus(302);

    $storeData = $this->post('/rewards', []);

    $storeData->assertSessionHasErrors(['name', 'gold_coins_needed', 'silver_coins_needed', 'rarity', 'image']);

    $reward->assertRedirect('/rewards');
});

// Need to Fix
test('update Reward with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('update', RewardPolicy::class)); // permission check

    $image = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension
    $reward = $this->post('/rewards', [
        'name' => 'Toy 1',
        'description' => 'nice Reward',
        'gold_coins_needed' => 1,
        'image' => $image,
        'silver_coins_needed' => 10,
        'rarity' => 'RARE',
    ])->assertStatus(302);

    $id = 1;
    $updateResponse = $this->put("/rewards/{$id}", [
        'name' => 'Toy 1',
        'description' => 'nice Reward',
        'gold_coins_needed' => 1,
        'image' => $image,
        'file_src' => $image,
        'silver_coins_needed' => 10,
        'rarity' => 'RARE'
    ]);

    $updateResponse->assertStatus(302);

    $storeData = $this->put("/rewards/{$id}", []);

    $storeData->assertSessionHasErrors(['name', 'gold_coins_needed', 'silver_coins_needed', 'rarity']);
});

test('change Reward status with bcstaff roles', function () {
    // Assuming you have a reward with a status to change
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $image = UploadedFile::fake()->image('test.jpg');

    // Create a reward with status 'ACTIVE'
    $reward = $this->post('/rewards', [
        'name' => 'Toy 1',
        'description' => 'nice Reward',
        'gold_coins_needed' => 1,
        'file_src' => $image,
        'silver_coins_needed' => 10,
        'rarity' => 'common',
    ])->assertStatus(302);

    $rewardId = 1; // Retrieve the reward ID as needed

    // Assuming your route for changing the status is '/changeRewardStatus/{id}' and uses 'PUT' or 'PATCH' method
    $changeStatus = $this->post("/changeRewardStatus/{$rewardId}");
});
