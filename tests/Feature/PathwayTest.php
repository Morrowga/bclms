<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use Src\BlendedConcept\StoryBook\Domain\Policies\PathwayPolicy;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
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

test('without login not access pathways', function () {

    Auth::logout();

    $reponse = $this->get('/pathways');
    $reponse->assertRedirect('/login');
});

test('without other role not access pathways', function () {

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
        $reponse = $this->get('/pathways');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/pathways');
    $reponse->assertStatus(403);
});

test('read pathways with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('view', PathwayPolicy::class)); // permission check

    $reponse = $this->get('/pathways');

    $reponse->assertStatus(200);
});

// comment coz of disable features
// test('cannot access read pathways with other roles', function () {
//     $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

//     // Log in as the existing user
//     $this->actingAs($user);

//     $this->assertAuthenticated(); // Check if the user is authenticated'

//     $this->assertTrue(authorize('view', PathwayPolicy::class)); // permission check

//     $response = $this->get('/pathways');

//     $response->assertStatus(403);

// });

test('create pathways with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('store', PathwayPolicy::class)); // permission check

    // $thumbUpdateFile = UploadedFile::fake()->image('thumbUpdate.jpg'); // Change 'test.jpg' to the desired file name and extension

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $pathway = $this->post('/pathways', [
        'name' => 'Example',
        'description' => 'Disability Theme Description',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'need_complete_in_order' => 1,
        'storybooks' => [$createStoryBook->id]
    ]);

    $pathway->assertStatus(302);

    $storeData = $this->post('/pathways', []);

    $storeData->assertSessionHasErrors(['name']);

    $pathway->assertRedirect('/pathways');
});

test('update Pathways with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('update', PathwayPolicy::class)); // permission check

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $pathway = $this->post('/pathways', [
        'name' => 'Example',
        'description' => 'Disability Theme Description',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'need_complete_in_order' => 1,
        'storybooks' => [$createStoryBook->id]
    ]);

    $id = 1;
    $pathway->assertStatus(302);

    // Attempt to update the themes
    $otherCreateStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $updateResponse = $this->put("/pathways/{$id}", [
        'name' => 'Example',
        'description' => 'Disability Theme Description',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'need_complete_in_order' => 1,
        'storybooks' => [$otherCreateStoryBook->id]
    ]);

    $updateResponse->assertStatus(302);

    $updateResponse->assertRedirect('/pathways');
});

test('delete Pathway with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('update', PathwayPolicy::class)); // permission check

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $pathways = $this->post('/pathways', [
        'name' => 'Example',
        'description' => 'Disability Theme Description',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'need_complete_in_order' => 1,
        'storybooks' => [$createStoryBook->id]
    ]);

    $pathways->assertStatus(302);

    $pathwayId = 1; // Retrieve the survey ID as needed

    $deleteResponse = $this->delete("/pathways/{$pathwayId}");

    $deleteResponse->assertStatus(302);

    $pathways->assertRedirect('/pathways');
});
