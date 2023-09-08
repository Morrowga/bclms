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
            name : $this->name,
            description : $this->description,
            game_file : $this->game_file,
            thumbnail : $this->thumbnail,
            num_gold_coins : $this->num_gold_coins,
            num_silver_coins : $this->num_silver_coins,
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
