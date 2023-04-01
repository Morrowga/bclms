<?php

namespace Src\Common\Infrastructure\Laravel\Providers;


use Illuminate\Support\ServiceProvider;
use Src\Auth\Application\Repositories\Eloquent\AuthRepository;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\NotificationRepository;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\UserRepository;
use Src\BlendedConcept\User\Domain\Repositories\NotificationRepositoryInterface;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );
        $this->app->bind(
            AuthRepositoryInterface::class,
            AuthRepository::class
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
