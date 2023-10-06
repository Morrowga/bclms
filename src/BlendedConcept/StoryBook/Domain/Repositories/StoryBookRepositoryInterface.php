<?php

namespace Src\BlendedConcept\StoryBook\Domain\Repositories;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookData;
use Src\BlendedConcept\StoryBook\Domain\Model\StoryBook;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

interface StoryBookRepositoryInterface
{
    //get all storybooks
    public function getStoryBooks($filters);

    //create storybooks
    public function createStoryBook(StoryBook $storyBook);

    //update storybooks
    public function updateStoryBook(StoryBookData $storyBookData);

    public function deleteStoryBook(int $storybook_id);

    public function getLearningNeed();

    public function getdisabilitytype();

    public function getthemes();

    public function getdevice();

    public function getStoryBooksForSelect();

    public function getStudentStorybooks();

    public function updatePhysicalResource(Request $request, StoryBookEloquentModel $storyBook);
}
