<?php

namespace Src\BlendedConcept\Finance\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\Finance\Application\Repositories\Eloquent\PlanRepository;
use Src\BlendedConcept\Finance\Domain\Repositories\PlanRepositoryInterface;

class PlanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            PlanRepositoryInterface::class,
            PlanRepository::class
        );
    }
}
