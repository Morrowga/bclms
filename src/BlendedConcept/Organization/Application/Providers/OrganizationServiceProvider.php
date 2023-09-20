<?php

namespace Src\BlendedConcept\Organization\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\Organization\Domain\Repositories\TeacherRepositoryInterface;
use Src\BlendedConcept\Organization\Application\Repositories\Eloquent\TeacherRepository;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Application\Repositories\Eloquent\OrganizationRepository;

class OrganizationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            OrganizationRepositoryInterface::class,
            OrganizationRepository::class
        );

        $this->app->bind(
            TeacherRepositoryInterface::class,
            TeacherRepository::class
        );
    }
}
