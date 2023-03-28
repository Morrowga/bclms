<?php

namespace Src\Common\Infrastructure\Laravel\Providers;


use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface',
            'Src\BlendedConcept\User\Application\Repositories\Eloquent\UserRepository'
        );
        $this->app->bind(
            'Src\Auth\Domain\Repositories\AuthRepositoryInterface',
            'Src\Auth\Application\Repositories\Eloquent\AuthRepository'
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
