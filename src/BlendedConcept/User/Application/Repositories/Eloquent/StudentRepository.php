<?php

namespace Src\BlendedConcept\User\Application\Repositories\Eloquent;

use Src\BlendedConcept\User\Domain\Model\Student;
use Src\BlendedConcept\User\Domain\Repositories\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{


    public function createStudent($request)
    {
        $request->validated();
         $student =  Student::create([
            "name" => $request->name,
            "nickname" => $request->nickname,
             "dob" => null,
             "grade" => $request->grade
         ]);


         if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $student->addMediaFromRequest('image')->toMediaCollection('image', 'media_student');
        }

    }


}
