<?php

namespace Src\BlendedConcept\Organisation\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
use Src\BlendedConcept\Organisation\Application\DTO\StudentData;
use Src\BlendedConcept\Organisation\Application\Mappers\StudentMapper;
use Src\BlendedConcept\Organisation\Domain\Model\Entities\Student;
use Src\BlendedConcept\Organisation\Domain\Repositories\StudentRepositoryInterface;
use Src\BlendedConcept\Organisation\Domain\Resources\StudentResource;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class StudentRepository implements StudentRepositoryInterface
{
    public function getStudents($filters)
    {
        $users = StudentResource::collection(StudentEloquentModel::filter($filters)
            ->with(['organisation', 'user', 'disability_types', 'learningneeds'])
            ->paginate($filters['perPage'] ?? 10));

        return $users;
    }

    public function createStudent(Student $student)
    {

        DB::beginTransaction();
        try {
            $user = UserEloquentModel::create([
                'role_id' => 6,
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'email' => $student->email,
                'contact_number' => $student->contact_number,
            ]);
            $StudentEloquentModel = StudentMapper::toEloquent($student);
            $StudentEloquentModel->user_id = $user->id;
            $StudentEloquentModel->save();
            $StudentEloquentModel->organisations()->sync(auth()->user()->organisation_id);
            $StudentEloquentModel->disability_types()->sync($student->disability_types);
            $StudentEloquentModel->learningneeds()->sync($student->learning_needs);

            // media library save images
            if (request()->hasFile('profile_pics') && request()->file('profile_pics')->isValid()) {
                $StudentEloquentModel->addMediaFromRequest('profile_pics')->toMediaCollection('profile_pics', 'media_organisation');
                $user->profile_pic = $StudentEloquentModel->getFirstMediaUrl('profile_pics');
                $user->update();
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }
    }

    public function updateStudent(StudentData $studentData)
    {

        DB::beginTransaction();
        try {
            $studentDataArrary = $studentData->toArray();

            $user = UserEloquentModel::find($studentData->user_id)
                ->update([
                    'first_name' => $studentData->first_name,
                    'last_name' => $studentData->last_name,
                    'email' => $studentData->email,
                    'contact_number' => $studentData->contact_number,
                ]);

            $studentEloquentModel = StudentEloquentModel::query()->findOrFail($studentData->student_id);
            $studentEloquentModel->fill($studentDataArrary);
            $studentEloquentModel->update();
            $studentEloquentModel->disability_types()->sync($studentData->disability_types);
            $studentEloquentModel->learningneeds()->sync($studentData->learning_needs);

            //for media file upload

            if (request()->hasFile('profile_pics') && request()->file('profile_pics')->isValid()) {
                $old_image = $studentEloquentModel->getFirstMedia('profile_pics');
                if ($old_image !== null) {
                    $old_image->delete();
                }

                $newMediaItem = $studentEloquentModel->addMediaFromRequest('profile_pics')->toMediaCollection('profile_pics', 'media_organisation');

                if ($newMediaItem->getUrl()) {
                    $userEloquentModel = UserEloquentModel::find($studentData->user_id);
                    $userEloquentModel->profile_pic = $newMediaItem->getUrl();
                    $userEloquentModel->update();
                }
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }
    }

    public function deleteStudent($student)
    {
        $student->delete();
    }

    /**
     * Get all sub learning needs.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLearningNeed()
    {
        // Retrieve all sub learning needs
        $learningNeeds = SubLearningTypeEloquentModel::get(['id', 'name']);

        return $learningNeeds;
    }

    /**
     * Get all disability types.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getdisabilitytype()
    {
        // Retrieve all disability types
        $disabilityTypes = DisabilityTypeEloquentModel::get(['id', 'name']);

        return $disabilityTypes;
    }
}
