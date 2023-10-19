<?php

namespace Src\BlendedConcept\Organisation\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Organisation\Application\DTO\TeacherData;
use Src\BlendedConcept\Organisation\Domain\Model\Entities\Teacher;
use Src\BlendedConcept\Organisation\Domain\Resources\TeacherResource;
use Src\BlendedConcept\Organisation\Application\Mappers\TeacherMapper;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Src\BlendedConcept\Organisation\Domain\Repositories\TeacherRepositoryInterface;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;

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
        $teachersCollection = TeacherResource::collection(TeacherEloquentModel::filter($filters)
            ->with(['user'])
            ->where('organisation_id', auth()->user()->organisation_id)
            ->orderBy('teacher_id', 'desc')
            ->paginate($filters['perPage'] ?? 10));

        return $teachersCollection;
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
            $org_id = auth()->user()->organisation_id;
            $organisation = OrganisationEloquentModel::find($org_id);
            $organisation->load('subscription.b2b_subscription');
            if (!isset($organisation->subscription)) {
                return throw new \Exception("Organisation doesn't have subscription");
            } else if (!isset($organisation->subscription->b2b_subscription)) {
                return throw new \Exception("Organisation doesn't have subscription");
            }
            $total_teachers_licenses = $organisation->subscription->b2b_subscription->num_teacher_license;
            $current_teacher_count = TeacherEloquentModel::where('organisation_id', $org_id)->count();
            $coming_teacher_count = $current_teacher_count + 1;
            if ($total_teachers_licenses >= $coming_teacher_count) {
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

                $teacher = new TeacherEloquentModel();
                $teacher->user_id = $userEloquent->id;
                $teacher->organisation_id = $org_id;
                $teacher->save();

                DB::commit();
            } else {
                return throw new \Exception("License not enough to create teacher");
            }
        } catch (\Exception $error) {
            DB::rollBack();
            return throw new \Exception($error->getMessage());
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
            // dd($updateUserEloquent);

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
