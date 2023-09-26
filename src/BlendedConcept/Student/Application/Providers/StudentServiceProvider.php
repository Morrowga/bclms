<?php

namespace Src\BlendedConcept\Student\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\Student\Application\Repositories\Eloquent\PlaylistRepository;
use Src\BlendedConcept\Student\Application\Repositories\Eloquent\StudentRepository;
use Src\BlendedConcept\Student\Domain\Repositories\PlaylistRepositoryInterface;
use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;

class StudentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            StudentRepositoryInterface::class,
            StudentRepository::class
        );

        $this->app->bind(
            PlaylistRepositoryInterface::class,
            PlaylistRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
