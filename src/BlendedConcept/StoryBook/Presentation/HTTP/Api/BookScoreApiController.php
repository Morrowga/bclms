<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP\Api;

use Exception;
use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Application\Requests\ScoreRequest;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\BookScore\BookScoreCommand;


class BookScoreApiController
{
    public function bookScore(ScoreRequest $request){
        try {
            $request->validated();
            $storeBookScore = (new BookScoreCommand($request));
            $storeBookScore->execute();

            return "success";
        } catch (Exception $e) {
            dd($e->getMessage());
            return abort(500);
        }
    }

}
