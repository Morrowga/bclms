<?php

namespace Src\BlendedConcept\Survey\Application\Mappers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Src\BlendedConcept\Survey\Domain\Model\Entities\Response;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\ResponseEloquentModel;

class SurveyResponseMapper
{
    public static function fromRequest(Array $request, $survey_response = null): Response
    {

        return new Response(
            id: $survey_response,
            user_id: $request['user_id'],
            survey_id: $request['survey_id'],
            question_id: $request['question_id'],
            student_id: $request['student_id'] ?? null,
            answer: $request['answer'] ?? null,
        );
    }

    public static function toEloquent(Response $surveyResponse): ResponseEloquentModel
    {
        $surveyResponseEloquent = new ResponseEloquentModel();

        if ($surveyResponse->id) {
            $surveyResponseEloquent = ResponseEloquentModel::query()->findOrFail($surveyResponse->id);
        }

        $surveyResponseEloquent->id = $surveyResponse->id;
        $surveyResponseEloquent->user_id = $surveyResponse->user_id;
        $surveyResponseEloquent->survey_id = $surveyResponse->survey_id;
        $surveyResponseEloquent->question_id = $surveyResponse->question_id;
        $surveyResponseEloquent->student_id = $surveyResponse->student_id;
        $surveyResponseEloquent->answer = $surveyResponse->answer;

        return $surveyResponseEloquent;
    }
}
