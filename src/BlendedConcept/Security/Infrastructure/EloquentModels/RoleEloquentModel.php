<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\User\Infrastructure\UserEloquentModel;

class RoleEloquentModel extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(UserEloquentModel::class, 'users', 'user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(PermissionEloquentModel::class, 'permission_role', 'role_id', 'permission_id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}
