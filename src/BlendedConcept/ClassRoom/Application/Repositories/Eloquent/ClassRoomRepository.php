<?php

namespace Src\BlendedConcept\ClassRoom\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\ClassRoom\Domain\Model\ClassRoom;
use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomData;
use Src\Common\Infrastructure\Laravel\Notifications\BcNotification;
use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomGroupData;
use Src\BlendedConcept\ClassRoom\Domain\Resources\ClassRoomResource;
use Src\BlendedConcept\ClassRoom\Application\Mappers\ClassRoomMapper;
use Src\BlendedConcept\ClassRoom\Domain\Model\Entities\ClassRoomGroup;
use Src\BlendedConcept\ClassRoom\Application\Mappers\ClassRoomGroupMapper;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels\ClassRoomEloquentModel;
use Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels\ClassRoomGroupEloquentModel;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;

class ClassRoomRepository implements ClassRoomRepositoryInterface
{
    public function getClassRooms($filters)
    {
        $paginate_classrooms
            = ClassRoomResource::collection(ClassRoomEloquentModel::filter($filters)
                ->withCount('teachers', 'students')
                ->with('students.parent')
                ->where('organisation_id', auth()->user()->organisation_id)
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
            $createClassRoomEloquent->organisation_id = auth()->user()->organisation_id;
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
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }
    }

    public function updateClassRoom(ClassRoomData $classRoomData)
    {
        DB::beginTransaction();
        try {

            $classRoomArray = $classRoomData->toArray();
            $updateClassRoomEloquent = ClassRoomEloquentModel::findOrFail($classRoomData->id);
            $updateClassRoomEloquent->fill($classRoomArray);
            $updateClassRoomEloquent->update();
            $existingStudents = $updateClassRoomEloquent->students->pluck('student_id')->toArray();
            $newStudents = array_diff($classRoomData->students, $existingStudents);
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

            $org = $updateClassRoomEloquent->organisation->org_admin->user;

            foreach ($newStudents as $student) {
                $studentUser = StudentEloquentModel::where('student_id', $student)->first();
                $user = $studentUser->user;
                $org->notify(new BcNotification(['message' => 'New Student ' . $user->full_name . ' joined class ' . $updateClassRoomEloquent->name, 'from' => 'System', 'to' => 'Organisation', 'icon' => 'fa:fa-light fa-user', 'type' => 'HomeAnnounce']));
                foreach ($updateClassRoomEloquent->teachers as $teacher) {
                    $orgteacher = $teacher->user;
                    $orgteacher->notify(new BcNotification(['message' => 'New Student ' . $user->full_name . ' joined class ' . $updateClassRoomEloquent->name, 'from' => 'System', 'to' => 'Teacher', 'icon' => 'fa:fa-light fa-user', 'type' => 'HomeAnnounce']));
                }
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }
    }

    public function getTeachers($filters)
    {
        $organisation_id = auth()->user()->organisation_id;
        $data = UserEloquentModel::filter($filters)
            ->whereHas('role_user', function ($query) {
                $query->where('name', 'Teacher');
            })
            ->whereHas('b2bUser', function ($query) use ($organisation_id) {
                $query->where('organisation_id', $organisation_id);
            })
            ->paginate($filters['perPage'] ?? 10);

        $array_data = $data->map(function ($user) use ($organisation_id) {
            $usedStorage = MediaEloquentModel::where(function ($query) use ($organisation_id, $user) {
                $query->where('collection_name', 'videos')
                    ->where('organisation_id', $organisation_id)
                    ->where('teacher_id', $user->id)
                    ->whereIn('status', ['active', 'requested']);
            })
                ->sum('size');
            $used_storage_mb = $usedStorage == 0 ? $usedStorage : (int)($usedStorage / 1024 / 1024);
            $left_storage = $user->b2bUser->allocated_storage_limit - $used_storage_mb;
            return [
                "id" => $user->id,
                "full_name" => $user->full_name,
                "used_storage" => $used_storage_mb,
                "allocated_storage_limit" => $user->b2bUser->allocated_storage_limit,
                "contact_number" => $user->contact_number,
                "image_url" => $user->image_url,
                "left_storage" => $left_storage
            ];
        });
        return ["data" => $array_data];
    }

    public function getStudents($filters)
    {
        return StudentEloquentModel::filter($filters)
            ->where('organisation_id', auth()->user()->organisation_id)
            ->with('user', 'disability_types', 'parent')->paginate($filters['perPage'] ?? 10);
    }

    public function getOrgTeacherClassrooms($filters)
    {
        $classrooms
            = ClassRoomResource::collection(ClassRoomEloquentModel::filter($filters)
                ->withCount('teachers', 'students')
                ->where('organisation_id', auth()->user()->organisation_id)
                ->whereHas('teachers', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
                ->orderBy('id', 'desc')
                ->paginate($filters['perPage'] ?? 10));
        return $classrooms;
    }

    public function createClassRoomGroup(ClassRoomGroup $classroomGroup)
    {

        DB::beginTransaction();

        try {

            $createClassroomGroupEloquent = ClassRoomGroupMapper::toEloquent($classroomGroup);
            $createClassroomGroupEloquent->save();
            $createClassroomGroupEloquent->students()->sync($classroomGroup->students);
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }
    }

    public function updateClassRoomGroup(ClassRoomGroupData $classroomGroupData)
    {
        DB::beginTransaction();
        try {
            $classRoomArray = $classroomGroupData->toArray();
            $updateClassroomGroupEloquent = ClassroomGroupEloquentModel::findOrFail($classroomGroupData->id);
            $updateClassroomGroupEloquent->fill($classRoomArray);
            $updateClassroomGroupEloquent->update();
            $updateClassroomGroupEloquent->students()->sync($classroomGroupData->students);
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }
    }
}
