<?php

namespace Src\BlendedConcept\StoryBook\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\RewardRepository;
use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;

class StoryBookServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            RewaredRepositoryInterface::class,
            RewardRepository::class
        );

    }
}
