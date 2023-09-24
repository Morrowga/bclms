<?php

namespace Src\BlendedConcept\Organization\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Organization\Application\DTO\TeacherData;
use Src\BlendedConcept\Organization\Application\Mappers\TeacherMapper;
use Src\BlendedConcept\Organization\Domain\Model\Entities\Teacher;
use Src\BlendedConcept\Organization\Domain\Repositories\TeacherRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Resources\TeacherResource;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class TeacherRepository implements TeacherRepositoryInterface
{
    /***
     *
     *
     *
     */
    public function getTeachers($filters)
    {
        //set roles
        $users = TeacherResource::collection(UserEloquentModel::filter($filters)
            ->with(['role_user', 'b2bUser'])
            ->whereHas('b2bUser', function ($query) {
                return $query->where('organization_id', auth()->user()->b2bUser->organization_id);
            })
            ->whereHas('role_user', function ($query) {
                return $query->where('name', 'Teacher');
            })
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 10));

        return $users;
    }

    public function showTeacher($id)
    {
        $teacher = new TeacherResource(UserEloquentModel::where('id', $id)->first());

        return $teacher;
    }

    public function CreateTeacher(Teacher $teacher)
    {

        DB::beginTransaction();

        try {
            $userEloquent = TeacherMapper::toEloquent($teacher);
            //verify teacher just now
            $userEloquent->email_verification_send_on = now();
            $userEloquent->save();

            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $userEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_teachers');
            }

            if ($userEloquent->getMedia('image')->isNotEmpty()) {
                $userEloquent->profile_pic = $userEloquent->getMedia('image')[0]->original_url;
                $userEloquent->update();
            }

            $b2bUserEloquent = new B2bUserEloquentModel();
            $b2bUserEloquent->user_id = $userEloquent->id;
            $b2bUserEloquent->organization_id = auth()->user()->b2bUser->organization_id;
            $b2bUserEloquent->allocated_storage_limit = 0.0;
            $b2bUserEloquent->has_full_library_access = 0;
            $b2bUserEloquent->save();
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }
    }

    //  update user
    public function updateTeacher(TeacherData $teacherData)
    {
        DB::beginTransaction();

        try {

            $teacherArray = $teacherData->toArray();
            $updateUserEloquent = UserEloquentModel::query()->findOrFail($teacherData->id);
            $updateUserEloquent->fill($teacherArray);
            $updateUserEloquent->update();

            //  delete image if reupload or insert if does not exit
            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $old_image = $updateUserEloquent->getFirstMedia('image');
                if ($old_image != null) {
                    $old_image->forceDelete();
                }

                $newMediaItem = $updateUserEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_teachers');

                if ($newMediaItem->getUrl()) {
                    $updateUserEloquent->profile_pic = $newMediaItem->getUrl();
                    $updateUserEloquent->update();
                }
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }
    }

    public function delete(int $teacher_id): void
    {
        $teacher = UserEloquentModel::query()->findOrFail($teacher_id);
        $teacher->clearMediaCollection('image'); // Replace with the actual collection name
        $teacher->delete();
    }
}
