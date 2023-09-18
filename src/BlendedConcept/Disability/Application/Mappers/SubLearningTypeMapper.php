<?php

namespace Src\BlendedConcept\Disability\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Disability\Domain\Model\Entities\SubLearningType;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;

class SubLearningTypeMapper
{
    public static function fromRequest(Request $request, $sub_learning_type_id = null): SubLearningType
    {
        return new SubLearningType(
            id: $sub_learning_type_id,
            learning_needs_id: $request->learning_needs_id,
            name: $request->name,
        );
    }

    public static function toEloquent(SubLearningType $subLearningType): SubLearningTypeEloquentModel
    {
        $subLearningTypeEloquent = new SubLearningTypeEloquentModel();

        if ($subLearningType->id) {
            $subLearningTypeEloquent = SubLearningTypeEloquentModel::query()->findOrFail($subLearningType->id);
        }
        $subLearningTypeEloquent->id = $subLearningType->id;
        $subLearningTypeEloquent->learning_needs_id = $subLearningType->learning_needs_id;
        $subLearningTypeEloquent->name = $subLearningType->name;

        return $subLearningTypeEloquent;
    }
}
