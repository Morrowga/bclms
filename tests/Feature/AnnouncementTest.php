<?php

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');
});

function asAdmin(): TestCase
{
    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    return test()->actingAs($user);
}

test('superadmin create announcement', function () {

    asAdmin()->get('/announcements')->assertOk();
});

test('without login not access announcement', function () {

    Auth::logout();

    $reponse = $this->get('/announcements');
    $reponse->assertRedirect('/login');
});

test('without other role not access announcement  ', function () {

    Auth::logout();
    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 6,
        'email_verified_at' => Carbon::now(),
    ]);

    if (Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password'])) {
        $reponse = $this->get('/announcements');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/announcements');
    $reponse->assertStatus(403);
});

test('form submit as announcement with superadmin role', function () {

    asAdmin()->get('/announcements')->assertOk();

    asAdmin()->post('/announcements', [
        'title' => 'announcement name',
        'icon' => 'mdi-alert',
        'message' => 'message here',
        'by' => 'Super Admin',
        'to' => 'B2B Teachers,B2C Users, Organisation Admin',
        'users' => json_encode([2, 3, 4, 5, 6, 7, 8]),
    ])->assertStatus(302);

    $this->assertDatabaseHas(
        'announcements',
        [
            'title' => 'announcement name',
            'icon' => 'mdi-alert',
            'message' => 'message here',
            'by' => 'Super Admin',
            'to' => 'B2B Teachers,B2C Users, Organisation Admin',
        ]
    );

    asAdmin()->post('/announcements', [])->assertSessionHasErrors(['title', 'icon', 'message', 'by', 'to']);
});
