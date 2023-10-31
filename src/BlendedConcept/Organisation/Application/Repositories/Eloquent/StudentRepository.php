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
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class StudentRepository implements StudentRepositoryInterface
{
    public function getStudents($filters)
    {
        $auth = auth()->user()->role;
        if ($auth->name == 'B2C Parent' || $auth->name == "Both Subscription") {
            $parent = auth()->user()->parents;
            $users = StudentResource::collection(StudentEloquentModel::filter($filters)
                ->where('parent_id', $parent->parent_id)
                ->with(['organisation', 'user', 'disability_types', 'learningneeds', 'parent'])
                ->paginate($filters['perPage'] ?? 10));
        } else {
            $users = StudentResource::collection(StudentEloquentModel::filter($filters)
                ->where('organisation_id', auth()->user()->organisation_id)
                ->with(['organisation', 'user', 'disability_types', 'learningneeds', 'parent'])
                ->paginate($filters['perPage'] ?? 10));
        }

        return $users;
    }
    public function createStudent(Student $student)
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
            $total_students_licenses = $organisation->subscription->b2b_subscription->num_student_license;
            $current_student_count = StudentEloquentModel::where('organisation_id', $org_id)->count();
            $coming_student_count = $current_student_count + 1;
            if ($total_students_licenses >= $coming_student_count) {
                $create_user_data = [
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,

                    'role_id' => 6,
                    'password' => 'password'
                ];
                $create_parent_data = [
                    'first_name' => $student->parent_first_name,
                    'last_name' => $student->parent_last_name,
                    'contact_number' => $student->contact_number,
                    'email' => $student->email,
                    'role_id' => 7,
                    'password' => 'password'
                ];
                $userParentEloquent = UserEloquentModel::create($create_parent_data);

                $parentEloquent = ParentUserEloquentModel::create([
                    "user_id" => $userParentEloquent->id,
                    "organisation_id" => $org_id,
                    "type" => "B2B"
                ]);
                $userEloquent = UserEloquentModel::create($create_user_data);
                $StudentEloquentModel = StudentMapper::toEloquent($student);
                $StudentEloquentModel->user_id = $userEloquent->id;
                $StudentEloquentModel->parent_id = $parentEloquent->parent_id;
                $StudentEloquentModel->organisation_id = $org_id;
                $StudentEloquentModel->save();
                $StudentEloquentModel->disability_types()->sync($student->disability_types);
                $StudentEloquentModel->learningneeds()->sync($student->learning_needs);

                // media library save images
                if (request()->hasFile('profile_pics') && request()->file('profile_pics')->isValid()) {
                    $StudentEloquentModel->addMediaFromRequest('profile_pics')->toMediaCollection('profile_pics', 'media_organisation');
                    $userEloquent->profile_pic = $StudentEloquentModel->getFirstMediaUrl('profile_pics');
                    $userEloquent->update();
                }
                DB::commit();
            } else {
                return throw new \Exception("License not enough to create student");
            }
        } catch (\Exception $error) {
            DB::rollBack();
            return throw new \Exception($error->getMessage());
        }
    }

    public function updateStudent(StudentData $studentData)
    {

        DB::beginTransaction();
        try {
            $studentDataArrary = $studentData->toArray();

            $studentEloquentModel = StudentEloquentModel::query()->findOrFail($studentData->student_id);
            $user_id = $studentEloquentModel->user_id;
            $parent_id = $studentEloquentModel->parent_id;
            $org_id = $studentEloquentModel->organisation_id;
            $studentEloquentModel->fill($studentDataArrary);
            $studentEloquentModel->organisation_id = $org_id;
            $studentEloquentModel->update();
            $studentEloquentModel->disability_types()->sync($studentData->disability_types);
            $studentEloquentModel->learningneeds()->sync($studentData->learning_needs);

            //for media file upload
            $userEloquentModel = UserEloquentModel::find($user_id);
            $userEloquentModel->update([
                'first_name' => $studentData->first_name,
                'last_name' => $studentData->last_name,
            ]);
            $parentEloquentModel = ParentEloquentModel::find($parent_id);

            $parentUserEloquemtModel = UserEloquentModel::find($parentEloquentModel->user_id);
            $parentUserEloquemtModel->update([
                'first_name' => $studentData->parent_first_name,
                'last_name' => $studentData->parent_last_name,
                'email' => $studentData->email,
                'contact_number' => $studentData->contact_number,

            ]);

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
