<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Exception;
use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;

class RewardsController extends Controller
{
    public function index(){
        try {
            return Inertia::render(config('route.student-rewards'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function store(){
        try {
            return Inertia::render(config('route.reward-store'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function beLucky(){
        try {
            return Inertia::render(config('route.be-lucky'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function buySticker(){
        try {
            return Inertia::render(config('route.buy-sticker'));
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
}
