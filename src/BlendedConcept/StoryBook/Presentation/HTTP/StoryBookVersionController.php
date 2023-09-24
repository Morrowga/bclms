<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\Mappers\StoryBookVersionMapper;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\StoryBookVersion\CreateStoryBookVersionCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\StoryBookVersion\CreateStoryBookAssigmentCommand;
use Src\BlendedConcept\StoryBook\Application\Requests\StoreStoryBookVersion;
use Src\BlendedConcept\StoryBook\Application\Requests\StoreStoryBookAssignmentRequest;
use Src\BlendedConcept\StoryBook\Application\Requests\StoreStoryBookReview;
use Src\BlendedConcept\StoryBook\Application\Mappers\ReviewMapper;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\BookReview\GiveBookReviewCommand;

class StoryBookVersionController
{

    /**
     * Store a new storybook based on the provided request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreStoryBookVersion $request)
    {
        try {
            // Map the reward data from the request
            $newStoryBookVersion = StoryBookVersionMapper::fromRequest($request);

            // Create a new reward using a command
            $createNewReward = new CreateStoryBookVersionCommand($newStoryBookVersion);
            $createNewReward->execute();

            // Redirect to the index page with a success message
            return redirect()->back()->with('successMessage', 'StoryBook Version created successfully!');
        } catch (\Exception $exception) {
            // Handle any exceptions and display the error message
            dd($exception->getMessage());
        }
    }

    public function storybookassignment(StoreStoryBookAssignmentRequest $request)
    {
        try {
            $createNewStoryBook = (new CreateStoryBookAssigmentCommand())->execute();
            return redirect()->back()->with('successMessage', 'StoryBook Version created successfully!');
        } catch (\Exception $error) {
            dd($error->getCode());
        }
    }

    public function bookreview(StoreStoryBookReview $request)
    {

        try {
            $newReview = ReviewMapper::fromRequest($request);
            $createReview = (new GiveBookReviewCommand($newReview))->execute();
            return redirect()->back()->with('successMessage', 'StoryBook Version created successfully!');
        } catch (\Exception $th) {
            dd($th->getMessage());
        }
    }
}
