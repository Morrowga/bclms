<?php

namespace Src\BlendedConcept\Teacher\Application\Repositories\Eloquent;

use Src\BlendedConcept\Teacher\Domain\Repositories\TeacherRepositoryInterface;

use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Domain\Resources\TeacherResource;
use Src\BlendedConcept\Teacher\Application\DTO\TeacherData;
use Src\BlendedConcept\Teacher\Application\Mappers\TeacherMapper;
use Src\BlendedConcept\Teacher\Domain\Model\Teacher;

class TeacherRepository implements TeacherRepositoryInterface
{

    /***
     *
     *
     *
     */
    public function getTeachers($filters = [])
    {
        //set roles
        $users = TeacherResource
            ::collection(UserEloquentModel::filter($filters)
                ->where("organization_id",auth()->user()->organization_id)
                ->with('roles')
                ->whereHas('roles', function ($query) {
                    return $query->where("name", "Teacher");
                })
                ->orderBy('id', 'desc')
                ->paginate($filters['perPage'] ?? 10));


        return $users;
    }
    public function CreateTeacher(Teacher $teacher)
    {

        $userEloquent = TeacherMapper::toEloquent($teacher);
        $userEloquent->save();
        if (request()->hasFile('image') && request()->file('image')->isValid()) {
            $userEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_teachers');
        }

        $userEloquent->roles()->sync(request('role'));
    }

    //  update user
    public function updateTeacher(TeacherData $teacherData)
    {

        $teacherArray = $teacherData->toArray();
        $updateUserEloquent = UserEloquentModel::query()->findOrFail($teacherData->id);
        $updateUserEloquent->fill($teacherArray);
        $updateUserEloquent->save();

        //  delete image if reupload or insert if does not exit
        if (request()->hasFile('image') && request()->file('image')->isValid()) {

            $old_image = $updateUserEloquent->getFirstMedia('image');
            if ($old_image != null) {
                $old_image->delete();

                $updateUserEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_teachers');
            } else {

                $updateUserEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_teachers');
            }
        }


        $updateUserEloquent->roles()->sync(request('role'));
    }
}
