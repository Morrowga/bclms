<?php

namespace Src\BlendedConcept\System\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Auth\Application\Repositories\Eloquent\DashboardRepository;
use Src\Auth\Domain\Repositories\DashboardRepositoryInterface;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\AnnouncementRepository;
use Src\BlendedConcept\User\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\BlendedConcept\System\Domain\Repositories\PageBuilderInterface;
use Src\BlendedConcept\System\Application\Repositories\Eloquent\PageBuilderRepository;
use Src\BlendedConcept\User\Domain\Repositories\SettingRepositoryInterface;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\SettingRepository;
use Src\BlendedConcept\System\Application\Repositories\Eloquent\PlanRepository;
use Src\BlendedConcept\System\Domain\Repositories\PlanRepositoryInterface;

class SystemServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->bind(
            DashboardRepositoryInterface::class,
            DashboardRepository::class
        );

        $this->app->bind(
            AnnouncementRepositoryInterface::class,
            AnnouncementRepository::class
        );

        $this->app->bind(
            PageBuilderInterface::class,
            PageBuilderRepository::class
        );

        $this->app->bind(
            PlanRepositoryInterface::class,
            PlanRepository::class
        );

        $this->app->bind(
            SettingRepositoryInterface::class,
            SettingRepository::class
        );
    }
}
