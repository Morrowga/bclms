<?php

namespace Src\BlendedConcept\StoryBook\Domain\Repositories;

use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookVersionData;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Review;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\StoryBookVersion;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;

interface StoryBookVersionRepositoryInterface
{
    public function getStoryBooksWithVersions();

    public function createStoryBookVersion(StoryBookVersion $storyBookVersion);

    public function updateStoryBookVersion(StoryBookVersionData $storyBookVersionData);

    public function deleteStoryBookVersion(StoryBookVersionEloquentModel $storybook_version);

    public function assigmentAssigment();

    public function bookreview(Review $review);
}
