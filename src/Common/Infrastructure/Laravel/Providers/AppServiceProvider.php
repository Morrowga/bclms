<?php

namespace Src\Common\Infrastructure\Laravel\Providers;


use Illuminate\Support\ServiceProvider;
use Src\Auth\Application\Repositories\Eloquent\AuthRepository;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\BlendedConcept\System\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\System\Application\Repositories\Eloquent\OrganizationRepository;
use Src\BlendedConcept\System\Domain\Model\Organization;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\NotificationRepository;
use Src\BlendedConcept\User\Application\Repositories\Eloquent\UserRepository;
use Src\BlendedConcept\User\Domain\Repositories\NotificationRepositoryInterface;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Config;

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
            OrganizationRepositoryInterface::class,
            OrganizationRepository::class
        );

    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       //set config for organization file system
       $organization = Organization::all();
       foreach($organization as $item)
       {
        $rootPath = storage_path('app/public/organization/'.$item->name);
        $url = env('APP_URL') . '/storage';
        Config::set("filesystems.disks.{$item->name}", [
            'driver' => 'local',
            'root' => $rootPath,
            'url' => $url,
            'visibility' => 'public',
        ]);
       }
    }
}
