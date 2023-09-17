<?php

namespace Src\BlendedConcept\Survey\Domain\Repositories;

use Src\BlendedConcept\Survey\Domain\Model\Survey;
use Src\BlendedConcept\Survey\Application\DTO\SurveyData;
use Src\BlendedConcept\Survey\Application\DTO\QuestionData;
use Src\BlendedConcept\Survey\Domain\Model\Entities\Question;


interface SurveyRepositoryInterface
{
    public function getSurveyList($filters);

    public function showSurvey($id);

    public function createSurvey(Survey $survey);

    public function updateSurvey(SurveyData $survey);

    public function delete(int $survey_id): void;

    public function createQuestion(Question $question);

    public function deleteQuestion(int $question_id): void;

    public function updateQuestion(QuestionData $question);
}
