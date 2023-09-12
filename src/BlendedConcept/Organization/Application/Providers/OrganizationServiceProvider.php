<?php

namespace Src\BlendedConcept\Organization\Application\Providers;

use Illuminate\Support\ServiceProvider;
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
    }
}
