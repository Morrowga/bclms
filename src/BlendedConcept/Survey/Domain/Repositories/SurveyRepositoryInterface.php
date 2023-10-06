<?php

namespace Src\BlendedConcept\Survey\Domain\Repositories;

use Illuminate\Http\Request;
use Src\BlendedConcept\Survey\Domain\Model\Survey;
use Src\BlendedConcept\Survey\Application\DTO\SurveyData;
use Src\BlendedConcept\Survey\Application\DTO\QuestionData;
use Src\BlendedConcept\Survey\Domain\Model\Entities\Question;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;

interface SurveyRepositoryInterface
{
    public function getUserExperienceSurveyList($filters);

    public function showSurvey($id);

    public function createSurvey(Survey $survey);

    public function updateSurvey(SurveyData $survey);

    public function delete(int $survey_id): void;

    public function createQuestion(Question $question);

    public function deleteQuestion(int $question_id): void;

    public function updateQuestion(QuestionData $question);

    public function getProfilingSurvey();

    public function storeOrder(Request $request, SurveyEloquentModel $survey);

    public function getSurveyResults($filters);

    public function getSurveyByRole($appear_on);
}
