<?php

namespace Src\BlendedConcept\Organisation\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Organisation\Application\DTO\TeacherData;
use Src\BlendedConcept\Organisation\Application\Mappers\TeacherMapper;
use Src\BlendedConcept\Organisation\Application\Requests\StoreTeacherRequest;
use Src\BlendedConcept\Organisation\Application\Requests\UpdateTeacherRequest;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\Teacher\DeleteTeacherCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\Teacher\StoreTeacherCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\Teacher\UpdateTeacherCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\Student\GetStudentList;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\Teacher\GetTeacherList;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\Teacher\ShowTeacher;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Domain\Policies\B2bTeacherPolicy;
use Symfony\Component\HttpFoundation\Response;

class OrganisationTeacherController
{
    public function index()
    {
        // abort_if(authorize('view', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $filters = request(['search', 'first_name', 'last_name', 'email', 'filter']) ?? [];

            $teachers = (new GetTeacherList($filters))->handle();

            $studentListWithPagniation = (new GetStudentList($filters))->handle();

            // return $teachers;
            return Inertia::render(config('route.organisations-teacher.index'), [
                'teachers' => $teachers,
                'students' => $studentListWithPagniation,
            ]);
        } catch (\Exception $e) {
            return $e;
            dd($e->getMessage());

            return redirect()->route('organisations-teacher.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function create()
    {
        // abort_if(authorize('create', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render(config('route.organisations-teacher.create'));
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

            return redirect()->route('organisations-teacher.index')->with('systemErrorMessage', $e->getMessage());
        }

        /**
         * Returns a redirect response to the announcements index page.
         */
        return redirect()->route('organisations-teacher.index')->with('successMessage', 'Teacher created Successfully!');
    }

    public function show($id)
    {
        // abort_if(authorize('view', B2bTeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teacher = (new ShowTeacher($id))->handle();

        return Inertia::render(config('route.organisations-teacher.show'), [
            'teacher' => $teacher,
        ]);
    }

    public function edit($id)
    {
        // abort_if(authorize('edit', B2bTeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teacher = (new ShowTeacher($id))->handle();

        return Inertia::render(config('route.organisations-teacher.edit'), [
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update an teacher.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTeacherRequest $request, UserEloquentModel $organisations_teacher)
    {
        // abort_if(authorize('edit', B2bTeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Validate the request.
         */
        $request->validated();
        /**
         * Try to update the teacher.
         */
        try {
            $teacherData = TeacherData::fromRequest($request, $organisations_teacher->id);
            $updateTeacherCommand = (new UpdateTeacherCommand($teacherData));
            $updateTeacherCommand->execute();

            return redirect()->route('organisations-teacher.show', $organisations_teacher->id)->with('successMessage', 'Teacher updated Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('organisations-teacher.show', $organisations_teacher->id)->with('SystemErrorMessage', $e->getMessage());
        }
    }

    /**
     * Delete an teacher.
     *
     * @param  UserEloquentModel  $teacher The teacher to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(UserEloquentModel $organisations_teacher)
    {
        // abort_if(authorize('destroy', B2bTeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Try to delete the teacher.
         */
        try {
            $teacherDestroy = new DeleteTeacherCommand($organisations_teacher->id);
            $teacherDestroy->execute();

            return redirect()->route('organisations-teacher.index')->with('successMessage', 'Teacher deleted Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('organisations-teacher.index')->with('systemErrorMessage', $e->getMessage());
        }
    }
}
