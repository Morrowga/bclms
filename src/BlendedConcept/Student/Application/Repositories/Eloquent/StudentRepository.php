<?php

namespace Src\BlendedConcept\Student\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
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
     *  if organisation exits
     */
    public function getStudent($filters)
    {
        // dd($filters);
        $paginate_students = StudentResources::collection(
            StudentEloquentModel::with('user', 'organisation', 'disability_types', 'parent')
                ->filter($filters)
                ->orderBy('student_id', 'desc')
                // ->where('organisation_id', auth()->user()->organisation_id)
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

    public function getStudentsByPagination($filters)
    {
        return StudentEloquentModel::filter($filters)->with('user', 'disability_types')->paginate($filters['perPage'] ?? 10);
    }

    public function showStudent($id)
    {

        $student = new StudentResources(StudentEloquentModel::where('student_id', $id)
            ->with(['user', 'learningneeds', 'disability_types', 'playlists.storybooks'])
            ->orderBy('student_id', 'desc')
            ->first());

        return $student;
    }

    public function getStudentsByOrgTeacher($filters)
    {
        $teachers = UserEloquentModel::with('classrooms')->find(auth()->user()->id);
        $classroom_ids = [];
        foreach ($teachers->classrooms as $classroom) {
            array_push($classroom_ids, $classroom->id);
        }

        return StudentEloquentModel::filter($filters)
            ->whereHas('organisations', function ($query) {
                $query->where('id', auth()->user()->organisation_id);
            })
            ->whereHas('classrooms', function ($query) use ($classroom_ids) {
                $query->whereIn('id', $classroom_ids);
            })

            ->with('user', 'disability_types')->paginate($filters['perPage'] ?? 10);
    }
}
