<?php

namespace Src\BlendedConcept\Organization\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\Finance\Application\Repositories\Eloquent\PlanRepository;
use Src\BlendedConcept\Finance\Domain\Repositories\PlanRepositoryInterface;
use Src\BlendedConcept\Organization\Application\Repositories\Eloquent\OrganizationRepository;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;

class OrganizationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            OrganizationRepositoryInterface::class,
            OrganizationRepository::class
        );

        $this->app->bind(
            PlanRepositoryInterface::class,
            PlanRepository::class
        );
    }
}
