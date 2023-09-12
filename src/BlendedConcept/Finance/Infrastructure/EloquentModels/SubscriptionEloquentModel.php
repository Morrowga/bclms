<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Finance\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;

class SubscriptionEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'id',
        'start_date',
        'end_date',
        'payment_date',
        'payment_status',
        'stripe_status',
        'stripe_price',
    ];

    public function b2b_subscriptions()
    {
        return $this->hasMany(B2bSubscriptionEloquentModel::class, 'subscription_id', 'id');
    }

    public function b2b_subscription()
    {
        return $this->hasOne(B2bSubscriptionEloquentModel::class, 'subscription_id', 'id')->orderBy('created_at', 'desc');
    }
    public function b2c_subscriptions()
    {
        return $this->hasMany(B2cSubscriptionEloquentModel::class, 'subscription_id', 'id');
    }

    public function b2c_subscription()
    {
        return $this->hasOne(B2cSubscriptionEloquentModel::class, 'subscription_id', 'id')->with('plan', 'user')->orderBy('created_at', 'desc');
    }

    public function organization()
    {
        return $this->belongsTo(OrganizationEloquentModel::class, 'id', 'curr_subscription_id');
    }
    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });

        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
