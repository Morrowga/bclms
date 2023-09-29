
<?php

use Carbon\Carbon;
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
        'email' => 'bcstaff@mail.com',
        'password' => 'password',
    ]);
});

test('without login not access profiling survey', function () {

    Auth::logout();

    $reponse = $this->get('/profilling_survey');
    $reponse->assertRedirect('/login');
});

test('without other role not access profiling survey', function () {

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
        $reponse = $this->get('/profilling_survey');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/profilling_survey');
    $reponse->assertStatus(403);
});

test('add new question in profiling survey with bcstaff roles', function () {
    $this->assertTrue(Auth::check());

    $surveyId = 1;

    // Create a new question for the survey
    $questionResponse = $this->post('/questions', [
        'survey_id' => $surveyId,
        'question_type' => 'SINGLE_CHOICE',
        'question' => 'That is question',
        'options' => json_encode(['That is new options', 'That is new option 2', 'That new is option 3']),
    ]);

    $addQuestionData = $this->post('/questions', []);

    $addQuestionData->assertSessionHasErrors(['survey_id', 'question_type', 'question']);

    $questionResponse->assertStatus(302);
});

test('update existing question in profiling survey with bcstaff roles', function () {
    $this->assertTrue(Auth::check());

    $surveyId = 1;
    // Create a new question for the survey
    $questionResponse = $this->post('/questions', [
        'survey_id' => $surveyId,
        'question_type' => 'SINGLE_CHOICE',
        'question' => 'That is question',
        'order' => 1,
        'options' => json_encode(['That is new options', 'That is new option 2', 'That new is option 3']),
    ]);

    $addQuestionData = $this->post('/questions', []);

    $addQuestionData->assertSessionHasErrors(['survey_id', 'question_type', 'question']);

    $questionResponse->assertStatus(302);

    $questionId = 1;
    // Define the updated question data
    $updatedQuestionData = [
        'survey_id' => $surveyId,
        'question_type' => 'MULTIPLE_RESPONSE',
        'question' => 'That is update question',
        'order' => 1 + 1,
        'options' => json_encode(['That is update options', 'That is update option 2', 'That is option 3']),
    ];

    $questionResponse = $this->put("/questions/{$questionId}", $updatedQuestionData);

    $updateQuestionData = $this->put("/questions/{$questionId}", []);

    $updateQuestionData->assertSessionHasErrors(['survey_id', 'question_type', 'question']);

    $questionResponse->assertStatus(302);
});

test('delete the question in profiling survey with bcstaff roles', function () {
    // Start a database transaction for the test
    $this->assertTrue(Auth::check());

    $surveyId = 1;
    // Create a new question for the survey
    $questionResponse = $this->post('/questions', [
        'survey_id' => $surveyId,
        'question_type' => 'SINGLE_CHOICE',
        'question' => 'That is question',
        'order' => 1,
        'options' => json_encode(['That is new options', 'That is new option 2', 'That new is option 3']),
    ]);

    $addQuestionData = $this->post('/questions', []);

    $addQuestionData->assertSessionHasErrors(['survey_id', 'question_type', 'question']);

    $questionResponse->assertStatus(302);

    $questionId = 1;

    // Attempt to delete the survey
    $deleteResponse = $this->delete("/questions/{$questionId}");

    $deleteResponse->assertStatus(302);
});
