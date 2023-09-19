<?php

namespace Src\BlendedConcept\StoryBook\Domain\Repositories;

use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookData;

interface StoryBookRepositoryInterface
{
    //get all storybooks
    public function getStoryBooks($filters);

    //create storybooks
    public function createStoryBook($request);

    //update storybooks
    public function updateStoryBook(StoryBookData $storyBookData);

    public function deleteStoryBook(int $storybook_id);

    public function getLearningNeed();

    public function getthemes();

    public function getdisabilitytype();

    public function getdevice();
}