<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');

    //login as superadmin
    $this->post('/login', [
        'email' => 'bcstaff@mail.com',
        'password' => 'password',
    ]);
});

test('without login not access user experience survey', function () {

    Auth::logout();

    $reponse = $this->get('/userexperiencesurvey');
    $reponse->assertRedirect('/login');
});

test('without other role not access user experience survey', function () {

    Auth::logout();

    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 4,
        'email_verification_send_on' => Carbon::now(),
    ]);

    if (Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password'])) {
        $reponse = $this->get('/userexperiencesurvey');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/userexperiencesurvey');
    $reponse->assertStatus(403);
});

test('create user experience survey with bcstaff roles', function () {
    // Start a database transaction for the test
    $this->assertTrue(Auth::check());

    $questions = [
        [
            'id' => '1',
            'question_type' => 'SINGLE_CHOICE',
            'question' => 'That is question',
            'options' => ['That is options', 'That is option 2', 'That is option 3'],
        ],
    ];

    $response = $this->post('/userexperiencesurvey', [
        'title' => 'Example Survey',
        'description' => 'Survey Description',
        'type' => 'USERREXP',
        'user_type' => 'B2C_USER',
        'appear_on' => 'LOG_OUT',
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addDay(3),
        'required' => true,
        'repeat' => true,
        'questions' => json_encode($questions),
    ]);

    $response->assertStatus(302);

    $postData = $this->post('/userexperiencesurvey', []);
    $postData->assertSessionHasErrors(['title', 'description', 'type', 'user_type', 'appear_on', 'start_date', 'end_date', 'questions']);
    $response->assertRedirect('/userexperiencesurvey');
    // Assert the response and any other test assertions here

    // Roll back the transaction to undo any database changes made during the test
});

test('create or update user experience with missing filed bcstaff roles', function () {

    $this->assertTrue(Auth::check());

    $response = $this->post('/userexperiencesurvey', [
        'title' => '',
        'description' => '',
        'type' => '',
        'user_type' => '',
        'appear_on' => '',
        'start_date' => '',
        'end_date' => '',
        'required' => true,
        'repeat' => true,
        'questions' => '',
    ]);

    //check backend validation
    $response->assertSessionHasErrors(['title']);
    $response->assertSessionHasErrors(['description']);
    $response->assertSessionHasErrors(['user_type']);
    $response->assertSessionHasErrors(['appear_on']);
    $response->assertSessionHasErrors(['start_date']);
    $response->assertSessionHasErrors(['end_date']);
    $response->assertSessionHasErrors(['questions']);
});

test('update user experience survey with bcstaff roles', function () {
    // Start a database transaction for the test
    $this->assertTrue(Auth::check());

    $questions = [
        [
            'id' => '1',
            'question_type' => 'SINGLE_CHOICE',
            'question' => 'That is question',
            'options' => ['That is options', 'That is option 2', 'That is option 3'],
        ],
    ];

    $response = $this->post('/userexperiencesurvey', [
        'title' => 'Original Survey',
        'description' => 'Original Survey Description',
        'type' => 'USERREXP',
        'user_type' => 'B2C_USER',
        'appear_on' => 'LOG_OUT',
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addDay(3),
        'required' => true,
        'repeat' => true,
        'questions' => json_encode($questions),
    ]);

    $response->assertStatus(302);

    // Extract the survey ID from the response or retrieve it from the database
    $surveyId = 1; // Retrieve the survey ID as needed

    // Attempt to update the survey

    $updateResponse = $this->put("/userexperiencesurvey/{$surveyId}", [
        'title' => 'Updated Survey',
        'description' => 'Updated Survey Description',
        'type' => 'USERREXP',
        'user_type' => 'ORG_TEACHER',
        'appear_on' => 'BOOK_END',
        'start_date' => Carbon::now()->addDay(1),
        'end_date' => Carbon::now()->addDay(5),
        'required' => false,
        'repeat' => false,
        // Add other fields you want to update here
    ]);

    $updateResponse->assertStatus(302);

    $updateData = $this->put("/userexperiencesurvey/{$surveyId}", []);

    $updateData->assertSessionHasErrors(['title', 'description', 'type', 'user_type', 'appear_on', 'start_date', 'end_date']);

    $response->assertRedirect('/userexperiencesurvey');
});

