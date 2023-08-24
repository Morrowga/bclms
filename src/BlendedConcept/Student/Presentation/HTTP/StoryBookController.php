<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Exception;
use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;

class StoryBookController extends Controller
{
    public function index(){
        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            return Inertia::render(config('route.storybooks'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function show(){
        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            return Inertia::render(config('route.storybook-show'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
}
