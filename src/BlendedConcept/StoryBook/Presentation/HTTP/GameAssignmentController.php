<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetGameList;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\AssignGameCommand;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\Student\GetStudentList;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\Devices\GetDevicesWithoutPagination;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\DisabilityTypes\ShowDisabilityTypes;
use Src\BlendedConcept\StoryBook\Domain\Policies\GamePolicy;

class GameAssignmentController
{
    public function index()
    {
        abort_if(authorize('assign', GamePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filters = request()->only(['search', 'name', 'perPage', 'filter']) ?? [];
        $games = (new GetGameList($filters))->handle();
        // return $games;
        return Inertia::render(config('route.assign_games.index'), [
            "games" => $games
        ]);
    }

    public function show(GameEloquentModel $game)
    {
        abort_if(authorize('assign_show', GamePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $game->load(['disabilityTypes', 'devices', 'gameAssignments']);
        $filters = request(['search', 'first_name', 'last_name']) ?? [];
        $students = (new GetStudentList($filters))->handle();

        return Inertia::render(config('route.assign_games.show'), [
            "game" => $game,
            "students" => $students
        ]);
    }

    public function gameAssign()
    {
        try {
            $assignGameCommand = (new AssignGameCommand())->execute();

            return redirect()->back()->with('successMessage', 'Assigned Game successfully!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('errorMessage', $exception->getMessage());
        }
    }
}
