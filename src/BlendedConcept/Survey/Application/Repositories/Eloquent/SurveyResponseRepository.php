<?php

namespace Src\BlendedConcept\Survey\Application\Repositories\Eloquent;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Survey\Domain\Resources\SurveyResponseResource;
use Src\BlendedConcept\Survey\Application\Mappers\SurveyResponseMapper;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\ResponseEloquentModel;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyResponseRepositoryInterface;


class SurveyResponseRepository implements SurveyResponseRepositoryInterface
{
    public function GetSurveyResponses($filters)
    {
        $surveyResponses = SurveyResponseResource::collection(ResponseEloquentModel::filter($filters)->with(['user', 'student', 'question.survey'])->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $surveyResponses;
    }


    public function createSurveyResponse(Request $request){
        DB::beginTransaction();
        try {
            $SelectOptionArray = removeNullInArray(json_decode($request->results, true));
            foreach($SelectOptionArray as $key =>  $option){
                $newOption = [
                    'survey_id' => $request->survey_id,
                    'user_id' => $request->user_id,
                    'question_id' => $key,
                ];
                $surveyOptionResponseRequest = SurveyResponseMapper::fromRequest($newOption);
                $surveyOptionResponseEloquent = SurveyResponseMapper::toEloquent($surveyOptionResponseRequest);
                $surveyOptionResponseEloquent->save();

                $surveyOptionResponseEloquent->options()->attach($option);
            }

            if($request->has('shortanswer')){
                $answerArray = removeNullInArray(json_decode($request->shortanswer, true));
                foreach($answerArray as $answer){
                    $newAnswer = [
                        'survey_id' => $request->survey_id,
                        'user_id' => $request->user_id,
                        'question_id' => $answer['id'],
                        'answer' => $answer['answer'],
                    ];
                    $surveyAnswerResponseRequest = SurveyResponseMapper::fromRequest($newAnswer);
                    $surveyAnswerResponseEloquent = SurveyResponseMapper::toEloquent($surveyAnswerResponseRequest);
                    $surveyAnswerResponseEloquent->save();
                }
            }
            DB::commit();
            return "Executed";
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }
    }
}
