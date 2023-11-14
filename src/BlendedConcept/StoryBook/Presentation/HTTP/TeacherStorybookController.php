<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\Student\GetStudentList;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetGameList;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStoryBook;
use Src\BlendedConcept\StoryBook\Domain\Policies\TeacherBookPolicy;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class TeacherStorybookController
{
    public function index()
    {
        abort_if(authorize('view', TeacherBookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $filters = request()->only(['search', 'name', 'perPage', 'filter']) ?? [];
        $storyBooks = (new GetStoryBook($filters))->handle();

        return Inertia::render(config('route.teacher_storybook.index'), compact('storyBooks'));
    }

    public function edit()
    {
        abort_if(authorize('edit', TeacherBookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Inertia::render(config('route.teacher_storybook.edit'));
    }

    public function show(StoryBookEloquentModel $teacher_storybook)
    {
        abort_if(authorize('show', TeacherBookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $auth = auth()->user()->role->name;
        if ($auth == 'B2B Parent') {
            $parent = auth()->user()->parents;
            $student = StudentEloquentModel::where('parent_id', $parent->parent_id)->first();
            if ($parent->organisation_id) {
                $user = $student->classrooms()->with('teachers')->get()->pluck('teachers')->flatten();
                $user_id = $user->map(function ($user) {
                    return $user->teacher_id;
                });
            } else {
                $user_id = $student->teachers()->pluck('teachers.teacher_id');
            }
            $teacher_storybook->load(['devices', 'learningneeds', 'themes', 'disability_types', 'storybook_versions' => function ($query) use ($user_id) {
                $query->whereIn('teacher_id', $user_id)->orWhere(function ($query) {
                    $query->where('teacher_id', null)->where('parent_id', null);
                });
            }]);
        } elseif ($auth == 'BC Subscriber') {
            if(auth()->user()->b2bUser == null){
                $parent = auth()->user()->parents;

                $user_id = $parent->parent_id;
                $teacher_storybook->load(['devices', 'learningneeds', 'themes', 'disability_types', 'storybook_versions' => function ($query) use ($user_id) {
                    $query->where('parent_id', $user_id)->orWhere(function ($query) {
                        $query->where('teacher_id', null)->where('parent_id', null);
                    });;
                }]);
            } else {
                $teacher = auth()->user()->b2bUser;

                $user_id = $teacher->teacher_id;

                $teacher_storybook->load(['devices', 'learningneeds', 'themes', 'disability_types', 'storybook_versions' => function ($query) use ($user_id) {
                    $query->where('teacher_id', $user_id)->orWhere(function ($query) {
                        $query->where('teacher_id', null)->where('parent_id', null);
                    });;
                }]);
            }
        } else {
            $user_id = [auth()->user()->b2bUser->teacher_id];
            $teacher_storybook->load(['devices', 'learningneeds', 'themes', 'disability_types', 'storybook_versions' => function ($query) use ($user_id) {
                $query->where('teacher_id', $user_id)->orWhere(function ($query) {
                    $query->where('teacher_id', null)->where('parent_id', null);
                });;
            }]);
        }
        // elseif ($auth == 'Both Parent') {
        //     $parent = auth()->user()->parents;
        //     $student = StudentEloquentModel::with('teachers')->where('parent_id', $parent->parent_id)->first();

        //     if ($parent->organisation_id) {
        //         $teacher = $student->classrooms()->with('teachers')->get()->pluck('teachers')->flatten();
        //         $teacher_id = $teacher->map(function ($teacher) {
        //             return $teacher->teacher_id;
        //         });
        //     } else {
        //         $teacher_id = $student->teachers()->pluck('teachers.teacher_id');
        //     }
        //     $user_id = $parent->parent_id;
        //     $teacher_storybook->load(['devices', 'learningneeds', 'themes', 'disability_types', 'storybook_versions' => function ($query) use ($user_id, $teacher_id) {
        //         $query->where('parent_id', $user_id)->orWhereIn('teacher_id', $teacher_id);
        //     }]);
        // }
        $filters = request(['search', 'filter', 'perPage', 'page']);

        $games = (new GetGameList($filters))->handle();

        $storybooks = (new GetStoryBook($filters = []))->handle();

        return Inertia::render(config('route.teacher_storybook.show'), compact('teacher_storybook', 'games', 'storybooks'));
    }

    public function assign_student(StoryBookEloquentModel $teacher_storybook, StoryBookVersionEloquentModel $version)
    {
        abort_if(authorize('assign', TeacherBookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $filters = request(['search', 'first_name', 'last_name']) ?? [];
        $students = (new GetStudentList($filters))->handle();
        $teacher_storybook->load(['learningneeds', 'themes', 'disability_types', 'devices']);
        $version = $version->load('storybook_assigments');
        // dd($students);
        return Inertia::render(config('route.teacher_storybook.assign_student'), compact('teacher_storybook', 'version', 'students'));
    }
}
