<?php

namespace Src\Common\Infrastructure\Laravel\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Src\BlendedConcept\System\Application\Policies\OrganizationPolicy;
use Src\BlendedConcept\System\Application\Policies\SettingPolicy;
use Src\BlendedConcept\Security\Application\Policies\UserPolicy;
use Src\BlendedConcept\Security\Application\Policies\PermissionPolicy;
use Src\BlendedConcept\System\Application\Policies\FileManagerPolicy;
use Src\BlendedConcept\Security\Application\Policies\RolePolicy;
use Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


    }

    public function register()
    {
    }
}
