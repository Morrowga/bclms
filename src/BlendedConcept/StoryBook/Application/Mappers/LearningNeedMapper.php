<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\LearningNeed;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\LearningNeedEloquentModel;

class LearningNeedMapper
{
    public static function fromRequest(Request $request, $learning_need_id = null): LearningNeed
    {
        return new LearningNeed(
            id : $learning_need_id,
            name : $this->name,
            description : $this->description,
        );
    }

    public static function toEloquent(LearningNeed $learningNeed): LearningNeedEloquentModel
    {
        $learningNeedEloquent = new LearningNeedEloquentModel();

        if ($learningNeed->id) {
            $learningNeedEloquent = LearningNeedEloquentModel::query()->findOrFail($learningNeed->id);
        }
        $learningNeedEloquent->id = $learningNeed->id;
        $learningNeedEloquent->name = $learningNeed->name;
        $learningNeedEloquent->description = $learningNeed->description;

        return $learningNeedEloquent;
    }
}
