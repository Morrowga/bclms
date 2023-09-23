<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\StoryBookVersion;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;

class StoryBookVersionMapper
{
    public static function fromRequest(Request $request, $storybook_version_id = null): StoryBookVersion
    {
        return new StoryBookVersion(
            id : $storybook_version_id,
            storybook_id : $request->storybook_id,
            teacher_id : $request->teacher_id,
            name : $request->name,
            description : $request->description,
        );
    }

    public static function toEloquent(StoryBookVersion $storyBookVersion): StoryBookVersionEloquentModel
    {
        $storyBookVersionEloquent = new StoryBookVersionEloquentModel();

        if ($storyBookVersion->id) {
            $storyBookVersionEloquent = StoryBookVersionEloquentModel::query()->findOrFail($storyBookVersion->id);
        }
        $storyBookVersionEloquent->id = $storyBookVersion->id;
        $storyBookVersionEloquent->storybook_id = $storyBookVersion->storybook_id;
        $storyBookVersionEloquent->teacher_id = $storyBookVersion->teacher_id;
        $storyBookVersionEloquent->name = $storyBookVersion->name;
        $storyBookVersionEloquent->description = $storyBookVersion->description;

        return $storyBookVersionEloquent;
    }
}
