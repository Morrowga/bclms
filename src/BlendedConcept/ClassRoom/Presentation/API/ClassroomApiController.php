<?php

namespace Src\BlendedConcept\ClassRoom\Presentation\API;

use Src\BlendedConcept\ClassRoom\Application\UseCases\Queries\GetStudentsWithPagination;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Queries\GetTeachersWithPagination;
use Src\Common\Infrastructure\Laravel\Controller;

class ClassroomApiController extends Controller
{
    /***
     *  @params null
     *
     *  @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     *
     */
    public function getStudents()
    {

        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'search', 'perPage']) ?? [];

            // Retrieve users with pagination using the provided filters
            $students = (new GetStudentsWithPagination($filters))->handle();

            // $teachers = (new GetTeachers)->handle();
            // $students = (new GetStudents)->handle();

            return response()->json([
                'data' => $students,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'data' => $e,
            ]);
        }
    }

    public function getTeachers()
    {

        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'search', 'perPage']) ?? [];

            // Retrieve users with pagination using the provided filters
            $teachers = (new GetTeachersWithPagination($filters))->handle();

            // $teachers = (new GetTeachers)->handle();
            // $students = (new GetStudents)->handle();

            return response()->json([
                'data' => $teachers,
            ]);
        } catch (\Exception $e) {
            return $e;

            return response()->json([
                'data' => $e,
            ]);
        }
    }
}
