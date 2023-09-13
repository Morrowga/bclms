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
test('only superadmin can access sitesetting and add settings', function () {

    $this->assertTrue(Auth::check());
    $response = $this->get('/settings');
    $response->assertStatus(200);

    $postData = $this->post('/settings', [
        'site_name' => 'Tiggie Kids',
        'ssl' => '',
        'site_time_zone' => 'UTC',
        'site_locale' => 'locale',
        'email' => 'admin@tiggiekid.com',
        'contact_number' => '6512345678',
        'url' => 'https://tiggiekid.com',
        'website_logo' => '',
        'website_favicon' => '',
    ]);

    $postData->assertStatus(200);
    $this->assertDatabaseHas('site_settings', [
        'site_name' => 'Tiggie Kids',
        'site_time_zone' => 'UTC',
    ]);
});

test('without login access site setting and other role', function () {
    Auth::logout();

    $response = $this->get('/settings');
    $response->assertRedirect('/login');

    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'user',
        'role_id' => 2,
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'email_verified_at' => Carbon::now(),
    ]);

    if (Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password'])) {
        $checkOtherRoles = $this->get('/settings');
        $checkOtherRoles->assertStatus(403);
    }
});
