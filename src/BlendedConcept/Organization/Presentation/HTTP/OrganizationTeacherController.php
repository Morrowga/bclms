<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Organization\Application\Mappers\TeacherMapper;
use Src\BlendedConcept\Organization\Application\Requests\StoreTeacherRequest;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\Teacher\ShowTeacher;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\Teacher\GetTeacherList;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\Teacher\StoreTeacherCommand;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\Teacher\DeleteTeacherCommand;

class OrganizationTeacherController
{
    public function index()
    {
        $teachers = (new GetTeacherList())->handle();
        // return $teachers;
        return Inertia::render(config('route.organizations-teacher.index'), [
            'teachers' => $teachers,
        ]);
    }

    public function create()
    {
        return Inertia::render(config('route.organizations-teacher.create'));
    }

     /**
     * This function stores a new teacher.
     *
     * @param  StoreTeacherRequest  $request The request object
     * @return \Illuminate\Http\RedirectResponse The redirect response
     */
    public function store(StoreTeacherRequest $request)
    {

        try {
            $request->validated();
            //Creates a new teacher object from the request data.
            $newTeacher = TeacherMapper::fromRequest($request);

            // Creates a new StoreTeacherCommand object and executes it.
            $storeTeacherCommand = new StoreTeacherCommand($newTeacher);
            $storeTeacherCommand->execute();
        } catch (\Exception $e) {

            // Handle the exception here
            dd($e->getMessage());

            return redirect()->route('organizations-teacher.index')->with('systemErrorMessage', $e->getMessage());
        }

        /**
         * Returns a redirect response to the announcements index page.
         */
        return redirect()->route('organizations-teacher.index')->with('successMessage', 'Announcement created Successfully!');
    }

    public function show($id)
    {
        $teacher = (new ShowTeacher($id))->handle();
        return Inertia::render(config('route.organizations-teacher.show'),[
            'teacher' => $teacher
        ]);
    }

    public function edit($id)
    {
        $teacher = (new ShowTeacher($id))->handle();

        return Inertia::render(config('route.organizations-teacher.edit'),[
            'teacher' => $teacher
        ]);
    }

     /**
     * Delete an teacher.
     *
     * @param  UserEloquentModel  $teacher The teacher to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(UserEloquentModel $teacher)
    {
        // abort_if(authorize('destroy', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Try to delete the teacher.
         */
        try {

            $teacher = new DeleteTeacherCommand($teacher->id);
            $teacher->execute();

            return redirect()->route('organizations-teacher.index')->with('successMessage', 'Teacher deleted Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('organizations-teacher.index')->with('systemErrorMessage', $e->getMessage());
        }
    }
}

