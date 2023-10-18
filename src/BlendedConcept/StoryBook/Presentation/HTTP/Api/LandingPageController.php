<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP\Api;

use Exception;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetGameList;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStoryBook;


class LandingPageController
{
    public function index()
    {
        try {
            $storybooks = (new GetStoryBook([]))->handle();
            $games = (new GetGameList([]))->handle();

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
