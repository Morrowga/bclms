<?php

namespace Src\BlendedConcept\ClassRoom\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;

use Src\BlendedConcept\ClassRoom\Application\Mappers\ClassRoomMapper;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\BlendedConcept\ClassRoom\Domain\Model\ClassRoom;
use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomData;
use Src\BlendedConcept\ClassRoom\Domain\Resources\ClassRoomResource;
use Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels\ClassRoomEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
class ClassRoomRepository implements ClassRoomRepositoryInterface
{
    public function getClassRooms($filters)
    {
        $paginate_classrooms
                = ClassRoomResource
                    ::collection(ClassRoomEloquentModel::filter($filters)
                    ->with('teacher','students')
                    ->orderBy('id', 'desc')
                    ->paginate($filters['perPage'] ?? 10));
        $default_classrooms = ClassRoomEloquentModel::get();
        return [
            "paginate_classrooms" => $paginate_classrooms,
            "default_classrooms" => $default_classrooms
        ];
    }
    public function createClassRoom(ClassRoom $classRoom)
    {




        DB::beginTransaction();

        try {

            $createClassRoomEloquent = ClassRoomMapper::toEloquent($classRoom);
            $createClassRoomEloquent->save();
            $createClassRoomEloquent->students()->sync($classRoom->students);
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }

        DB::commit();
    }
    public function updateClassRoom(ClassRoomData $classRoomData)
    {
        DB::beginTransaction();
        try {
            $ClassRoomArray = $classRoomData->toArray();
            $updateClassRoomEloquent = ClassRoomEloquentModel::findOrFail($classRoomData->id);
            $updateClassRoomEloquent->fill($ClassRoomArray);
            $updateClassRoomEloquent->save();
            $updateClassRoomEloquent->students()->sync($classRoomData->students);

        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }

        DB::commit();
    }


    public function getTeachers()
    {
        return UserEloquentModel::whereHas("roles",function($query)
        {
            $query->where("roles.name","Teacher");
        })->get();
    }
    public function getStudents()
    {
        return StudentEloquentModel::get();
    }
}
