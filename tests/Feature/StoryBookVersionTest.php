<?php

use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;

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

test('create storybook version with bcsubcriber roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $storybook_version = $this->post('/storybooksversions', [
        'storybook_id' => $createStoryBook->id,
        'name' => 'Example Version',
        'description' => 'Example Version Description',
    ]);

    $storybook_version->assertStatus(302);

    $storeData = $this->post('/storybooksversions', []);

    $storeData->assertSessionHasErrors(['storybook_id', 'name', 'description']);

});

test('update storybook version with bcsubcriber roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $storybook_version = $this->post('/storybooksversions', [
        'storybook_id' => $createStoryBook->id,
        'name' => 'Example Version',
        'description' => 'Example Version Description',
    ]);

    $storybook_version->assertStatus(302);

    $storyVersionId = 1;
    $updateStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $storybook_version = $this->put("/storybooksversions/{$storyVersionId}", [
        'storybook_id' => $updateStoryBook->id,
        'name' => 'Example Version',
        'description' => 'Example Version Description',
    ]);

    $storybook_version->assertStatus(302);

    $storeData = $this->put("/storybooksversions/{$storyVersionId}", []);

    $storeData->assertSessionHasErrors(['name']);

});

test('delete storybook version with bcsubscriber roles', function() {

    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $storybook_version = $this->post('/storybooksversions', [
        'storybook_id' => $createStoryBook->id,
        'name' => 'Example Version',
        'description' => 'Example Version Description',
    ]);

    $storybook_version->assertStatus(302);

    $storyVersionId = 1;

    $response = $this->delete("/storybooksversions/{$storyVersionId}");

    $response->assertStatus(302);

});

test('access storybook version assign with bcsubscriber roles', function() {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $storybookVersion = StoryBookVersionEloquentModel::create([
        'storybook_id' => $createStoryBook->id,
        'name' => 'Example Version',
        'description' => 'Example Version Description',
    ]);

    $response = $this->get("/teacher_storybook/{$createStoryBook->id}/v/{$storybookVersion->id}");

    $response->assertStatus(200);
});

test('assign storybook version with bcscriber roles', function() {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $createStoryBook = StoryBookEloquentModel::create([
        'name' => 'Toy Story 1',
        'description' => 'nice book',
        'thumbnail_img' => '/images/image2.png',
        'num_gold_coins' => 1,
        'num_silver_coins' => 10,
        'is_free' => true,
    ]);

    $storybookVersion = StoryBookVersionEloquentModel::create([
        'storybook_id' => $createStoryBook->id,
        'name' => 'Example Version',
        'description' => 'Example Version Description',
    ]);

    $response = $this->post('storybookassignment', [
        'storybook_version_id' => $storybookVersion->id,
        'student_ids' => [1]
    ]);
    $response->assertStatus(302);

    $assignEmptyData = $this->post('storybookassignment', []);

    $assignEmptyData->assertSessionHasErrors(['storybook_version_id']);


});
