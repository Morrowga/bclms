<?php

namespace Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\StoryBook\Application\Mappers\GameMapper;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Game;
use Src\BlendedConcept\StoryBook\Domain\Repositories\GameRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Resources\GameResource;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;

class GameRepository implements GameRepositoryInterface
{
    //get all games
    public function getGameList()
    {
        $games = GameResource::collection(GameEloquentModel::with(['tags', 'disabilityTypes'])->orderBy('id', 'desc')->get());

        return $games;
    }

    /**
     * Create a new game with the provided game object.
     *
     * @param  Game  $game The organization object containing the necessary information.
     * @return void
     */
    public function createGame(Game $game)
    {
        DB::beginTransaction();
        try {
            // Insert data into the game
            $gameEloquent = GameMapper::toEloquent($game);
            $gameEloquent->save();
            // Upload the game's image if provided
            if (request()->hasFile('thumb') && request()->file('thumb')->isValid()) {
                $gameEloquent->addMediaFromRequest('thumb')->toMediaCollection('thumbnail', 'media_game_thumbnail');
            }
            if ($gameEloquent->getMedia('thumbnail')->isNotEmpty()) {
                $gameEloquent->thumbnail = $gameEloquent->getMedia('thumbnail')[0]->original_url;
                $gameEloquent->update();
            }

            // Upload the game file if provided
            if (request()->hasFile('game') && request()->file('game')->isValid()) {
                dd('game');
                $gameEloquent->addMediaFromRequest('game')->toMediaCollection('gameFile', 'media_game_file');
            }
            if ($gameEloquent->getMedia('gameFile')->isNotEmpty()) {
                $gameEloquent->game_file = $gameEloquent->getMedia('gameFile')[0]->original_url;
                $gameEloquent->update();
            }

            $gameEloquent->associateTags(request()->tags);

            // Associate disability types with the game
            $disabilityTypeId = $game->disability_type_id;
            $gameEloquent->disabilityTypes()->attach($disabilityTypeId);
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }
    }
}
