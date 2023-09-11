<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class B2bUserEloquentModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'b2b_users';

    protected $fillable = [
        'b2b_user_id',
        'user_id',
        'organization_id',
        'allocated_storage_limit',
        'has_full_library_access',
    ];
}
