<?php

namespace Src\BlendedConcept\Survey\Application\Repositories\Eloquent;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Survey\Application\DTO\SurveyData;
use Src\BlendedConcept\Survey\Application\DTO\QuestionData;
use Src\BlendedConcept\Survey\Domain\Resources\SurveyResource;
use Src\BlendedConcept\Survey\Application\Mappers\SurveyMapper;
use Src\BlendedConcept\Survey\Application\Mappers\QuestionMapper;
use Src\BlendedConcept\Survey\Domain\Resources\SurveyResultResource;
use Src\BlendedConcept\Survey\Application\Mappers\SurveySettingMapper;
use Src\BlendedConcept\Survey\Application\Mappers\QuestionOptionMapper;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\QuestionEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\ResponseEloquentModel;

class SurveyRepository implements SurveyRepositoryInterface
{
    public function getUserExperienceSurveyList($filters = [])
    {

        $surveys = SurveyEloquentModel::filter($filters)
            ->where('type', 'USEREXP')
            ->orderBy('id', 'desc')
            ->with(['survey_settings'])
            ->withCount([
                'responses as completion' => function ($query) {
                    $query->select(DB::raw('COUNT(DISTINCT user_id)'));
                },
            ])
            ->paginate($filters['perPage'] ?? 10);

        foreach ($surveys as $survey) {
            // Get unique user_type values for each survey
            $userTypes = $survey->survey_settings->pluck('user_type')->unique();
            $totalcount = 0;
            foreach ($userTypes as $userType) {
                $userCount = UserEloquentModel::where('role_id', $this->checkRoleIDs($userType))->count();
                $totalcount += $userCount;
            }

            // Now, $userCounts contains the counts of users for each unique user_type value for the current survey
            // You can use $userCounts as needed for each survey
            $survey->total_count = $totalcount;
            $totalcount = 0;
        }

        return $surveys;
    }

    public function showSurvey($id)
    {
        $survey = new SurveyResource(SurveyEloquentModel::with(['questions' => function ($query) {
            $query->orderBy('order', 'asc'); // Replace 'your_question_column' with the actual column name in the questions table
        }, 'questions.options', 'survey_settings'])->find($id));

        return $survey;
    }

    public function createSurvey($request)
    {
        DB::beginTransaction();
        try {
            $surveyEloquent = SurveyMapper::toEloquent($request);
            $surveyEloquent->save();

            $survey_id = $surveyEloquent->id;

            $questions = json_decode($request->questions, true);
            $user_types = json_decode(request()->user_type);

            foreach ($user_types as $type) {
                $setting = [
                    "user_type" => $type,
                    "survey_id" => $survey_id
                ];
                $surveySettingRequest = SurveySettingMapper::fromRequest($setting);
                $surveySettingEloquent = SurveySettingMapper::toEloquent($surveySettingRequest);
                $surveySettingEloquent->save();
            }

            foreach ($questions as $key => $question) {
                $questionArray = [
                    'survey_id' => $survey_id,
                    'question_type' => $question['question_type'],
                    'question' => $question['question'],
                    'order' => $key
                ];
                $questionRequest = QuestionMapper::fromRequest($questionArray);
                $questionEloquent = QuestionMapper::toEloquent($questionRequest);
                $questionEloquent->save();

                $question_id = $questionEloquent->id;

                if ($questionEloquent->question_type != 'SHORT_ANSWER') {
                    $options = $question['options'];
                    foreach ($options as $option) {
                        if ($option !== '') {
                            $optionArray = [
                                'question_id' => $question_id,
                                'content' => $option,
                            ];
                            $optionRequest = QuestionOptionMapper::fromRequest($optionArray);
                            $questionOptionEloquent = QuestionOptionMapper::toEloquent($optionRequest);
                            $questionOptionEloquent->save();
                        }
                    }
                }
            }


            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }
    }

