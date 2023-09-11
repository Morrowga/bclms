<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Exception;
use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;

class StudentStoryBookController extends Controller
{
    public function index()
    {
        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            return Inertia::render(config('route.storybooks'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function show()
    {
        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            return Inertia::render(config('route.storybook-show'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function pathway()
    {
        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            return Inertia::render(config('route.storybook-pathway'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
}
