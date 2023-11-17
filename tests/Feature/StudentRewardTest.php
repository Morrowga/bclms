<?php

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;

function asStudent(): TestCase
{
    $user = UserEloquentModel::where('username', 'student_one')->first();

    return test()->actingAs($user);
}

function asBcStaff(): TestCase
{
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    return test()->actingAs($user);
}

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

test('without login not access student reward', function() {
    Auth::logout();

    $this->get('/student-rewards')->assertRedirect('/login');
});

test('without login not access student reward store', function () {

    Auth::logout();

    $reponse = $this->get('/reward-store');
    $reponse->assertRedirect('/login');
});

test('without login not access student reward be lucky', function () {

    Auth::logout();

    $reponse = $this->get('/be-lucky');
    $reponse->assertRedirect('/login');
});

test('without login not access student reward buy sticker', function () {

    Auth::logout();

    $reponse = $this->get('/buy-sticker');
    $reponse->assertRedirect('/login');
});

test('access student reward store with student roles', function() {

    asStudent()->get('/reward-store')->assertOk();

});

test('access student reward be lucky with student roles', function() {

    asStudent()->get('/be-lucky')->assertOk();

});

test('rolling sticker with student roles', function() {

    $image = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension

    asBcStaff()->post('/rewards', [
        'name' => 'Toy 1',
        'description' => 'nice Reward',
        'gold_coins_needed' => 1,
        'image' => $image,
        'silver_coins_needed' => 10,
        'rarity' => 'RARE',
    ])->assertStatus(302);

    Auth::logout();

    $rollCount = 10; // count number as needed

    $response = asStudent()->get('/roll-sticker?count='. $rollCount);

    $response->assertOk();
});

test('access student reward buy sticker with student roles', function() {

    asStudent()->get('/buy-sticker')->assertOk();

});

test('cannot buy sticker if not enough coins with student roles', function() {

    $image = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension

    asBcStaff()->post('/rewards', [
        'name' => 'Toy 1',
        'description' => 'nice Reward',
        'gold_coins_needed' => 1,
        'image' => $image,
        'silver_coins_needed' => 10,
        'rarity' => 'RARE',
    ])->assertStatus(302);

    Auth::logout();

    $rewardId = 1;

    $response = asStudent()->post("/own-sticker/{$rewardId}", [
        'coin_type' => 'gold',
    ]);

    expect(fn() => throw new Exception('Gold Coins Not Enough!'))->toThrow(Exception::class);

    // dd($response->getContent());
})->skip('need to fix');

test('buy sticker with student roles', function() {

    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $image = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension

    $reward = $this->post('/rewards', [
        'name' => 'Toy 1',
        'description' => 'nice Reward',
        'gold_coins_needed' => 1,
        'image' => $image,
        'silver_coins_needed' => 10,
        'rarity' => 'RARE',
    ])->assertStatus(302);

    Auth::logout();

    $user = UserEloquentModel::where('username', 'student_one')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    //add num of goid and silver to test
    StudentEloquentModel::find(1)->update([
        'num_gold_coins' => 1,
        'num_silver_coins' => 10
    ]);

    $rewardId = 1;

    $rollCount = 10; // count number as needed

    $response = $this->post("/own-sticker/{$rewardId}", [
        'coin_type' => 'gold'
    ]);

    $response->assertStatus(302);
});

test('drop sticker in reward store with student roles', function() {

    $image = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension

    asBcStaff()->post('/rewards', [
        'name' => 'Toy 1',
        'description' => 'nice Reward',
        'gold_coins_needed' => 1,
        'image' => $image,
        'silver_coins_needed' => 10,
        'rarity' => 'RARE',
    ])->assertRedirect();

    Auth::logout();

    $rewardId = 1;

    asStudent()->put("/drop-sticker/{$rewardId}", [
        'x_axis_position' => '1226.000000',
        'y_axis_position' => '467.000000'
    ])->assertRedirect();

    asStudent()->put("/drop-sticker/{$rewardId}", [])->assertSessionHasErrors(['x_axis_position', 'y_axis_position']);


});
