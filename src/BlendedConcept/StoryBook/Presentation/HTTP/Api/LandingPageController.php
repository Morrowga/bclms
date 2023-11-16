<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP\Api;

use Exception;
use Src\BlendedConcept\StoryBook\Domain\Resources\GameResource;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetGameList;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStoryBook;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;


class LandingPageController
{
    public function index()
    {
        try {
            $storybooks = (new GetStoryBook([]))->handle();
            $games = GameResource::collection(GameEloquentModel::orderBy('id', 'desc')->get());

            // Get the filters from the request, or initialize an empty array if they are not present
            return response()->json([
                'success' => true,
                'data' => [
                    'books' => $storybooks,
                    'games' => $games,
                ]
                ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => true,
                'message' => $e->getMessage()
                ], 500);
        }
    }
}
