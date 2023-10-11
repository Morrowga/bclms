<?php

namespace Src\BlendedConcept\StoryBook\Domain\Repositories;

use Src\BlendedConcept\StoryBook\Application\DTO\GameData;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Game;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;

interface GameRepositoryInterface
{
    //get game lists
    public function getGameList($filters);

    //create game
    public function createGame(Game $game);

    //update game
    public function updateGame(GameData $game);

    //delete game
    public function deleteGame(GameEloquentModel $game);
}
