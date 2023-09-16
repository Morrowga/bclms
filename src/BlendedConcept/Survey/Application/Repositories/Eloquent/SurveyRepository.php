<?php

namespace Src\BlendedConcept\Survey\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Survey\Domain\Resources\SurveyResource;
use Src\BlendedConcept\Survey\Application\Mappers\SurveyMapper;
use Src\BlendedConcept\Survey\Application\Mappers\QuestionMapper;
use Src\BlendedConcept\Survey\Application\Mappers\QuestionOptionMapper;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\Tenant;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;

class SurveyRepository implements SurveyRepositoryInterface
{

    public function getSurveyList($filters = [])
    {
        $surveys = SurveyResource::collection(SurveyEloquentModel::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $surveys;
    }
    public function createSurvey($request)
    {
        DB::beginTransaction();
        try {
            $surveyEloquent = SurveyMapper::toEloquent($request);
            $surveyEloquent->save();

            $survey_id = $surveyEloquent->id;

            $questions = json_decode($request->questions, true);

            foreach($questions as $question){
                $questionArray = [
                    "survey_id" => $survey_id,
                    "question_type" => $question['question_type'],
                    "question" => $question['question']
                ];
                $questionRequest = QuestionMapper::fromRequest($questionArray);
                $questionEloquent = QuestionMapper::toEloquent($questionRequest);
                $questionEloquent->save();

                $question_id = $questionEloquent->id;

                $options = $question['options'];
                foreach($options as $option){
                    $optionArray = [
                        "question_id" => $question_id,
                        "content" => $option,
                    ];

                    $optionRequest = QuestionOptionMapper::fromRequest($optionArray);
                    $questionOptionEloquent = QuestionOptionMapper::toEloquent($optionRequest);
                    $questionOptionEloquent->save();
                }

            }


            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }

    }


}
