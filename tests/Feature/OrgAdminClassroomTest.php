<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\ClassRoom\Domain\Policies\ClassRoomPolicy;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');

    $this->post('/login', [
        'email' => 'orgone@mail.com',
        'password' => 'password',
    ]);

});

test('can log out an authenticated user', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertStatus(302);
    $this->assertGuest();
});

test('without login not access Classroom', function () {

    Auth::logout();

    $reponse = $this->get('/classrooms');
    $reponse->assertRedirect('/login');
});

test('without other role not access Classroom', function () {

    Auth::logout();

    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 6,
        'email_verification_send_on' => Carbon::now(),
    ]);

    if (Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password'])) {
        $reponse = $this->get('/classrooms');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/classrooms');
    $reponse->assertStatus(403);
});

test('read classrooms with organisation admin roles', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('view', ClassRoomPolicy::class)); // permission check

    $reponse = $this->get('/classrooms');

    $reponse->assertStatus(200);
});

test('cannot access read classrooms with other roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertTrue(authorize('view', ClassRoomPolicy::class)); // permission check

    $response = $this->get('/classrooms');

    $response->assertStatus(403);

});

test('create classrooms with organisation admin roles', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('store', ClassRoomPolicy::class)); // permission check

    $image = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension

    $teacher = TeacherEloquentModel::create([
        'user_id' => 4,
        'organisation_id' => 1,
    ]);

    $student = StudentEloquentModel::create([
        'user_id' => 4,
        'organisation_id' => 1,
        'gender' => 'Male',
        'education_level' => 'G1',
    ]);

    $class_room = $this->post('/classrooms', [
        'name' => 'Classroom Example',
        'description' => 'Classroom Description',
        'image' => $image,
        'students' => [$student->student_id], // Retrieve the student ID as needed
        'teachers' => [$teacher->teacher_id] // Retrieve the teacher ID as needed
    ]);

    $class_room->assertStatus(302);

    $storeData = $this->post('/classrooms', []);

    $storeData->assertSessionHasErrors(['name']);

    $class_room->assertRedirect('/classrooms');
});

test('create classrooms only name with organisation admin roles', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('store', ClassRoomPolicy::class)); // permission check

    $image = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension

    $disability_theme = $this->post('/classrooms', [
        'name' => 'Classroom Example',
    ]);

    $disability_theme->assertStatus(302);

    $disability_theme->assertRedirect('/classrooms');
});

test('update classroom with organisation admin roles', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('update', ClassRoomPolicy::class)); // permission check

    $image = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension

    $teacher = TeacherEloquentModel::create([
        'user_id' => 4,
        'organisation_id' => 1,
    ]);

    $student = StudentEloquentModel::create([
        'user_id' => 8,
        'organisation_id' => 1,
        'gender' => 'Male',
        'education_level' => 'G1',
    ]);

    $class_room = $this->post('/classrooms', [
        'name' => 'Classroom Example',
        'description' => 'Classroom Description',
        'image' => $image,
        'students' => [$student->student_id],
        'teachers' => [$teacher->teacher_id]
    ]);

    $class_room->assertStatus(302);

    $classRoomId = 1; // Retrieve the Classroom ID as needed

    $otherImage = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension

    $otherTeacher = TeacherEloquentModel::create([
        'user_id' => 4,
        'organisation_id' => 1,
    ]);

    $otherStudent = StudentEloquentModel::create([
        'user_id' => 8,
        'organisation_id' => 1,
        'gender' => 'Male',
        'education_level' => 'G1',
    ]);

    $updateResponse = $this->put("/classrooms/{$classRoomId}", [
        'name' => 'Classroom Example',
        'description' => 'Classroom Description',
        'image' => $otherImage,
        'students' => [$otherStudent->student_id],
        'teachers' => [$otherTeacher->teacher_id]
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/classrooms/{$classRoomId}", []);

    $updateData->assertSessionHasErrors(['name']);

    $class_room->assertRedirect('/classrooms');
});

test('update classroom only name with organisation admin roles', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $this->assertFalse(authorize('update', ClassRoomPolicy::class)); // permission check

    $class_room = $this->post('/classrooms', [
        'name' => 'Classroom Example',
    ]);

    $class_room->assertStatus(302);

    $classRoomId = 1; // Retrieve the Classroom ID as needed

    $updateResponse = $this->put("/classrooms/{$classRoomId}", [
        'name' => 'Classroom Example',
        "description" => null,
        "image" => null,
        "students" => [],
        "teachers" => []
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/classrooms/{$classRoomId}", []);

    $updateData->assertSessionHasErrors(['name']);

    $class_room->assertRedirect('/classrooms');
});

test('delete classroom with organisation roles', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $this->assertFalse(authorize('destroy', ClassRoomPolicy::class)); // permission check

    $image = UploadedFile::fake()->image('test.jpg'); // Change 'test.jpg' to the desired file name and extension

    $teacher = TeacherEloquentModel::create([
        'user_id' => 4,
        'organisation_id' => 1,
    ]);

    $student = StudentEloquentModel::create([
        'user_id' => 8,
        'organisation_id' => 1,
        'gender' => 'Male',
        'education_level' => 'G1',
    ]);

    $class_room = $this->post('/classrooms', [
        'name' => 'Classroom Example',
        'description' => 'Classroom Description',
        'image' => $image,
        'students' => [$student->student_id],
        'teachers' => [$teacher->teacher_id]
    ]);

    $class_room->assertStatus(302);

    $classRoomId = 1; // Retrieve the classroom ID as needed

    $deleteResponse = $this->delete("/classrooms/{$classRoomId}");

    $deleteResponse->assertStatus(302);

    $class_room->assertRedirect('/classrooms');
});
