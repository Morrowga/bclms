<?php

namespace Src\BlendedConcept\Survey\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Survey\Domain\Model\Entities\Question;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\QuestionEloquentModel;

class QuestionMapper
{
    public static function fromRequest(Array $request, $question_id = null): Question
    {

        return new Question(
            id: $question_id,
            survey_id: $request['survey_id'],
            question_type: $request['question_type'],
            question: $request['question'],
        );
    }

    public static function toEloquent(Question $question): QuestionEloquentModel
    {
        $questionEloquent = new QuestionEloquentModel();

        if ($question->id) {
            $questionEloquent = QuestionEloquentModel::query()->findOrFail($question->id);
        }

        $questionEloquent->id = $question->id;
        $questionEloquent->survey_id = $question->survey_id;
        $questionEloquent->question_type = $question->question_type;
        $questionEloquent->question = $question->question;

        return $questionEloquent;
    }
}
