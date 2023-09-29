<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');

    //login as superadmin
    $this->post('/login', [
        'email' => 'superadmin@mail.com',
        'password' => 'password',
    ]);
});

test('superadmin create announcement', function () {

    $this->assertTrue(Auth::check());

    $reponse = $this->get('/announcements');
    $reponse->assertStatus(200);
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

    $this->assertTrue(Auth::check());

    $response = $this->get('/announcements');
    $response->assertStatus(200);

    $postData = $this->post('/announcements', [
        'title' => 'announcement name',
        'icon' => 'mdi-alert',
        'message' => 'message here',
        'by' => 'Super Admin',
        'to' => 'B2B Teachers,B2C Users, Organisation Admin',
        'users' => json_encode([2, 3, 4, 5, 6, 7, 8]),
    ]);

    $postData->assertStatus(302);

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

    $postData = $this->post('/announcements', []);
    $postData->assertSessionHasErrors(['title', 'icon', 'message', 'by', 'to']);
});
