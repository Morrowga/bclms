<?php

namespace Src\BlendedConcept\Student\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Student\Application\DTO\StudentData;
use Src\BlendedConcept\Student\Application\Mappers\StudentMapper;
use Src\BlendedConcept\Student\Domain\Model\Student;
use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
use Src\BlendedConcept\Student\Domain\Resources\StudentResources;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class StudentRepository implements StudentRepositoryInterface
{
    /***
     *  @param $filters
     *
     *  this queries gets students list according to organizaiton_id
     *  with paginated data default is 10
     *  if organization exits
     */
    public function getStudent($filters)
    {
        $paginate_students = StudentResources::collection(
            StudentEloquentModel::with('user', 'organizations')
                ->filter($filters)
                ->orderBy('student_id', 'desc')
                // ->where('organization_id', auth()->user()->organization_id)
                ->paginate($filters['perPage'] ?? 10)
        );

        $default_students = StudentEloquentModel::latest()->take(5)->get();

        return [
            'paginate_students' => $paginate_students,
            'default_students' => $default_students,
        ];
    }

    public function createStudent(Student $student)
    {

        DB::beginTransaction();

        try {

            $createStudentEloqoent = StudentMapper::toEloquent($student);
            $createStudentEloqoent->save();
            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $createStudentEloqoent->addMediaFromRequest('image')->toMediaCollection('image', 'media_students');
            }
        } catch (\Exception $error) {
            DB::rollBack();
        }

        DB::commit();
    }

    public function updateStudent(StudentData $studentData)
    {
        DB::beginTransaction();
        try {
            $studentDataArray = $studentData->toArray();
            $updateStudentEloquent = StudentEloquentModel::findOrFail($studentData->id);
            $updateStudentEloquent->fill($studentDataArray);
            $updateStudentEloquent->save();

            //  delete image if reupload or insert if does not exit
            if (request()->hasFile('image') && request()->file('image')->isValid()) {

                $old_image = $updateStudentEloquent->getFirstMedia('image');
                if ($old_image != null) {
                    $old_image->delete();

                    $updateStudentEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_students');
                } else {

                    $updateStudentEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_students');
                }
            }
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }

        DB::commit();
    }
}
