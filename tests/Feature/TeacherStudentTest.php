<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Student\Application\Policies\TeacherStudentPolicy;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\LearningNeedEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');
});

test('can log out an authenticated user', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertStatus(302);
    $this->assertGuest();
});

test('without login not access teacher students', function () {

    Auth::logout();

    $reponse = $this->get('/teacher_students');
    $reponse->assertRedirect('/login');
});

test('access teacher students with bcsubscriber roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('view', TeacherStudentPolicy::class)); // permission check

    $reponse = $this->get('/teacher_students');

    $reponse->assertStatus(200);
});

test('cannot access teacher student with other roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertTrue(authorize('view', TeacherStudentPolicy::class)); // permission check

    $response = $this->get('/teacher_students');

    $response->assertStatus(403);

});

test('create teacher student with bcsubscriber roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('store', TeacherStudentPolicy::class)); // permission check

    $studentId = 1; // fill student id as needed or from database

    //delete teacher student to test, coz of license of student count is 1 when migrate fresh
    $deleteStudent = $this->delete("/teacher_students/{$studentId}");
    $deleteStudent->assertStatus(302);

    $image = UploadedFile::fake()->image('image.jpg'); // Change 'test.jpg' to the desired file name and extension

    $disabilityType = DisabilityTypeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $learningNeed = LearningNeedEloquentModel::create([
        'name' => 'Learning Need name',
        'description' => 'Learning Need description',
    ]);

    $subLearningType = SubLearningTypeEloquentModel::create([
        'learning_needs_id' => $learningNeed->id,
        'name' => 'sub learning 1'
    ]);

    $response = $this->post('/teacher_students', [
        "first_name"=> "Emma",
        "last_name"=> "Johnson",
        "gender"=> "Female",
        "dob"=> "2005-03-15",
        "contact_number"=> "12345678",
        "email"=> "emma.johnson@example.com",
        "education_level"=> "8th Grade",
        "learning_needs"=> [$subLearningType->id],
        "disability_types"=> [$disabilityType->id],
        "parent_first_name"=> "John",
        "parent_last_name"=> "Johnson",
        "profile_pics"=> $image
    ]);
    // dd($response);
    $response->assertStatus(302);

    $errorData = $this->post('/teacher_students', []);

    $errorData->assertSessionHasErrors(['first_name']);

    $response->assertRedirect('/teacher_students');
});


test('update teacher student with bcsubscriber roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('update', TeacherStudentPolicy::class)); // permission check

    $studentId = 1; // fill student id as needed or from database

    //delete teacher student to test, coz of license of student count is 1 when migrate fresh
    $deleteStudent = $this->delete("/teacher_students/{$studentId}");
    $deleteStudent->assertStatus(302);

    $image = UploadedFile::fake()->image('image.jpg'); // Change 'test.jpg' to the desired file name and extension

    $disabilityType = DisabilityTypeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $learningNeed = LearningNeedEloquentModel::create([
        'name' => 'Learning Need name',
        'description' => 'Learning Need description',
    ]);

    $subLearningType = SubLearningTypeEloquentModel::create([
        'learning_needs_id' => $learningNeed->id,
        'name' => 'sub learning 1'
    ]);

    $response = $this->post('/teacher_students', [
        "first_name"=> "Emma",
        "last_name"=> "Johnson",
        "gender"=> "Female",
        "dob"=> "2005-03-15",
        "contact_number"=> "12345678",
        "email"=> "emma.johnson@example.com",
        "education_level"=> "8th Grade",
        "learning_needs"=> [$subLearningType->id],
        "disability_types"=> [$disabilityType->id],
        "parent_first_name"=> "John",
        "parent_last_name"=> "Johnson",
        "profile_pics"=> $image
    ]);
    // dd($response);
    $response->assertStatus(302);
    $studentId = 2; // retrieve id as needed

    $updateImage = UploadedFile::fake()->image('image.jpg'); // Change 'test.jpg' to the desired file name and extension

    $updateDisabilityType = DisabilityTypeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $updateLearningNeed = LearningNeedEloquentModel::create([
        'name' => 'Learning Need name',
        'description' => 'Learning Need description',
    ]);

    $updateSubLearningType = SubLearningTypeEloquentModel::create([
        'learning_needs_id' => $updateLearningNeed->id,
        'name' => 'sub learning 1'
    ]);

    $student = StudentEloquentModel::findOrFail($studentId);

    $updateResponse = $this->put("/teacher_students/{$studentId}", [
        "first_name"=> "Emma",
        "last_name"=> "Johnson",
        "gender"=> "Female",
        "dob"=> "2005-03-15",
        "contact_number"=> "12345678",
        // "email"=> "emma.johnson@example.com",
        "education_level"=> "8th Grade",
        "learning_needs"=> [$updateSubLearningType->id],
        "disability_types"=> [$updateDisabilityType->id],
        // "parent_first_name"=> "John",
        // "parent_last_name"=> "Johnson",
        "profile_pics"=> $updateImage,
        "num_gold_coins" => 0,
        "num_silver_coins" => 0,
        // "student_code" => '123456',
        "user_id" => $student->user_id,
        // "parent_id" => $student->parent_id
    ]);

    $updateResponse->assertStatus(302);

    $errorData = $this->put("/teacher_students/{$studentId}", []);

    $errorData->assertSessionHasErrors(['gender', 'dob', 'education_level']);

    $updateResponse->assertRedirect("/teacher_students/{$studentId}");
});

test('delete teacher student with bcsubscriber roles', function() {

    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('destroy', TeacherStudentPolicy::class)); // permission check

    $studentId = 1; // retrieve id as needed

    $deleteStudent = $this->delete("/teacher_students/{$studentId}");

    $deleteStudent->assertRedirect('/teacher_students');

});
