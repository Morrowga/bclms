<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class ParentEloquentModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'parents';

    protected $primaryKey = 'parent_id';

    protected $fillable = [
        'parent_id',
        'user_id',
        'organisation_id',
        'curr_subscription_id',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id');
    }

    public function organisation()
    {
        return $this->belongsTo(OrganisationEloquentModel::class, 'organisation_id', 'id');
    }

    public function subscription()
    {
        return $this->belongsTo(SubscriptionEloquentModel::class, 'curr_subscription_id', 'id');
    }
}
