<?php

namespace Src\BlendedConcept\StoryBook\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent\PathwayRepository;
use Src\BlendedConcept\StoryBook\Domain\Repositories\PathwayRepositoryInterface;

class StorybookServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PathwayRepositoryInterface::class, PathwayRepository::class);
    }
}
