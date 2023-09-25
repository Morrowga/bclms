<?php

namespace Src\BlendedConcept\StoryBook\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\GameRepository;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\PathwayRepository;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\RewardRepository;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\StoryBookRepository;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\StoryBookVersionRepository;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\BookReviewRepository;
use Src\BlendedConcept\StoryBook\Domain\Repositories\GameRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\PathwayRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookVersionRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\BookReviewRepositoryInterface;

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
        $this->app->bind(
            GameRepositoryInterface::class,
            GameRepository::class
        );
        $this->app->bind(
            StoryBookVersionRepositoryInterface::class,
            StoryBookVersionRepository::class
        );
        $this->app->bind(
            BookReviewRepositoryInterface::class,
            BookReviewRepository::class
        );
    }
}