test('add new question in user experience survey with bcstaff roles', function () {
    $this->assertTrue(Auth::check());

    $questions = [
        [
            'id' => '1',
            'question_type' => 'SINGLE_CHOICE',
            'question' => 'That is question',
            'options' => ['That is options', 'That is option 2', 'That is option 3'],
        ],
    ];

    // Create the initial user experience survey
    $response = $this->post('/userexperiencesurvey', [
        'title' => 'Example Survey',
        'description' => 'Survey Description',
        'type' => 'USERREXP',
        'user_type' => 'B2C_USER',
        'appear_on' => 'LOG_OUT',
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addDay(3),
        'required' => true,
        'repeat' => true,
        'questions' => json_encode($questions),
    ]);

    $response->assertStatus(302);

    $surveyId = 1;

    // Create a new question for the survey
    $questionResponse = $this->post('/questions', [
        'survey_id' => $surveyId,
        'question_type' => 'SINGLE_CHOICE',
        'question' => 'That is question',
        'options' => json_encode(['That is new options', 'That is new option 2', 'That new is option 3']),
    ]);

    $addQuestionData = $this->post('/questions', []);

    $addQuestionData->assertSessionHasErrors(['survey_id', 'question_type', 'question', 'options']);

    $questionResponse->assertStatus(302);
    // $response->assertRedirect($questionResponse->headers->get('Location'));
});

test('update existing question in user experience survey with bcstaff roles', function () {
    $this->assertTrue(Auth::check());

    $questions = [
        [
            'id' => '1',
            'question_type' => 'SINGLE_CHOICE',
            'question' => 'That is question',
            'options' => ['That is options', 'That is option 2', 'That is option 3'],
        ],
    ];

    $response = $this->post('/userexperiencesurvey', [
        'title' => 'Example Survey',
        'description' => 'Survey Description',
        'type' => 'USERREXP',
        'user_type' => 'B2C_USER',
        'appear_on' => 'LOG_OUT',
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addDay(3),
        'required' => true,
        'repeat' => true,
        'questions' => json_encode($questions),
    ]);

    $response->assertStatus(302);

    // Define the route name and route parameters
    $questionId = 1;
    $surveyId = 1;

    // Define the updated question data
    $updatedQuestionData = [
        'survey_id' => $surveyId,
        'question_type' => 'MULTIPLE_RESPONSE',
        'question' => 'That is update question',
        'options' => json_encode(['That is update options', 'That is update option 2', 'That is option 3']),
    ];

    $questionResponse = $this->put("/questions/{$questionId}", $updatedQuestionData);

    $updateQuestionData = $this->put("/questions/{$questionId}", []);

    $updateQuestionData->assertSessionHasErrors(['survey_id', 'question_type', 'question', 'options']);

    $questionResponse->assertStatus(302);
});

test('delete  the question in user experience survey with bcstaff roles', function () {
    // Start a database transaction for the test
    $this->assertTrue(Auth::check());

    // Create a survey that you intend to delete
    $questions = [
        [
            'id' => '1',
            'question_type' => 'SINGLE_CHOICE',
            'question' => 'That is question',
            'options' => ['That is options', 'That is option 2', 'That is option 3'],
        ],
    ];

    $response = $this->post('/userexperiencesurvey', [
        'title' => 'Survey to Delete',
        'description' => 'Survey to Delete Description',
        'type' => 'USERREXP',
        'user_type' => 'B2C_USER',
        'appear_on' => 'LOG_OUT',
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addDay(3),
        'required' => true,
        'repeat' => true,
        'questions' => json_encode($questions),
    ]);

    $response->assertStatus(302);

    // Extract the survey ID from the response or retrieve it from the database
    $surveyId = 1; // Retrieve the survey ID as needed
    $questionId = 1;

    // Attempt to delete the survey
    $deleteResponse = $this->delete("/questions/{$questionId}");

    $deleteResponse->assertStatus(302);
});

test('delete user experience survey with bcstaff roles', function () {
    // Start a database transaction for the test
    $this->assertTrue(Auth::check());

    // Create a survey that you intend to delete
    $questions = [
        [
            'id' => '1',
            'question_type' => 'SINGLE_CHOICE',
            'question' => 'That is question',
            'options' => ['That is options', 'That is option 2', 'That is option 3'],
        ],
    ];

    $response = $this->post('/userexperiencesurvey', [
        'title' => 'Survey to Delete',
        'description' => 'Survey to Delete Description',
        'type' => 'USERREXP',
        'user_type' => 'B2C_USER',
        'appear_on' => 'LOG_OUT',
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addDay(3),
        'required' => true,
        'repeat' => true,
        'questions' => json_encode($questions),
    ]);

    $response->assertStatus(302);

    // Extract the survey ID from the response or retrieve it from the database
    $surveyId = 1; // Retrieve the survey ID as needed

    // Attempt to delete the survey
    $deleteResponse = $this->delete("/userexperiencesurvey/{$surveyId}");

    $deleteResponse->assertStatus(302);
});
