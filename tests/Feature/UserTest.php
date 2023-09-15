<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
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

test('create user  with superadmin roles', function () {

    $this->assertTrue(Auth::check());

    $response = $this->post('/users', [
        'first_name' => 'Hare',
        'last_name' => 'Om',
        'contact_number' => '09951613400',
        'email' => 'hareom284@gmail.com',
        'role' => '2',
        'password' => 'password',
        'dob' => Carbon::now(),
        'status' => 1,
        'profile_pic' => 'images/profile/profilefive.png',
        'email_verified_send_on' => Carbon::now(),
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/users');
    // $this->assertDatabaseHas('users', ['first_name' => 'Hare', 'last_name' => 'Om', 'contact_number' => '09951613400', 'email' => 'hareom284@gmail.com']);
});

test('create user  with missing filed superadmin roles', function () {

    $this->assertTrue(Auth::check());

    $response = $this->post('/users', [
        'first_name' => '',
        'last_name' => '',
        'contact_number' => '',
        'email' => 'hareom28',
        'role' => '',
        'password' => '',
        'dob' => '',
        'is_active' => 1,
        'email_verified_send_on' => '',
    ]);

    //check backend validation
    $response->assertSessionHasErrors(['role']);
    $response->assertSessionHasErrors(['contact_number']);
    $response->assertSessionHasErrors(['email']);
    $response->assertSessionHasErrors(['first_name']);
    $response->assertSessionHasErrors(['last_name']);
    $response->assertSessionHasErrors(['password']);
});

test("other roles can't access user module with email verification check", function () {
    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'role_id' => 2,
        'email_verified_send_on' => null,
    ]);

    $authenticated = Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password']);

    if ($authenticated) {
        $response = $this->get('/users');
        $response->assertStatus(403);
    } else {
        $this->assertFalse($authenticated); // Assert that authentication fails
    }
});

test('import excel with super admin role module', function () {
    $this->assertTrue(Auth::check());

    $excelFile = new UploadedFile(
        public_path('file/bc_teacher_import.csv'),
        'bc_teacher_import.csv',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true
    );

    $response = $this->post('/teacher/import', [
        'organization_id' => 1,
        'file' => $excelFile,
        'type' => 'teacher',
    ]);

    $response->assertStatus(302);
});
