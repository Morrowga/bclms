<?php

namespace Src\BlendedConcept\Organisation\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Organisation\Domain\Model\Entities\Student;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;

class StudentMapper
{
    public static function fromRequest(Request $request, $student_id = null): Student
    {
        return new Student(
            student_id: $student_id,
            user_id: $request->user_id,
            device_id: $request->device_id,
            first_name: $request->first_name,
            last_name: $request->last_name,
            contact_number: $request->contact_number,
            email: $request->email,
            gender: $request->gender,
            dob: $request->dob,
            education_level: $request->education_level,
            num_gold_coins: $request->num_gold_coins,
            num_silver_coins: $request->num_silver_coins,
            student_code: $request->student_code,
            total_time_spent: $request->total_time_spent,
            disability_types: $request->disability_types,
            learning_needs: $request->learning_needs,
            parent_first_name: $request->parent_first_name,
            parent_last_name: $request->parent_last_name
        );
    }

    public static function toEloquent(Student $student): StudentEloquentModel
    {
        $StudentEloquent = new StudentEloquentModel();

        if ($student->student_id) {
            $StudentEloquent = StudentEloquentModel::query()->findOrFail($student->student_id);
        }
        $StudentEloquent->device_id = $student->device_id;
        $StudentEloquent->gender = $student->gender;
        $StudentEloquent->dob = $student->dob;
        $StudentEloquent->education_level = $student->education_level;

        return $StudentEloquent;
    }
}
