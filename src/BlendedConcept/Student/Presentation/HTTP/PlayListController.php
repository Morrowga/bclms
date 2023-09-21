<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStoryBook;
use Src\BlendedConcept\Student\Application\UseCases\Queries\GetStudentWithPagination;

class PlayListController
{
    public function index()
    {
        return Inertia::render(config('route.playlist.index'));
    }

    public function create()
    {
        $filters = request()->only(['name', 'search', 'perPage']) ?? [];

        $students = (new GetStudentWithPagination($filters))->handle()['paginate_students'];
        $storybooks = (new GetStoryBook($filters))->handle();

        return Inertia::render(config('route.playlist.create'),[
            "students" => $students,
            "storybooks" => $storybooks
        ]);
    }

    public function edit()
    {
        return Inertia::render(config('route.playlist.edit'));
    }

    public function show()
    {
        return Inertia::render(config('route.playlist.show'));
    }
}
