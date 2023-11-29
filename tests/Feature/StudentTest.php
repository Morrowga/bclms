<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
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

test('import student excel with super admin role module', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $excelFile = new UploadedFile(
        public_path('imports/bc_student_import.csv'),
        'bc_student_import.csv',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true
    );

    $response = $this->post('/teacher/import', [
        'organisation_id' => 1,
        'file' => [$excelFile],
        'type' => 'student',
    ]);

    $response->assertStatus(302);

    // Query the database to check if the email exists
    $usernameExist = UserEloquentModel::where('username', 'wren_clark')->exists();

    // Assert that the email exists in the database
    $this->assertTrue($usernameExist);
});
