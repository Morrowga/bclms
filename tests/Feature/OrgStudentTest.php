<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\LearningNeedEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
use Src\BlendedConcept\Organisation\Application\Policies\OrganisationUserPolicy;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');
});

test('without login not access organisation student', function () {

    Auth::logout();

    $reponse = $this->get('/organisations-student');
    $reponse->assertRedirect('/login');
});

test('without other role not access organisations student', function () {

    Auth::logout();

    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 3,
        'email_verification_send_on' => Carbon::now(),
    ]);

    if (Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password'])) {
        $reponse = $this->get('/organisations-student');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/organisations-student');
    $reponse->assertStatus(403);
});

test('create org student with org admin roles', function () {

    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('store', OrganisationUserPolicy::class)); // permission check

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

    $response = $this->post('organisations-student', [
        'first_name' => 'Example',
        'last_name' => 'Student Create',
        'gender' => 'Male',
        'dob' => '2000-01-01',
        'education_level' => 'G1',
        'email' => 'studentcreate@mail.com',
        'contact_number' => '091234567',
        'profile_pics' => $image,
        "parent_first_name" => "parent ",
        "parent_last_name" => "test 1",
        'disability_types' => [$disabilityType->id],
        'learning_needs' => [$subLearningType->id],
        'login_username' => 'username',
        'login_password' => 'password'
    ]);

    $response->assertStatus(302);

    $storeData = $this->post('organisations-student', []);

    $storeData->assertSessionHasErrors(['gender', 'dob', 'email', 'contact_number', 'education_level', 'login_password', 'login_username']);

    $storeData = $this->get('organisations-student');

    // Roll back the transaction to undo any database changes made during the test
});

test('update org student with org admin roles', function () {
    // Start a database transaction for the test
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

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

    $response = $this->post('organisations-student', [
        'first_name' => 'Example',
        'last_name' => 'Student',
        'gender' => 'Male',
        'dob' => '2000-01-01',
        'education_level' => 'G1',
        'email' => 'studenttestcreate@mail.com',
        'contact_number' => '091234567',
        'profile_pics' => $image,
        "parent_first_name" => "parent ",
        "parent_last_name" => "test create",
        'disability_types' => [$disabilityType->id],
        'learning_needs' => [$subLearningType->id],
        'login_username' => 'username',
        'login_password' => 'password'
    ]);

    $response->assertStatus(302);

    // Extract the student ID from the response or retrieve it from the database
    $studentId = 2; // Retrieve the student ID as needed
    $student = StudentEloquentModel::where('student_id', $studentId)->first();

    $updateImage = UploadedFile::fake()->image('updatestudent.jpg'); // Change 'test.jpg' to the desired file name and extension

    $otherDisabilityType = DisabilityTypeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $otherLearningNeed = LearningNeedEloquentModel::create([
        'name' => 'Learning Need name',
        'description' => 'Learning Need description',
    ]);

    $otherSubLearningType = SubLearningTypeEloquentModel::create([
        'learning_needs_id' => $otherLearningNeed->id,
        'name' => 'sub learning 1'
    ]);

    $updateResponse = $this->put("organisations-student/{$studentId}", [
        "user_id" => $student->user_id,
        "parent_id" => $student->parent_id,
        'student_id' => $studentId,
        'first_name' => 'Example',
        'last_name' => 'Student Update',
        'gender' => 'Male',
        'dob' => '2000-01-01',
        'education_level' => 'G1',
        'email' => 'studentupdate@mail.com',
        'contact_number' => '0912345678',
        'profile_pics' => $updateImage,
        "parent_first_name" => "parent ",
        "parent_last_name" => "test update",
        "num_gold_coins" => 0,
        "num_silver_coins" => 0,
        'disability_types' => [$otherDisabilityType->id],
        'learning_needs' => [$otherSubLearningType->id],
        'login_username' => 'username',
        'login_password' => 'password'
    ]);

    $updateResponse->assertStatus(302);

    // $updateData = $this->put("organisations-student/{$studentId}", []);

    // $updateData->assertSessionHasErrors(['gender', 'dob', 'education_level']);

});

test('delete org student with org admin roles', function () {
    // Start a database transaction for the test
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated
    // Extract the survey ID from the response or retrieve it from the database
    $studentId = 1; // Retrieve the teacher ID as needed

    // Attempt to delete the teacher
    $deleteResponse = $this->delete("/organisations-student/{$studentId}");

    $deleteResponse->assertStatus(302);
});

