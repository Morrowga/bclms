<?php

namespace Src\Common\Infrastructure\Laravel\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\Auth\Application\Repositories\Eloquent\AuthRepository;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\UserRepository;
use Src\BlendedConcept\User\Domain\Repositories\NotificationRepositoryInterface;
use Src\BlendedConcept\System\Domain\Repositories\OrganisationRepositoryInterface;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\NotificationRepository;
use Src\BlendedConcept\System\Application\Repositories\Eloquent\OrganisationRepository;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;

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
            OrganisationRepositoryInterface::class,
            OrganisationRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Paginator::useBootstrapFour();
        //     //set config for organisation file system
        //     $organisation = OrganisationEloquentModel::all();
        //     foreach ($organisation as $item) {
        //         $rootPath = storage_path('app/public/organisation/'.$item->name);
        //         $url = env('APP_URL').'/storage';
        //         Config::set("filesystems.disks.{$item->name}", [
        //             'driver' => 'local',
        //             'root' => $rootPath,
        //             'url' => $url,
        //             'visibility' => 'public',
        //         ]);
        //     }
    }
}
