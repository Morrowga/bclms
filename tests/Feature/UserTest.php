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

test('create user  with missing filed superadmin roles', function () {

    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

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

test('access users with superadmin roles', function() {
    asAdmin()->get('/users')->assertOk();
});

test('access users with bcstaff roles', function() {
    asBcStaff()->get('/users')->assertOk();
});

test('set inactive users with superadmin roles', function() {
    $userId = 1; //retrieve as needed
    asAdmin()->put("/users/{$userId}/change_status", [ 'status' => 'INACTIVE'])->assertRedirect('/users');
});

test('set active users with superadmin roles', function() {
    $userId = 1; //retrieve as needed
    asAdmin()->put("/users/{$userId}/change_status", [ 'status' => 'ACTIVE'])->assertRedirect('/users');
});

test('set inactive users with bcstaff roles', function() {
    $userId = 1; //retrieve as needed
    asBcStaff()->put("/users/{$userId}/change_status", [ 'status' => 'INACTIVE'])->assertRedirect('/users');
});

test('set active users with bcstaff roles', function() {
    $userId = 1; //retrieve as needed
    asBcStaff()->put("/users/{$userId}/change_status", [ 'status' => 'ACTIVE'])->assertRedirect('/users');
});

test('import excel with super admin role module', function () {
    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $excelFile = new UploadedFile(
        public_path('file/bc_teacher_import.csv'),
        'bc_teacher_import.csv',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true
    );

    $response = $this->post('/teacher/import', [
        'organisation_id' => 1,
        'file' => [$excelFile],
        'type' => 'teacher',
    ]);

    $response->assertStatus(302);

    // Query the database to check if the email exists
    $emailExists = UserEloquentModel::where('email', 'emily_williams@mail.com')->exists();

    // Assert that the email exists in the database
    $this->assertTrue($emailExists);
});

test('sufficient limit of teachers to import with super admin role module', function () {
    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $excelFile = new UploadedFile(
        public_path('file/bc_teacher_import.csv'),
        'bc_teacher_import.csv',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true
    );

    $response = $this->post('/teacher/import', [
        'organisation_id' => 1,
        'file' => [$excelFile],
        'type' => 'teacher',
    ]);

    $response->assertStatus(302);

    $moreResponse = $this->post('/teacher/import', [
        'organisation_id' => 1,
        'file' => [$excelFile],
        'type' => 'teacher',
    ]);

    $moreResponse->assertStatus(302);
});

test('import excel with bcstaff role module', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $excelFile = new UploadedFile(
        public_path('file/bc_teacher_import.csv'),
        'bc_teacher_import.csv',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true
    );

    $response = $this->post('/teacher/import', [
        'organisation_id' => 1,
        'file' => [$excelFile],
        'type' => 'teacher',
    ]);

    $response->assertStatus(302);

    // Query the database to check if the email exists
    $emailExists = UserEloquentModel::where('email', 'emily_williams@mail.com')->exists();

    // Assert that the email exists in the database
    $this->assertTrue($emailExists);
});

test('sufficient limit of teachers to import with bcstaff role module', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $excelFile = new UploadedFile(
        public_path('file/bc_teacher_import.csv'),
        'bc_teacher_import.csv',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true
    );

    $response = $this->post('/teacher/import', [
        'organisation_id' => 1,
        'file' => [$excelFile],
        'type' => 'teacher',
    ]);

    $response->assertStatus(302);

    $moreResponse = $this->post('/teacher/import', [
        'organisation_id' => 1,
        'file' => [$excelFile],
        'type' => 'teacher',
    ]);

    $moreResponse->assertStatus(302);
});
