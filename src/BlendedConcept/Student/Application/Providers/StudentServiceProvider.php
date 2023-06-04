<?php

namespace Src\BlendedConcept\Student\Application\Providers;


use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
use Src\BlendedConcept\Student\Application\Repositories\Eloquent\StudentRepository;

class StudentServiceProvider extends ServiceProvider
{



    public function register()
    {
        $this->app->bind(
            StudentRepositoryInterface::class,
            StudentRepository::class
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
