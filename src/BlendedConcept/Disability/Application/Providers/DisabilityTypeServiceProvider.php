<?php

namespace Src\BlendedConcept\Disability\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\Disability\Application\Repositories\Eloquent\DeviceRepository;
use Src\BlendedConcept\Disability\Application\Repositories\Eloquent\DisabilityTypeRepository;
use Src\BlendedConcept\Disability\Application\Repositories\Eloquent\LearningNeedRepository;
use Src\BlendedConcept\Disability\Application\Repositories\Eloquent\ThemeRepository;
use Src\BlendedConcept\Disability\Domain\Repositories\DeviceRepositoryInterface;
use Src\BlendedConcept\Disability\Domain\Repositories\DisabilityTypeRepositoryInterface;
use Src\BlendedConcept\Disability\Domain\Repositories\LearningNeedRepositoryInterface;
use Src\BlendedConcept\Disability\Domain\Repositories\ThemeRepositoryInterface;

class DisabilityTypeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            DisabilityTypeRepositoryInterface::class,
            DisabilityTypeRepository::class
        );

        $this->app->bind(
            ThemeRepositoryInterface::class,
            ThemeRepository::class
        );

        $this->app->bind(
            LearningNeedRepositoryInterface::class,
            LearningNeedRepository::class
        );

        $this->app->bind(DeviceRepositoryInterface::class, DeviceRepository::class);
    }
}
