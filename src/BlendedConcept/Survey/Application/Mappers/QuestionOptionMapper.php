<?php

namespace Src\BlendedConcept\Survey\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Survey\Domain\Model\Entities\QuestionOption;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\QuestionOptionEloquentModel;

class QuestionOptionMapper
{
    public static function fromRequest(Request $request, $question_option_id = null): QuestionOption
    {

        return new QuestionOption(
            id: $question_option_id,
            question_id: $request->question_id,
            content: $request->content,
        );
    }

    public static function toEloquent(QuestionOption $questionOption): QuestionOptionEloquentModel
    {
        $questionOptionEloquent = new QuestionOptionEloquentModel();

        if ($questionOption->id) {
            $questionOptionEloquent = QuestionOptionEloquentModel::query()->findOrFail($questionOption->id);
        }

        $questionOptionEloquent->id = $questionOption->id;
        $questionOptionEloquent->question_id = $questionOption->question_id;
        $questionOptionEloquent->content = $questionOption->content;

        return $questionOptionEloquent;
    }
}
