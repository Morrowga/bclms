<?php

namespace Src\BlendedConcept\StoryBook\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\RewardRepository;
use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\PathwayRepository;
use Src\BlendedConcept\StoryBook\Domain\Repositories\PathwayRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\StoryBookRepository;

class StoryBookServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            RewaredRepositoryInterface::class,
            RewardRepository::class
        );
        $this->app->bind(
            StoryBookRepositoryInterface::class,
            StoryBookRepository::class
        );

        $this->app->bind(
            PathwayRepositoryInterface::class,
            PathwayRepository::class
        );
    }
}
