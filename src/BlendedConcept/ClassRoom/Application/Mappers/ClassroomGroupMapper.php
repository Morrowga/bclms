<?php

namespace Src\BlendedConcept\ClassRoom\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Classroom\Domain\Model\Entities\ClassRoomGroup;
use Src\BlendedConcept\Classroom\Infrastructure\EloquentModels\ClassRoomGroupEloquentModel;

class ClassRoomGroupMapper
{
    public static function fromRequest(Request $request, $classroom_group_id = null): ClassRoomGroup
    {
        return new ClassRoomGroup(
            id: $classroom_group_id,
            classroom_id: $request->classroom_id,
            name: $request->name,
        );
    }

    public static function toEloquent(ClassRoomGroup $classromGroup): ClassRoomGroupEloquentModel
    {
        $classRoomGroupEloquent = new ClassRoomGroupEloquentModel();

        if ($classromGroup->id) {
            $classRoomGroupEloquent = ClassRoomGroupEloquentModel::query()->findOrFail($classromGroup->id);
        }
        $classRoomGroupEloquent->id = $classromGroup->id;
        $classRoomGroupEloquent->classroom_id = $classromGroup->classroom_id;
        $classRoomGroupEloquent->name = $classromGroup->name;

        return $classRoomGroupEloquent;
    }
}
