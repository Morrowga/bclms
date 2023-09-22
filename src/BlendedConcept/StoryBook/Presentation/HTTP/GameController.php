<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\DisabilityTypes\ShowDisabilityTypes;
use Src\BlendedConcept\StoryBook\Application\DTO\GameData;
use Src\BlendedConcept\StoryBook\Application\Mappers\GameMapper;
use Src\BlendedConcept\StoryBook\Application\Requests\StoreGameRequest;
use Src\BlendedConcept\StoryBook\Application\Requests\UpdateGameRequest;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\StoreGameCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\UpdateGameCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetGameList;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;

class GameController
{
    public function index()
    {
        try {
            $disabilityTypes = (new ShowDisabilityTypes())->handle();
            $games = (new GetGameList())->handle();

            return Inertia::render(config('route.games.index'), [
                'disabilityTypes' => $disabilityTypes,
                'games' => $games,
            ]);

        } catch (\Exception $e) {

            dd($e->getMessage());

            return redirect()->route('games.index')->with('sytemErrorMessage', $e->getMessage());
        }

    }

    /**
     * This function stores a new game.
     *
     * @param  StoreGameRequest  $request The request object
     * @return \Illuminate\Http\RedirectResponse The redirect response
     */
    public function store(StoreGameRequest $request)
    {
        try {
            // Abort if the user is not authorized to create games
            // abort_if(authorize('create', GamePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data
            $request->validated();

            $newGame = GameMapper::fromRequest($request);
            $storeGameCommand = (new StoreGameCommand($newGame));
            $storeGameCommand->execute();

            return redirect()->route('games.index')->with('successMessage', 'Game Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('games.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    /**
     * Update an game.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateGameRequest $request, GameEloquentModel $game)
    {
        // abort_if(authorize('edit', GamePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Validate the request.
         */
        $request->validated();

        /**
         * Try to update the game.
         */
        try {

            $gameData = GameData::fromRequest($request, $game->id);
            $updateGameCommand = (new UpdateGameCommand($gameData));
            $updateGameCommand->execute();

            return redirect()->route('games.index')->with('successMessage', 'Game updated Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('games.index')->with('SystemErrorMessage', $e->getMessage());
        }
    }
}
