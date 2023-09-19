<?php

namespace Src\BlendedConcept\StoryBook\Domain\Repositories;

use Src\BlendedConcept\StoryBook\Application\DTO\GameData;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Game;

interface GameRepositoryInterface
{
    //get game lists
    public function getGameList();
    //create game
    public function createGame(Game $game);
    //update game
    public function updateGame(GameData $game);
}
