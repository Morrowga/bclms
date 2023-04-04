<?php

namespace Src\BlendedConcept\User\Application\Repositories\Eloquent;

use Src\BlendedConcept\User\Domain\Model\Student;
use Src\BlendedConcept\User\Domain\Repositories\StudentRepositoryInterface;
use Carbon\Carbon;
class StudentRepository implements StudentRepositoryInterface
{

    public function createStudent($request)
    {

         $student =  Student::create([
            "name" => $request->name,
            "nickname" => $request->nickname,
             "dob" => $request->dob,
             "grade" => $request->grade
         ]);

         if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $student->addMediaFromRequest('image')->toMediaCollection('image', 'media_student');
        }
    }

    public function updateStudent($request, $student)
    {
        $student->update($request->all());
        //  delete image if reupload or insert if does not exit
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $old_image = $student->getFirstMedia('image');
            if ($old_image != null) {
                $old_image->delete();

                $student->addMediaFromRequest('image')->toMediaCollection('image', 'media_student');
            } else {
                $student->addMediaFromRequest('image')->toMediaCollection('image', 'media_student');
            }
        }
    }
}
