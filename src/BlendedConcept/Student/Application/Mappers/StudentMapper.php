<?php

namespace Src\BlendedConcept\Student\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Student\Domain\Model\Student;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class StudentMapper
{
    public static function fromRequest(Request $request, $student_id = null): Student
    {
        return new Student(
            id: $student_id,
            organization_id: $request->organization_id,
            device_id: $request->device_id,
            student_code: $request->student_code,
            name: $request->name,
            nickname: $request->nickname,
            description: $request->description,
            dob: $request->dob,
            grade: $request->grade,
            star_earn: $request->star_earn,
            coin_earn: $request->coin_earn,
        );
    }


    public static function toEloquent(Student $student): StudentEloquentModel
    {
        $StudentEloquent = new StudentEloquentModel();

        if ($student->id) {
            $StudentEloquent = StudentEloquentModel::query()->findOrFail($student->id);
        }

        //set organization_id according to auth's organization_id
        $StudentEloquent->organization_id = auth()->user()->organization_id;
        $StudentEloquent->device_id = $student->device_id;
        $StudentEloquent->student_code = $student->student_code;
        $StudentEloquent->name = $student->name;
        $StudentEloquent->nickname = $student->nickname;
        $StudentEloquent->description = $student->description;
        $StudentEloquent->dob = $student->dob;
        $StudentEloquent->grade = $student->grade;
        $StudentEloquent->star_earn = $student->star_earn;
        $StudentEloquent->coin_earn = $student->coin_earn;

        return $StudentEloquent;
    }
}
