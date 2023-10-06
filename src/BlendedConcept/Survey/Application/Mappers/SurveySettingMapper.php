<?php

namespace Src\BlendedConcept\Survey\Application\Mappers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Src\BlendedConcept\Survey\Domain\Model\Entities\SurveySetting;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveySettingEloquentModel;

class SurveySettingMapper
{
    public static function fromRequest(Request $request, $survey_setting_id = null): SurveySetting
    {

        return new SurveySetting(
            id: $survey_setting_id,
            survey_id: $request->survey_id,
            user_type: $request->user_type,
        );
    }

    public static function toEloquent(SurveySetting $surveySetting): SurveySettingEloquentModel
    {
        $surveySettingEloquent = new SurveySettingEloquentModel();

        if ($surveySetting->id) {
            $surveySettingEloquent = SurveySettingEloquentModel::query()->findOrFail($surveySetting->id);
        }

        $date_created = Carbon::now();

        $surveySettingEloquent->id = $surveySetting->id;
        $surveySettingEloquent->survey_id = $surveySetting->survey_id;
        $surveySettingEloquent->user_type = $surveySetting->user_type;

        return $surveySettingEloquent;
    }
}
