<?php

namespace Src\BlendedConcept\Survey\Application\Repositories\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Survey\Application\DTO\SurveyData;
use Src\BlendedConcept\Survey\Application\DTO\QuestionData;
use Src\BlendedConcept\Survey\Domain\Resources\SurveyResource;
use Src\BlendedConcept\Survey\Application\Mappers\SurveyMapper;
use Src\BlendedConcept\Survey\Application\Mappers\QuestionMapper;
use Src\BlendedConcept\Survey\Domain\Resources\SurveyResultResource;
use Src\BlendedConcept\Survey\Application\Mappers\QuestionOptionMapper;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\QuestionEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\ResponseEloquentModel;

class SurveyRepository implements SurveyRepositoryInterface
{
    public function getUserExperienceSurveyList($filters = [])
    {
        $surveys = SurveyResource::collection(SurveyEloquentModel::filter($filters)->where('type', 'USEREXP')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $surveys;
    }

    public function showSurvey($id)
    {
        $survey = new SurveyResource(SurveyEloquentModel::with(['questions' => function ($query) {
            $query->orderBy('order', 'asc'); // Replace 'your_question_column' with the actual column name in the questions table
        }, 'questions.options'])->find($id));

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

                if($questionEloquent->question_type != 'SHORT_ANSWER'){
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
            $surveyEloquent->save();

            $questions = json_decode(request()->questions, true);
            foreach($questions as $key => $question){
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

            if($questionEloquent->question_type != 'SHORT_ANSWER'){
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

            if($questionEloquent->question_type != 'SHORT_ANSWER'){
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

        foreach($questions as $key => $question){
            $questionEloquent = QuestionEloquentModel::find($question['id']);
            $questionEloquent->order = $key;
            $questionEloquent->update();
        }

    }

    public function getSurveyResults($filters)
    {
        $surveyResults = SurveyResultResource::collection(ResponseEloquentModel::filter($filters)->with(['user', 'student', 'question.survey'])->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $surveyResults;
    }
}
