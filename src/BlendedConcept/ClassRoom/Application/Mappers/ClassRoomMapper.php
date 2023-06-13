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
            organization_id: $request->organization_id,
            name: $request->name,
            teacher_id: $request->teacher_id,
            venue: $request->venue,
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
        $classRoomEloquent->organization_id = auth()->user()->organization_id;
        $classRoomEloquent->name = $classRoom->name;
        $classRoomEloquent->teacher_id = $classRoom->teacher_id;
        $classRoomEloquent->venue = $classRoom->venue;
        return $classRoomEloquent;
    }
}
