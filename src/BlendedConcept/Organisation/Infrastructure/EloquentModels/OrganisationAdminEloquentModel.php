<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Organisation\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class OrganisationAdminEloquentModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'organisation_admin';

    protected $primaryKey = 'org_admin_id';

    protected $fillable = [
        'org_admin_id',
        'user_id',
        'organisation_id',
    ];

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id');
    }

    public function organisation()
    {
        return $this->belongsTo(OrganisationEloquentModel::class, 'organisation_id');
    }
}
