<?php

namespace Src\BlendedConcept\Teacher\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Domain\Model\Teacher;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;

class TeacherMapper
{
    public static function fromRequest(Request $request, $teacher_id = null): Teacher
    {
        return new Teacher(
            teacher_id: $teacher_id,
            user_id: $request->user_id,
            organisation_id: $request->organisation_id,
            allocated_storage_limit: $request->allocated_storage_limit,
            curr_subscription_id: $request->curr_subscription_id
        );
    }

    public static function toEloquent(Teacher $teacher): UserEloquentModel
    {
        $TeacherEloquent = new TeacherEloquentModel();

        if ($teacher->teacher_id) {
            $TeacherEloquent = TeacherEloquentModel::query()->findOrFail($teacher->teacher_id);
        }
        $TeacherEloquent->teacher_id = $teacher->teacher_id;
        $TeacherEloquent->user_id = $teacher->user_id;
        $TeacherEloquent->organisation_id = $teacher->organisation_id;
        $TeacherEloquent->allocated_storage_limit = $teacher->allocated_storage_limit;


        return $TeacherEloquent;
    }
}
