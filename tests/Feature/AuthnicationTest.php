<?php

namespace Tests\Feature\Authi;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');

    //login as superadmin
});
test('invalid_teacher_register_email', function () {
    $data = [
        'email' => 'test.com',
        'password' => 'password',
        'first_name' => 'tester',
        'last_name' => 'one',
        'contact_number' => '87333233',
        'password_confirmation' => 'password',
        'plan' => 1,
        'user_type' => 'teacher'
    ];
    $response = $this->post('/free-plan', $data);
    $response->assertSessionHasErrors('email');
});

test('invalid_parent_register_email', function () {
    $data = [
        'email' => 'test.com',
        'password' => 'password',
        'first_name' => 'tester',
        'last_name' => 'one',
        'contact_number' => '87333233',
        'password_confirmation' => 'password',
        'plan' => 1,
        'user_type' => 'parent'
    ];
    $response = $this->post('/free-plan', $data);
    $response->assertSessionHasErrors('email');
});

test('created_a_paid_b2c_teacher_account', function () {
    $data = [
        'email' => 'test.com',
        'password' => 'password',
        'first_name' => 'tester',
        'last_name' => 'one',
        'contact_number' => '87333233',
        'password_confirmation' => 'password',
        'plan' => 2,
        'user_type' => 'teacher'
    ];
    $response = $this->post('/paid-plan', $data);
    $response->assertSessionHasErrors('email');
});

test('created_a_paid_b2c_parent_account', function () {
    $data = [
        'email' => 'test.com',
        'password' => 'password',
        'first_name' => 'tester',
        'last_name' => 'one',
        'contact_number' => '87333233',
        'password_confirmation' => 'password',
        'plan' => 2,
        'user_type' => 'parent'
    ];
    $response = $this->post('/paid-plan', $data);
    $response->assertSessionHasErrors('email');
});

test('created_a_both_b2c_parent_account', function () {
    $student = StudentEloquentModel::find(1);
    $data = [
        'email' => 'test.com',
        'password' => 'password',
        'first_name' => 'tester',
        'last_name' => 'one',
        'contact_number' => '87333233',
        'password_confirmation' => 'password',
        'plan' => 2,
        'user_type' => 'parent'
    ];
    $response = $this->post('/both-plan', $data);
    $response->assertSessionHasErrors('email');
});

test('blank_teacher_register', function () {
    $data = [
        'plan' => 1,
        'user_type' => 'teacher'
    ];
    $response = $this->post('/free-plan', $data);
    $response->assertSessionHasErrors('email');
    $response->assertSessionHasErrors('first_name');
    $response->assertSessionHasErrors('last_name');
    $response->assertSessionHasErrors('password');
    $response->assertSessionHasErrors('contact_number');
});

test('blank_parent_register', function () {
    $data = [
        'plan' => 1,
        'user_type' => 'parent'
    ];
    $response = $this->post('/free-plan', $data);
    $response->assertSessionHasErrors('email');
    $response->assertSessionHasErrors('first_name');
    $response->assertSessionHasErrors('last_name');
    $response->assertSessionHasErrors('password');
    $response->assertSessionHasErrors('contact_number');
});

// /**
//  *  check unique user for register
//  *
//  *  @return bool True
//  */
test('unique_teacher_register_email', function () {
    // $email = 'testuser@mail.com';
    // $name = explode('@', $email);
    $data = [
        'first_name' => 'Tester',
        'last_name' => 'One',
        'email' => 'testuser@mail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'contact_number' => '0923434',
    ];
    $existingUser = UserEloquentModel::create($data);
    $testUser = UserEloquentModel::where('email', 'testuser@mail.com')->first();
    $response = $this->post('/free-plan', [
        'first_name' => $existingUser->first_name,
        'last_name' => $existingUser->last_name,
        'email' => $testUser->email,
        'password' => 'password',
        'password_confirmation' => 'password',
        'contact_number' => $existingUser->contact_number,
        'plan' => 1,
        'user_type' => 'teacher'
    ]);

    // dd($response);
    $response->assertSessionHasErrors('email');
});

// /**
//  *  check empty email on login
//  *
//  *  @return  bool True
//  */
test('blank login email or password', function () {
    $data = [
        'email' => '',
        'password' => 'password',
    ];
    $response = $this->post('login', $data);
    $response->assertSessionHasErrors('email');

    $data = [
        'email' => 'testing@testing.com',
        'password' => '',
    ];
    $response = $this->post('login', $data);
    $response->assertSessionHasErrors('password');
});

// /**
//  *  check invalid email address
//  *
//  *  @return bool True
//  */
test('invalid_login_email', function () {
    $data = [
        'email' => 'testing.com',
        'password' => Hash::make('password'),
    ];
    $response = $this->post('login', $data);
    $response->assertSessionHasErrors('email');
});


test('email_not_verified', function () {
    $data = [
        'first_name' => 'Tester',
        'last_name' => 'One',
        'email' => 'testuser@mail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'contact_number' => '0923434',
        'email_verification_send_on' => null,
    ];
    $existingUser = UserEloquentModel::create($data);
    $this->assertTrue($existingUser->email_verification_send_on === null);
});

test('email_verified', function () {
    $data = [
        'first_name' => 'Tester',
        'last_name' => 'One',
        'email' => 'testuser@mail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'contact_number' => '0923434',
        'email_verification_send_on' => now(),
    ];

    $existingUser = UserEloquentModel::create($data);
    $this->assertTrue($existingUser->email_verification_send_on !== null);
});

/**
 *  check email and password mismatch
 *
 *   @return  bool True
 */
// test('mismatch_login_password', function () {
//     $data = [
//         'first_name' => 'Tester',
//         'last_name' => 'One',
//         'email' => 'testuser@mail.com',
//         'password' => 'password',
//         'password_confirmation' => 'password',
//         'contact_number' => '0923434',
//         'email_verification_send_on' => Carbon::now(),
//     ];
//     $existingUser = UserEloquentModel::create($data);
//     $response = $this->post('login', [
//         'email' => $existingUser->email,
//         'password' => Hash::make('passwords'),
//     ]);

//     $response->assertInertia(function (AssertableInertia $page) {
//         $props = $page->toArray();
//         // expect($props['props']['errorMessage'])->toBe('Invalid Login Credential');
//     });
// });

/***
 *  check user for valid login and redirect to home page
 *
 *
 */
// test('match_login_password', function () {
//     $data = [
//         'first_name' => 'Admin',
//         'last_name' => 'Test',
//         'email' => 'admin@testing.com',
//         'password' => 'password',
//         'email_verification_send_on' => Carbon::now(),

//     ];
//     $existingUser = UserEloquentModel::create($data);
//     $response = $this->post('login', [
//         'email' => $existingUser->email,
//         'password' => 'password',
//     ]);
//     $response->assertRedirect('/home');
// });
