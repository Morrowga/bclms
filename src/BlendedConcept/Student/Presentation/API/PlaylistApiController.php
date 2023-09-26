<?php

namespace Src\BlendedConcept\Student\Presentation\API;

use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStoryBook;
use Src\BlendedConcept\Student\Application\UseCases\Queries\Playlist\GetStudentsForPlaylist;
use Src\Common\Infrastructure\Laravel\Controller;

class PlaylistApiController extends Controller
{
    /***
     *  @params null
     *
     *  @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     *
     */
    public function getStudents()
    {

        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'search', 'perPage']) ?? [];

            // Retrieve users with pagination using the provided filters
            $students = (new GetStudentsForPlaylist($filters))->handle();

            return response()->json([
                'data' => $students,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'data' => $e,
            ]);
        }
    }

    public function getStorybooks()
    {

        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'search', 'perPage']) ?? [];

            // Retrieve users with pagination using the provided filters
            $storybooks = (new GetStoryBook($filters))->handle();

            return response()->json([
                'data' => $storybooks,
            ]);
        } catch (\Exception $e) {
            return $e;

            return response()->json([
                'data' => $e,
            ]);
        }
    }
}
