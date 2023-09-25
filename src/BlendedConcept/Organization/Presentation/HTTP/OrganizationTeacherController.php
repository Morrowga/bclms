<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;
use Src\BlendedConcept\Teacher\Domain\Policies\TeacherPolicy;
use Src\BlendedConcept\Organization\Application\DTO\TeacherData;
use Src\BlendedConcept\Organization\Application\Mappers\TeacherMapper;
use Src\BlendedConcept\Organization\Application\Requests\StoreTeacherRequest;
use Src\BlendedConcept\Organization\Application\Requests\UpdateTeacherRequest;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\Teacher\ShowTeacher;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\Student\GetStudentList;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\Teacher\GetTeacherList;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\Teacher\StoreTeacherCommand;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\Teacher\DeleteTeacherCommand;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\Teacher\UpdateTeacherCommand;

class OrganizationTeacherController
{
    public function index()
    {
        // abort_if(authorize('view', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $filters = request(['search', 'first_name', 'last_name', 'email', 'filter']) ?? [];

            $teachers = (new GetTeacherList($filters))->handle();

            $studentListWithPagniation = (new GetStudentList($filters))->handle();

            // return $teachers;
            return Inertia::render(config('route.organizations-teacher.index'), [
                'teachers' => $teachers,
                'students' => $studentListWithPagniation,
            ]);
        } catch (\Exception $e) {
            return $e;
            dd($e->getMessage());

            return redirect()->route('organizations-teacher.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function create()
    {
        // abort_if(authorize('create', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        // abort_if(authorize('create', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        return redirect()->route('organizations-teacher.index')->with('successMessage', 'Teacher created Successfully!');
    }

    public function show($id)
    {
        $teacher = (new ShowTeacher($id))->handle();
        return Inertia::render(config('route.organizations-teacher.show'), [
            'teacher' => $teacher
        ]);
    }

    public function edit($id)
    {
        $teacher = (new ShowTeacher($id))->handle();

        return Inertia::render(config('route.organizations-teacher.edit'), [
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update an teacher.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTeacherRequest $request, UserEloquentModel $organization_teacher)
    {
        // abort_if(authorize('edit', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Validate the request.
         */
        $request->validated();
        /**
         * Try to update the teacher.
         */
        try {
            $teacherData = TeacherData::fromRequest($request, $organization_teacher->id);
            $updateTeacherCommand = (new UpdateTeacherCommand($teacherData));
            $updateTeacherCommand->execute();

            return redirect()->route('organizations-teacher.show', $teacherEloquent->id)->with('successMessage', 'Teacher updated Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('organizations-teacher.show', $teacherEloquent->id)->with('SystemErrorMessage', $e->getMessage());
        }
    }

    /**
     * Delete an teacher.
     *
     * @param  UserEloquentModel  $teacher The teacher to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(UserEloquentModel $organization_teacher)
    {
        // abort_if(authorize('destroy', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Try to delete the teacher.
         */
        try {
            $teacherDestroy = new DeleteTeacherCommand($organization_teacher->id);
            $teacherDestroy->execute();

            return redirect()->route('organizations-teacher.index')->with('successMessage', 'Teacher deleted Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('organizations-teacher.index')->with('systemErrorMessage', $e->getMessage());
        }
    }
}
