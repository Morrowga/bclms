<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

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
    $this->assertTrue(Auth::check());

    $excelFile = new UploadedFile(
        public_path('file/bc_student_import.csv'),
        'bc_student_import.csv',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true
    );

    $response = $this->post('/teacher/import', [
        'organisation_id' => 1,
        'file' => $excelFile,
        'type' => 'student',
    ]);

    $response->assertStatus(302);
});
