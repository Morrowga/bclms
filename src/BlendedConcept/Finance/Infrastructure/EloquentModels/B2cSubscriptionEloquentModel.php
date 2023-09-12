<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Finance\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class B2cSubscriptionEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'b2c_subscriptions';

    protected $fillable = [
        'subscription_id',
        'user_id',
        'plan_id',
    ];

    public function plan()
    {
        return $this->belongsTo(PlanEloquentModel::class, 'plan_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id', 'id');
    }
}
