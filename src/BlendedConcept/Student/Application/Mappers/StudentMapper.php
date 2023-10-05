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
            student_id: $student_id,
            first_name: $request->first_name,
            last_name: $request->last_name,
            user_id: $request->user_id,
            device_id: $request->device_id,
            gender: $request->gender,
            dob: $request->dob,
            education_level: $request->education_level,
            num_gold_coins: $request->num_gold_coins,
            num_silver_coins: $request->num_silver_coins,
            student_code: $request->student_code,
            contact_number: $request->contact_number,
            total_time_spent: $request->total_time_spent,
            parent_first_name: $request->parent_first_name,
            parent_last_name: $request->parent_last_name,
            email: $request->email
        );
    }

    public static function toEloquent(Student $student): StudentEloquentModel
    {
        $StudentEloquent = new StudentEloquentModel();

        if ($student->student_id) {
            $StudentEloquent = StudentEloquentModel::query()->findOrFail($student->student_id);
        }

        //set organisation_id according to auth's organisation_id
        $StudentEloquent->user_id = auth()->user()->user_id;
        $StudentEloquent->device_id = $student->device_id;
        $StudentEloquent->gender = $student->gender;
        $StudentEloquent->dob = $student->dob;
        $StudentEloquent->education_level = $student->education_level;
        $StudentEloquent->num_gold_coins = $student->num_gold_coins;
        $StudentEloquent->num_silver_coins = $student->num_silver_coins;
        $StudentEloquent->student_code = $student->student_code;
        $StudentEloquent->total_time_spent = $student->total_time_spent;

        return $StudentEloquent;
    }
}
