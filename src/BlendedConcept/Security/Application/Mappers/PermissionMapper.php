<?php

namespace Src\BlendedConcept\Security\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Domain\Model\Permission;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\PermissionEloquentModel;

class PermissionMapper
{
    public static function fromRequest(Request $request, $permission_id = null): Permission
    {
        return new Permission(
            id: $permission_id,
            name: $request->name,
            description: $request->description,
        );
    }


    public static function toEloquent(Permission $permission): PermissionEloquentModel
    {
        $PermissionElquent = new PermissionEloquentModel();

        if ($permission->id) {
            $PermissionElquent = PermissionEloquentModel::query()->findOrFail($permission->id);
        }

        $PermissionElquent->name = $permission->name;
        $PermissionElquent->description = $permission->description;
        return $PermissionElquent;
    }
}
