<?php

namespace Src\Common\Infrastructure\Laravel\Providers;


use Illuminate\Support\ServiceProvider;
use Src\Auth\Application\Repositories\Eloquent\AuthRepository;
use Src\Auth\Application\Repositories\Eloquent\DashboardRepository;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\Auth\Domain\Repositories\DashboardRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Application\Repositories\Eloquent\OrganizationRepository;
use Src\BlendedConcept\Organization\Application\Repositories\Eloquent\PlanRepository;
use Src\BlendedConcept\Organization\Domain\Repositories\PlanRepositoryInterface;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\AnnouncementRepository;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\NotificationRepository;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\SettingRepository;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\StudentRepository;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\UserRepository;
use Src\BlendedConcept\User\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\BlendedConcept\User\Domain\Repositories\NotificationRepositoryInterface;
use Src\BlendedConcept\User\Domain\Repositories\SettingRepositoryInterface;
use Src\BlendedConcept\User\Domain\Repositories\StudentRepositoryInterface;
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
        $this->app->bind(
            DashboardRepositoryInterface::class,
            DashboardRepository::class
        );

        $this->app->bind(
            StudentRepositoryInterface::class,
            StudentRepository::class
        );

        $this->app->bind(
            AnnouncementRepositoryInterface::class,
            AnnouncementRepository::class
        );

        $this->app->bind(
            OrganizationRepositoryInterface::class,
            OrganizationRepository::class
        );

        $this->app->bind(
            PlanRepositoryInterface::class,
            PlanRepository::class
        );

        // setting interface

        $this->app->bind(
            SettingRepositoryInterface::class,
            SettingRepository::class
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
