<?php

namespace Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent;

use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\ThemeEloquentModel;
use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookData;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;

class StoryBookRepository implements StoryBookRepositoryInterface
{
    public function getStoryBooks($filters)
    {
    }

    //create storybooks
    public function createStoryBook($request)
    {
    }

    //update storybooks
    public function updateStoryBook(StoryBookData $storyBookData)
    {
    }

    public function deleteStoryBook(int $storybook_id)
    {
    }

    public function getLearningNeed()
    {
        $learningneeds = SubLearningTypeEloquentModel::get();
        return $learningneeds;
    }

    public function getthemes()
    {
        $themes = ThemeEloquentModel::get();

        return $themes;
    }

    public function getdisabilitytype()
    {
        $disability = DisabilityTypeEloquentModel::get();

        return $disability;
    }

    public function getdevice()
    {

        $devices = DeviceEloquentModel::get();

        return $devices;
    }
}
