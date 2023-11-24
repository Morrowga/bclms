
<?php

use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');
});

test('response profiling survey with orgteacher roles', function () {
    $user = UserEloquentModel::where('email', 'b2bteacher@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $surveyId = 1;

    $surveyId = 1;

    // Create a new question for the survey
    $questionResponse = $this->post('/questions', [
        'survey_id' => $surveyId,
        'question_type' => 'SINGLE_CHOICE',
        'question' => 'That is question',
        'options' => json_encode(['That is new options', 'That is new option 2', 'That new is option 3']),
    ]);

    $questionResponse->assertStatus(302);

    $questionId = 1;

    // Create a new question for the survey
    $surveyResponse = $this->post('/surveyresponse', [
        'results' => "[null, [1]]",
        'survey_id' => $surveyId,
        'user_id' => 1,
        'question_id' => $questionId,
    ]);

    $emptySurveyReponse = $this->post('/surveyresponse', []);

    $emptySurveyReponse->assertSessionHasErrors(['survey_id', 'results', 'user_id']);

    $surveyResponse->assertStatus(302);
});

test('response profiling survey with b2cteacher roles', function () {
    $user = UserEloquentModel::where('email', 'teacherone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $surveyId = 1;

    $surveyId = 1;

    // Create a new question for the survey
    $questionResponse = $this->post('/questions', [
        'survey_id' => $surveyId,
        'question_type' => 'SINGLE_CHOICE',
        'question' => 'That is question',
        'options' => json_encode(['That is new options', 'That is new option 2', 'That new is option 3']),
    ]);

    $questionResponse->assertStatus(302);

    $questionId = 1;

    // Create a new question for the survey
    $surveyResponse = $this->post('/surveyresponse', [
        'results' => "[null, [1]]",
        'survey_id' => $surveyId,
        'user_id' => 1,
        'question_id' => $questionId,
    ]);

    $emptySurveyReponse = $this->post('/surveyresponse', []);

    $emptySurveyReponse->assertSessionHasErrors(['survey_id', 'results', 'user_id']);

    $surveyResponse->assertStatus(302);
});

test('response profiling survey with parent', function () {
    $user = UserEloquentModel::where('email', 'parentone@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $surveyId = 1;

    $surveyId = 1;

    // Create a new question for the survey
    $questionResponse = $this->post('/questions', [
        'survey_id' => $surveyId,
        'question_type' => 'SINGLE_CHOICE',
        'question' => 'That is question',
        'options' => json_encode(['That is new options', 'That is new option 2', 'That new is option 3']),
    ]);

    $questionResponse->assertStatus(302);

    $questionId = 1;

    // Create a new question for the survey
    $surveyResponse = $this->post('/surveyresponse', [
        'results' => "[null, [1]]",
        'survey_id' => $surveyId,
        'user_id' => 1,
        'question_id' => $questionId,
    ]);

    $emptySurveyReponse = $this->post('/surveyresponse', []);

    $emptySurveyReponse->assertSessionHasErrors(['survey_id', 'results', 'user_id']);

    $surveyResponse->assertStatus(302);
});
