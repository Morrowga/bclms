<?php

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class ParentUserEloqeuntModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'parent_id';

    protected $fillable = [
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
        return $this->belongsTo(OrganizationEloquentModel::class, 'organisation_id', 'id');
    }

    public function subscription()
    {
        return $this->belongsTo(SubscriptionEloquentModel::class, 'curr_subscription_id', 'id');
    }
}