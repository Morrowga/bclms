<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class PermissionRoleEloquentModel extends Model
{
    protected $table = 'permission_role';

    protected $fillable = ['permission_id', 'role_id'];
}
