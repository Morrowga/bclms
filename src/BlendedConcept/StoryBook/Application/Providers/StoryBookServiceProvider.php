<?php

namespace Src\BlendedConcept\StoryBook\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\StoryBook\Domain\Repositories\GameRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\GameRepository;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\RewardRepository;

class StoryBookServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            RewaredRepositoryInterface::class,
            RewardRepository::class
        );

        $this->app->bind(
            GameRepositoryInterface::class,
            GameRepository::class
        );

    }
}
