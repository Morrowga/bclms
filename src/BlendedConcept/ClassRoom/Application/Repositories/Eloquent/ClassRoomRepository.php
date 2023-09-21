<?php

namespace Src\BlendedConcept\ClassRoom\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomData;
use Src\BlendedConcept\ClassRoom\Application\Mappers\ClassRoomMapper;
use Src\BlendedConcept\ClassRoom\Domain\Model\ClassRoom;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\BlendedConcept\ClassRoom\Domain\Resources\ClassRoomResource;
use Src\BlendedConcept\ClassRoom\Domain\Resources\StudentResource;
use Src\BlendedConcept\ClassRoom\Domain\Resources\TeacherResource;
use Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels\ClassRoomEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class ClassRoomRepository implements ClassRoomRepositoryInterface
{
    public function getClassRooms($filters)
    {
        $paginate_classrooms
            = ClassRoomResource::collection(ClassRoomEloquentModel::filter($filters)
                ->withCount('teachers', 'students')
                ->where('organization_id', auth()->user()->organization_id)
                ->orderBy('id', 'desc')
                ->paginate($filters['perPage'] ?? 10));
        $default_classrooms = ClassRoomEloquentModel::get();

        return [
            'paginate_classrooms' => $paginate_classrooms,
            'default_classrooms' => $default_classrooms,
        ];
    }

    public function createClassRoom(ClassRoom $classRoom)
    {

        DB::beginTransaction();

        try {

            $createClassRoomEloquent = ClassRoomMapper::toEloquent($classRoom);
            $createClassRoomEloquent->organization_id = auth()->user()->organization_id;
            $createClassRoomEloquent->save();
            $createClassRoomEloquent->students()->sync($classRoom->students);
            $createClassRoomEloquent->teachers()->sync($classRoom->teachers);

            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $createClassRoomEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_classroom');
            }

            if ($createClassRoomEloquent->getMedia('image')->isNotEmpty() && $createClassRoomEloquent->getMedia('image')->isNotEmpty()) {
                $createClassRoomEloquent->classroom_photo = $createClassRoomEloquent->getMedia('image')[0]->original_url;
                $createClassRoomEloquent->update();
            }
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
            $updateClassRoomEloquent->update();
            $updateClassRoomEloquent->students()->sync($classRoomData->students);
            $updateClassRoomEloquent->teachers()->sync($classRoomData->teachers);
            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $old_image = $updateClassRoomEloquent->getFirstMedia('image');
                if ($old_image != null) {
                    $old_image->forceDelete();
                }

                $newMediaItem = $updateClassRoomEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_classroom');

                if ($newMediaItem->getUrl()) {
                    $updateClassRoomEloquent->classroom_photo = $newMediaItem->getUrl();
                    $updateClassRoomEloquent->update();
                }
            }
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }

        DB::commit();
    }

    public function getTeachers($filters)
    {
        return  UserEloquentModel::filter($filters)->whereHas('role_user', function ($query) {
            $query->where('name', 'Teacher');
        })->paginate($filters['perPage'] ?? 10);
    }

    public function getStudents($filters)
    {
        return  StudentEloquentModel::filter($filters)->with('user', 'disability_types')->paginate($filters['perPage'] ?? 10);
    }
}
