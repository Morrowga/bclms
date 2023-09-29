<?php

namespace Src\BlendedConcept\Organisation\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\Organisation\Application\Repositories\Eloquent\OrganisationRepository;
use Src\BlendedConcept\Organisation\Application\Repositories\Eloquent\StudentRepository;
use Src\BlendedConcept\Organisation\Application\Repositories\Eloquent\TeacherRepository;
use Src\BlendedConcept\Organisation\Domain\Repositories\OrganisationRepositoryInterface;
use Src\BlendedConcept\Organisation\Domain\Repositories\StudentRepositoryInterface;
use Src\BlendedConcept\Organisation\Domain\Repositories\TeacherRepositoryInterface;

class OrganisationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            OrganisationRepositoryInterface::class,
            OrganisationRepository::class
        );

        $this->app->bind(
            TeacherRepositoryInterface::class,
            TeacherRepository::class
        );
        $this->app->bind(
            StudentRepositoryInterface::class,
            StudentRepository::class
        );
    }
}
