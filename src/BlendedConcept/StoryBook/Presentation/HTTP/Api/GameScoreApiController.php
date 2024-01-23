<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP\Api;

use Exception;
use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Application\Requests\ScoreRequest;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\GameScore\GameScoreCommand;


class GameScoreApiController
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

    public function gameScore(ScoreRequest $request){
        try {
            $request->validated();
            $storeGameScore = (new GameScoreCommand($request));
            $storeGameScore->execute();

            return "success";
        } catch (Exception $e) {
            dd($e->getMessage());
            return abort(500);
        }
    }

}
