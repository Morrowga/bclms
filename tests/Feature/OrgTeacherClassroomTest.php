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

});

test('can log out an authenticated user', function () {
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertStatus(302);
    $this->assertGuest();
});

test('without login not access organisation teacher classroom', function () {

    Auth::logout();

    $reponse = $this->get('/classroom/org-teacher');
    $reponse->assertRedirect('/login');
});

test('access classroom details with organisation teacher roles', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'


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

    $classRoom = $this->post('/classrooms', [
        'name' => 'Classroom Example',
        'description' => 'Classroom Description',
        'image' => $image,
        'students' => [$student->student_id], // Retrieve the student ID as needed
        'teachers' => [$teacher->teacher_id] // Retrieve the teacher ID as needed
    ]);

    $classRoom->assertStatus(302);

    Auth::logout();

    //creating with org admin roles and access teacher classroom with b2bteacher
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $classRoomId = 1;

    $response = $this->get("/classroom/org-teacher/{$classRoomId}/show");

    $response->assertStatus(200);

});

//Classroom Group Start
test('create classroom group with organisation teacher roles', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'


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

    $classRoom = $this->post('/classrooms', [
        'name' => 'Classroom Example',
        'description' => 'Classroom Description',
        'image' => $image,
        'students' => [$student->student_id], // Retrieve the student ID as needed
        'teachers' => [$teacher->teacher_id] // Retrieve the teacher ID as needed
    ]);

    $classRoom->assertStatus(302);

    Auth::logout();

    //creating with org admin roles and access teacher classroom with b2bteacher
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $classRoomId = 1;

    $response = $this->post("classroom/org-teacher/store-group", [
        'classroom_id' => $classRoomId,
        'name' => 'Test Classroom Group',
        'students' => $student->id
    ]);

    $response->assertStatus(302);

    $storeEmptyData = $this->post('classroom/org-teacher/store-group', []);

    $storeEmptyData->assertSessionHasErrors(['name']);

    $response->assertRedirect("/classroom/org-teacher/{$classRoomId}/show");

});

test('update classroom group with organisation teacher roles', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'


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

    $classRoom = $this->post('/classrooms', [
        'name' => 'Classroom Example',
        'description' => 'Classroom Description',
        'image' => $image,
        'students' => [$student->student_id], // Retrieve the student ID as needed
        'teachers' => [$teacher->teacher_id] // Retrieve the teacher ID as needed
    ]);

    $classRoom->assertStatus(302);

    Auth::logout();

    //creating with org admin roles and access teacher classroom with b2bteacher
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $classRoomId = 1;

    $response = $this->post("classroom/org-teacher/store-group", [
        'classroom_id' => $classRoomId,
        'name' => 'Test Classroom Group',
        'students' => $student->id
    ]);

    $response->assertStatus(302);

    $classRoomGroupId = 1;

    $updateClassRoomGroup = $this->put("classroom/org-teacher/{$classRoomGroupId}/update-group", [
        'classroom_id' => $classRoomId,
        'name' => 'update Test Classroom Group',
        'students' => $student->id
    ]);

    $updateClassRoomGroup->assertStatus(302);

    $updateEmptyData = $this->put("classroom/org-teacher/{$classRoomGroupId}/update-group", []);

    $updateEmptyData->assertSessionHasErrors(['name']);

    $updateClassRoomGroup->assertRedirect("/classroom/org-teacher/{$classRoomId}/show");

});

test('delete classroom group with organisation teacher roles', function () {
    $user = UserEloquentModel::where('email', 'orgone@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'


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

    $classRoom = $this->post('/classrooms', [
        'name' => 'Classroom Example',
        'description' => 'Classroom Description',
        'image' => $image,
        'students' => [$student->student_id], // Retrieve the student ID as needed
        'teachers' => [$teacher->teacher_id] // Retrieve the teacher ID as needed
    ]);

    $classRoom->assertStatus(302);

    Auth::logout();

    //creating with org admin roles and access teacher classroom with b2bteacher
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $classRoomId = 1;

    $response = $this->post("classroom/org-teacher/store-group", [
        'classroom_id' => $classRoomId,
        'name' => 'Test Classroom Group',
        'students' => $student->id
    ]);

    $response->assertStatus(302);

    $classRoomGroupId = 1;

    $storeEmptyData = $this->delete("/classroom/org-teacher/{$classRoomGroupId}/delete-group");

    $storeEmptyData->assertStatus(302);

    $response->assertRedirect("/classroom/org-teacher/{$classRoomId}/show");

});

//Classroom Group End

test('access conduct lessons with b2bteacher roles', function() {
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated'

    $response = $this->get('/conduct_lessons');

    $response->assertStatus(200);
});

