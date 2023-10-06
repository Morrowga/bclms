<?php

namespace Src\BlendedConcept\Survey\Application\Mappers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Src\BlendedConcept\Survey\Domain\Model\Survey;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;

class SurveyMapper
{
    public static function fromRequest(Request $request, $survey_id = null): Survey
    {

        return new Survey(
            id: $survey_id,
            title: $request->title,
            description: $request->description,
            type: $request->type,
            appear_on: $request->appear_on,
            start_date: $request->start_date,
            end_date: $request->end_date,
            required: $request->required,
            repeat: $request->repeat,
            questions: $request->questions,
        );
    }

    public static function toEloquent(Survey $survey): SurveyEloquentModel
    {
        $surveyEloquent = new SurveyEloquentModel();

        if ($survey->id) {
            $surveyEloquent = SurveyEloquentModel::query()->findOrFail($survey->id);
        }

        $date_created = Carbon::now();

        $surveyEloquent->id = $survey->id;
        $surveyEloquent->title = $survey->title;
        $surveyEloquent->description = $survey->description;
        $surveyEloquent->type = $survey->type;
        $surveyEloquent->appear_on = $survey->appear_on;
        $surveyEloquent->start_date = $survey->start_date;
        $surveyEloquent->end_date = $survey->end_date;
        $surveyEloquent->required = $survey->required;
        $surveyEloquent->repeat = $survey->repeat;
        $surveyEloquent->date_created = $date_created->toDateTimeString();

        return $surveyEloquent;
    }
}
