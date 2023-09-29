<?php

namespace Src\BlendedConcept\ClassRoom\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\ClassRoom\Domain\Model\ClassRoom;
use Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels\ClassRoomEloquentModel;

class ClassRoomMapper
{
    public static function fromRequest(Request $request, $classroom_id = null): ClassRoom
    {
        return new ClassRoom(
            id: $classroom_id,
            organisation_id: $request->organisation_id,
            name: $request->name,
            description: $request->description,
            classroom_photo: $request->classroom_photo,
            teachers: $request->teachers,
            students: $request->students
        );
    }

    public static function toEloquent(ClassRoom $classRoom): ClassRoomEloquentModel
    {
        $classRoomEloquent = new ClassRoomEloquentModel();

        if ($classRoom->id) {
            $classRoomEloquent = ClassRoomEloquentModel::query()->findOrFail($classRoom->id);
        }
        $classRoomEloquent->id = $classRoom->id;
        $classRoomEloquent->organisation_id = auth()->user()->organisation_id;
        $classRoomEloquent->name = $classRoom->name;
        $classRoomEloquent->description = $classRoom->description;
        $classRoomEloquent->classroom_photo = $classRoom->classroom_photo;

        return $classRoomEloquent;
    }
}
