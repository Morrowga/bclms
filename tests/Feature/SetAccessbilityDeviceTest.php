<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

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

test('without login not access set device', function () {

    Auth::logout();

    $reponse = $this->get('/set_accessibility_device/1');
    $reponse->assertRedirect('/login');
});

test('set device with org teacher roles', function () {
    $this->assertTrue(Auth::check());

    $disability_type = $this->post('/disability_type', [
        'name' => 'Example',
        'description' => 'Disability Type Description',
    ]);

    $disability_type->assertStatus(302);

    $device = $this->post('/accessibility_device', [
        'name' => 'Example Device',
        'description' => 'Device Description',
        'disability_types' => [1],
        'status' => 'INACTIVE',
    ]);

    $device->assertStatus(302);

    $student_id = 1;

    $response = $this->post("/set_accessibility_device/{$student_id}", [
        'device_id' => 1,
    ]);

    $response->assertStatus(302);

    $setData = $this->post("/set_accessibility_device/{$student_id}", []);

    $setData->assertSessionHasErrors(['device_id']);

    $response->assertRedirect("/teacher_students/{$student_id}");

    // Roll back the transaction to undo any database changes made during the test
});
