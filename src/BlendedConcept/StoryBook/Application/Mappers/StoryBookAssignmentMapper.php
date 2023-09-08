<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\StoryBookAssignment;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookAssignmentEloquentModel;

class StoryBookAssignmentMapper
{
    public static function fromRequest(Request $request, $storybook_assignment_id = null): StoryBookAssignment
    {
        return new StoryBookAssignment(
            id : $storybook_assignment_id,
            storybook_version_id : $this->storybook_version_id,
            student_id : $this->student_id,
        );
    }

    public static function toEloquent(StoryBookAssignment $storyBookAssignment): StoryBookAssignmentEloquentModel
    {
        $storyBookAssginmentEloquent = new StoryBookAssignmentEloquentModel();

        if ($storyBookAssignment->id) {
            $storyBookAssginmentEloquent = StoryBookAssignmentEloquentModel::query()->findOrFail($storyBookAssignment->id);
        }
        $storyBookAssginmentEloquent->id = $storyBookAssignment->id;
        $storyBookAssginmentEloquent->storybook_version_id = $storyBookAssignment->storybook_version_id;
        $storyBookAssginmentEloquent->student_id = $storyBookAssignment->student_id;

        return $storyBookAssginmentEloquent;
    }
}
