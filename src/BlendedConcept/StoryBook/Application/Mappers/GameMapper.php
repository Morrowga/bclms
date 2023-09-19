<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Game;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;

class GameMapper
{
    public static function fromRequest(Request $request, $game_id = null): Game
    {
        return new Game(
            id : $game_id,
            name : $request->name,
            description : $request->description,
            game_file : $request->game_file,
            thumbnail : $request->thumbnail,
            num_gold_coins : $request->num_gold_coins,
            num_silver_coins : $request->num_silver_coins,
            disability_type_id : $request->disability_type_id,
        );
    }

    public static function toEloquent(Game $game): GameEloquentModel
    {
        $gameEloquent = new GameEloquentModel();

        if ($game->id) {
            $gameEloquent = GameEloquentModel::query()->findOrFail($game->id);
        }
        $gameEloquent->id = $game->id;
        $gameEloquent->name = $game->name;
        $gameEloquent->description = $game->description;
        $gameEloquent->game_file = $game->game_file;
        $gameEloquent->thumbnail = $game->thumbnail;
        $gameEloquent->num_gold_coins = $game->num_gold_coins;
        $gameEloquent->num_silver_coins = $game->num_silver_coins;

        return $gameEloquent;
    }
}
