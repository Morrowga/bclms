<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\System\Domain\Repositories\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getRecentOrganisations($filters)
    {
        $organisations = OrganisationEloquentModel::filter($filters)->paginate($filters['perPage'] ?? 10);
        return $organisations;
    }

    public function getRecentUsers($filters)
    {
        $users = UserEloquentModel::filter($filters)->with('role')->paginate($filters['perPage'] ?? 10);
        return $users;
    }
}
