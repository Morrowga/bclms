<?php

namespace Src\BlendedConcept\Teacher\Application\Providers;


use Illuminate\Support\ServiceProvider;

use Src\BlendedConcept\Teacher\Domain\Repositories\TeacherRepositoryInterface;
use Src\BlendedConcept\Teacher\Application\Repositories\Eloquent\TeacherRepository;

class TeacherServiceProvider extends ServiceProvider
{



    public function register()
    {
        $this->app->bind(
            TeacherRepositoryInterface::class,
            TeacherRepository::class
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
