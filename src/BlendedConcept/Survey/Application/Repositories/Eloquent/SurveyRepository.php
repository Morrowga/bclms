<?php

namespace Src\BlendedConcept\Survey\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Survey\Application\DTO\QuestionData;
use Src\BlendedConcept\Survey\Application\DTO\SurveyData;
use Src\BlendedConcept\Survey\Application\Mappers\QuestionMapper;
use Src\BlendedConcept\Survey\Application\Mappers\QuestionOptionMapper;
use Src\BlendedConcept\Survey\Application\Mappers\SurveyMapper;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Src\BlendedConcept\Survey\Domain\Resources\SurveyResource;
use Src\BlendedConcept\Survey\Domain\Resources\SurveyResultResource;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\QuestionEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\ResponseEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;

class SurveyRepository implements SurveyRepositoryInterface
{
    public function getUserExperienceSurveyList($filters = [])
    {
        $surveys = SurveyResource::collection(SurveyEloquentModel::filter($filters)->where('type', 'USERREXP')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $surveys;
    }

    public function showSurvey($id)
    {
        $survey = new SurveyResource(SurveyEloquentModel::with('questions.options')->find($id));

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

            foreach ($questions as $question) {
                $questionArray = [
                    'survey_id' => $survey_id,
                    'question_type' => $question['question_type'],
                    'question' => $question['question'],
                ];
                $questionRequest = QuestionMapper::fromRequest($questionArray);
                $questionEloquent = QuestionMapper::toEloquent($questionRequest);
                $questionEloquent->save();

                $question_id = $questionEloquent->id;

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
            $surveyEloquent->save();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }
    }

    public function delete(int $survey_id): void
    {
        $survey = SurveyEloquentModel::query()->findOrFail($survey_id);
        $survey->delete();
    }

    public function createQuestion($request)
    {
        DB::beginTransaction();

        try {
            $questionRequest = QuestionMapper::fromRequest([
                'survey_id' => $request->survey_id,
                'question_type' => $request->question_type,
                'question' => $request->question,
            ]);

            $questionEloquent = QuestionMapper::toEloquent($questionRequest);
            $questionEloquent->save();

            $question_id = $questionEloquent->id;

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
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }
    }

    public function getProfilingSurvey()
    {
        $profilingSurvey = new SurveyResource(SurveyEloquentModel::with('questions.options')->where('type', 'PROFILING')->first());

        return $profilingSurvey;
    }

    public function getSurveyResults($filters = [])
    {
        $surveyResults = SurveyResultResource::collection(ResponseEloquentModel::filter($filters)->with(['user', 'student', 'question.survey'])->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $surveyResults;
    }
}
