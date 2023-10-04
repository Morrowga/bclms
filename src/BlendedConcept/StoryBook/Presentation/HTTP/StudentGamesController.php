<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Exception;
use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetGameList;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;

class StudentGamesController extends Controller
{
    public function index()
    {
        try {
            $filters = request()->only(['search', 'name', 'perPage']) ?? [];
            $games = (new GetGameList($filters))->handle();
            return Inertia::render(config('route.student-games'), [
                'games' => $games,
            ]);
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function show(GameEloquentModel $game)
    {
        try {
            return Inertia::render(config('route.game-show'), [
                'game' => $game
            ]);
        } catch (Exception $e) {
            return redirect()->route($this->route_url.'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
}
