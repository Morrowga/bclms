<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Exception;
use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;

class GamesController extends Controller
{
    public function index(){
        try {
            return Inertia::render(config('route.student-games'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function show(){
        try {
            return Inertia::render(config('route.game-show'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
}