    public function updateSurvey(SurveyData $survey)
    {
        DB::beginTransaction();
        try {
            $surveyArray = $survey->toArray();
            $surveyEloquent = SurveyEloquentModel::query()->find($survey->id);
            $surveyEloquent->fill($surveyArray);
            $surveyEloquent->update();

            $user_types = json_decode(request()->user_type);

            if (count($user_types) > 0) {
                foreach ($surveyEloquent->survey_settings as $oldUserType) {
                    $oldUserType->delete();
                }

                foreach ($user_types as $type) {
                    $setting = [
                        "user_type" => $type,
                        "survey_id" => $surveyEloquent->id
                    ];
                    $surveySettingRequest = SurveySettingMapper::fromRequest($setting);
                    $surveySettingEloquent = SurveySettingMapper::toEloquent($surveySettingRequest);
                    $surveySettingEloquent->save();
                }
            }

            $questions = json_decode(request()->questions, true);
            foreach ($questions as $key => $question) {
                $questionEloquent = QuestionEloquentModel::find($question['id']);
                $questionEloquent->order = $key;
                $questionEloquent->update();
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }
    }

    public function delete(int $survey_id): void
    {
        $survey = SurveyEloquentModel::query()->findOrFail($survey_id);
        if($survey->responses->count() > 0){
            foreach($survey->responses as $response){
                $response->delete();
            }
        }
        $survey->delete();
    }

    public function createQuestion($request)
    {
        DB::beginTransaction();

        try {
            $last_order = QuestionEloquentModel::where('survey_id', $request->survey_id)->orderBy('order', 'desc')->value('order');

            $questionRequest = QuestionMapper::fromRequest([
                'survey_id' => $request->survey_id,
                'question_type' => $request->question_type,
                'question' => $request->question,
                'order' => $last_order + 1
            ]);

            $questionEloquent = QuestionMapper::toEloquent($questionRequest);
            $questionEloquent->save();

            $question_id = $questionEloquent->id;

            if ($questionEloquent->question_type != 'SHORT_ANSWER') {
                $options = json_decode($request->options, true);

                foreach ($options as $option) {
                    if ($option !== '') {
                        $optionArray = [
                            'question_id' => $question_id,
                            'content' => $option,
                        ];
                        $optionRequest = QuestionOptionMapper::fromRequest($optionArray);
                        $questionOptionEloquent = QuestionOptionMapper::toEloquent($optionRequest);
                        $questionOptionEloquent->save();
                    }
                }
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }
    }

    public function deleteQuestion(int $question_id): void
    {
        $question = QuestionEloquentModel::query()->findOrFail($question_id);
        $question->delete();
    }

    public function updateQuestion(QuestionData $question)
    {
        DB::beginTransaction();
        try {
            $questionArray = $question->toArray();
            $questionEloquent = QuestionEloquentModel::query()->with(['options'])->find($question->id);
            $questionEloquent->fill($questionArray);
            $questionEloquent->save();

            if ($questionEloquent->question_type != 'SHORT_ANSWER') {
                $oldOptions = $questionEloquent->options;

                foreach ($oldOptions as $oldOption) {
                    $oldOption->delete();
                }

                $question_id = $questionEloquent->id;
                $newOptions = json_decode($questionArray['options'], true);

                foreach ($newOptions as $option) {
                    if ($option !== '') {
                        $optionArray = [
                            'question_id' => $question_id,
                            'content' => $option,
                        ];
                        $optionRequest = QuestionOptionMapper::fromRequest($optionArray);
                        $questionOptionEloquent = QuestionOptionMapper::toEloquent($optionRequest);
                        $questionOptionEloquent->save();
                    }
                }
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }
    }

    public function getProfilingSurvey()
    {
        $profilingSurvey = new SurveyResource(SurveyEloquentModel::with(['questions' => function ($query) {
            $query->orderBy('order', 'asc'); // Replace 'your_question_column' with the actual column name in the questions table
        }, 'questions.options'])->where('type', 'PROFILING')->first());

        return $profilingSurvey;
    }

    public function storeOrder(Request $request, SurveyEloquentModel $survey)
    {
        $questions = json_decode($request->questions, true);

        foreach ($questions as $key => $question) {
            $questionEloquent = QuestionEloquentModel::find($question['id']);
            $questionEloquent->order = $key;
            $questionEloquent->update();
        }
    }

    public function getSurveyByRole($appear_on)
    {
        $user = auth()->user();
        $user_type = $this->checkRole($user->role->name);
        if ($user_type != 'BC') {
            $currentDateTime = now()->format('Y-m-d H:i:s'); // Format current datetime

            $surveyEloquentModel = SurveyEloquentModel::where('appear_on', $appear_on)
                ->where('type', 'USEREXP')
                ->whereHas('survey_settings', function ($query) use ($user_type) {
                    $query->where('user_type', $user_type);
                })
                ->where('start_date', '<=', $currentDateTime) // Check if start_date is less than or equal to the current datetime
                ->where('end_date', '>=', $currentDateTime) // Check if end_date is greater than or equal to the current datetime
                ->with([
                    'questions.options',
                    'responses' => function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    }
                ])
                ->latest()->first();
            
            return ($surveyEloquentModel && $surveyEloquentModel->responses->count() == 0) ? $surveyEloquentModel : '';
        } else {
            return '';
        }
    }

    public function checkRole($role)
    {
        switch ($role) {
            case 'Teacher':
                return 'ORG_TEACHER';
                break;
            case 'BC Subscriber':
                return 'B2C_USER';
                break;
            case 'Organisation Admin':
                return 'ORG_ADMIN';
                break;
            case 'Student':
                return 'STUDENT';
                break;
            case 'Parent':
                return 'PARENT';
                break;
            case 'BC Staff' || 'BC Super Admin':
                return 'BC';
                // Code to handle the 'user' role
                break;
            default:
                // Code to handle roles other than 'teacher', 'staff', and 'user'
                break;
        }
    }

    public function checkRoleIDs($userType)
    {
        switch ($userType) {
            case 'ORG_TEACHER':
                return 4;
                break;
            case 'B2C_USER':
                return 2;
                break;
            case 'ORG_ADMIN':
                return 5;
                break;
            case 'STUDENT':
                return 6;
                break;
            case 'PARENT':
                return 7;
                break;
            default:
                break;
        }
    }
}
