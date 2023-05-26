<?php

namespace Src\Auth\Application\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Src\Auth\Application\Repositories\AuthRepository;
use Src\Auth\Domain\AuthInterface;
use Src\BlendedConcept\System\Domain\Policies\OrganizationPolicy;
use Src\BlendedConcept\System\Domain\Policies\SettingPolicy;
use Src\BlendedConcept\Security\Domain\Policies\UserPolicy;
use Src\BlendedConcept\Security\Domain\Policies\PermissionPolicy;
use Src\BlendedConcept\System\Domain\Policies\FileManagerPolicy;
use Src\BlendedConcept\Security\Domain\Policies\RolePolicy;
use Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel::class' => 'Src\BlendedConcept\Security\Domain\Policies\UserPolicy::class',

        'Src\BlendedConcept\Security\Infrastructure\EloquentModels\PermissionEloquentModel' => 'Src\BlendedConcept\Security\Domain\Policies\PermissionPolicy::class',

        'Src\BlendedConcept\Security\Infrastructure\EloquentModels\RoleEloquentModel::class' => 'Src\BlendedConcept\Security\Domain\Policies\RolePolicy::class',

        'Src\BlendedConceptSystem\Domain\Model\Organization::class' => 'Src\BlendedConcept\System\Domain\Policies\OrganizationPolicy::class',
        'Src\BlendedConcept\User\Domain\Model\Setting::class' => 'Src\BlendedConcept\User\Domain\Policies\SettingPolicy::class'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $policies = [UserPolicy::class, PermissionPolicy::class, RolePolicy::class,OrganizationPolicy::class,SettingPolicy::class,FileManagerPolicy::class];
        foreach ($policies as $policy) {
            Gate::define('view', [$policy, 'view']);
            Gate::define('create', [$policy, 'create']);
            Gate::define('store', [$policy, 'store']);
            Gate::define('edit', [$policy, 'edit']);
            Gate::define('show', [$policy, 'show']);
            Gate::define('update', [$policy, 'update']);
            Gate::define('destroy', [$policy, 'destroy']);
        }

    }

    public function register()
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);

    }
}
