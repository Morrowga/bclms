<?php

namespace Src\BlendedConcept\Survey\Application\Repositories\Eloquent;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Survey\Domain\Resources\SurveyResponseResource;
use Src\BlendedConcept\Survey\Application\Mappers\SurveyResponseMapper;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\ResponseEloquentModel;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyResponseRepositoryInterface;


class SurveyResponseRepository implements SurveyResponseRepositoryInterface
{
    public function GetSurveyResponses($filters)
    {
        $surveyResponses = SurveyResponseResource::collection(ResponseEloquentModel::filter($filters)->with(['user.role', 'student', 'survey'])->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $surveyResponses;
    }


    public function createSurveyResponse(Request $request){
        DB::beginTransaction();
        try {
            $SelectOptionArray = removeNullInArray(json_decode($request->results, true));
            foreach($SelectOptionArray as $key =>  $option){
                if(!$this->isStudent($request->user_id)){
                    $newOption = [
                        'survey_id' => $request->survey_id,
                        'user_id' => $request->user_id,
                        'question_id' => $key,
                    ];
                } else {
                    $newOption = [
                        'survey_id' => $request->survey_id,
                        'user_id' => $request->user_id,
                        'student_id' => $this->isStudent($request->user_id),
                        'question_id' => $key,
                    ];
                }

                $surveyOptionResponseRequest = SurveyResponseMapper::fromRequest($newOption);
                $surveyOptionResponseEloquent = SurveyResponseMapper::toEloquent($surveyOptionResponseRequest);
                $surveyOptionResponseEloquent->save();

                $surveyOptionResponseEloquent->options()->attach($option);
            }

            if($request->has('shortanswer')){
                $answerArray = removeNullInArray(json_decode($request->shortanswer, true));
                foreach($answerArray as $answer){
                    if(!$this->isStudent($request->user_id)){
                        $newAnswer = [
                            'survey_id' => $request->survey_id,
                            'user_id' => $request->user_id,
                            'question_id' => $answer['id'],
                            'answer' => $answer['answer'],
                        ];
                    } else {
                        $newAnswer = [
                            'survey_id' => $request->survey_id,
                            'user_id' => $request->user_id,
                            'student_id' => $this->isStudent($request->user_id),
                            'question_id' => $answer['id'],
                            'answer' => $answer['answer'],
                        ];
                    }
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

    public function deleteResponse(int $response_id): void
    {
        $response = ResponseEloquentModel::query()->findOrFail($response_id);
        $response->delete();
    }

    public function isStudent($id){
        $user = UserEloquentModel::find($id);
        if($user->role->name == 'Student'){
            return $user->student->student_id;
        }

        return false;
    }
}
