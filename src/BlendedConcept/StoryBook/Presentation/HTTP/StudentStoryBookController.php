<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Exception;
use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\Student\Application\UseCases\Queries\GetStudentPathway;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStudentStorybooks;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;

class StudentStoryBookController extends Controller
{
    public function index()
    {
        try {
            $filters = request()->only(['search', 'name', 'perPage']) ?? [];
            $books = (new GetStudentStorybooks($filters))->handle();

            // Get the filters from the request, or initialize an empty array if they are not present
            return Inertia::render(config('route.storybooks'), [
                'books' => $books
            ]);
        } catch (Exception $e) {
            dd($e);
            return redirect()->route($this->route_url . 'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function show(StoryBookEloquentModel $book)
    {
        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            return Inertia::render(config('route.storybook-show'), [
                'book' => $book
            ]);
        } catch (Exception $e) {
            return redirect()->route($this->route_url . 'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function showVersion(StoryBookVersionEloquentModel $book_version)
    {
        try {
            // Get the filters from the request, or initialize an empty array if they are not present
            return Inertia::render(config('route.storybook-version'), [
                'book' => $book_version
            ]);
        } catch (Exception $e) {
            return redirect()->route($this->route_url . 'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function pathway()
    {
        // $pathways = (new GetStudentPathway())->handle();

        // return  $pathways;
        try {
            // Get the filters from the request, or initialize an empty array if they are not present
            return Inertia::render(config('route.storybook-pathway'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url . 'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function getStudentPathways()
    {
        $pathways = (new GetStudentPathway())->handle();

        return response()->json($pathways);
    }
}
