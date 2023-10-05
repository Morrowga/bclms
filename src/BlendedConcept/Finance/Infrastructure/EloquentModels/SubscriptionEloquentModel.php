<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Finance\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;

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

    public function organisation()
    {
        return $this->belongsTo(OrganisationEloquentModel::class, 'id', 'curr_subscription_id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });

        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->whereHas('b2c_subscription', function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')->orWhere('last_name', 'like', '%' . $search . '%');
                });
            });
            $query->orWhereHas('b2b_subscription', function ($query) use ($search) {
                $query->whereHas('organisation', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            });
        });

        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'teachers') {
                // $query->join('b2b_subscriptions', 'subscriptions.id', '=', 'b2b_subscriptions.subscription_id')
                // ->select('subscriptions.*', 'b2b_subscriptions.num_teacher_license')
                // ->orderBy('b2b_subscriptions.num_teacher_license', 'DESC');
                // $query->select('subscriptions.*', 'latest_b2b_subscriptions.num_teacher_license')
                // ->from('subscriptions')
                // ->joinSub(function ($joinSub) {
                //     $joinSub->select('subscription_id', 'num_teacher_license', DB::raw('MAX(created_at) as max_created_at'))
                //         ->from('b2b_subscriptions')
                //         ->groupBy('subscription_id', 'num_teacher_license');
                // }, 'latest_b2b_subscriptions', function ($join) {
                //     $join->on('subscriptions.id', '=', 'latest_b2b_subscriptions.subscription_id');
                //     $join->on('subscriptions.created_at', '=', 'latest_b2b_subscriptions.max_created_at');
                // })
                // ->orderBy('latest_b2b_subscriptions.num_teacher_license', 'DESC')
                // ->distinct();

                // $query->join('b2b_subscriptions', 'subscriptions.id', '=', 'b2b_subscriptions.subscription_id')
                //     ->whereExists(function ($query) {
                //         $query->select(DB::raw(1))
                //             ->from('b2b_subscriptions as sub_b2b_subscriptions')
                //             ->whereRaw('sub_b2b_subscriptions.subscription_id = subscriptions.id')
                //             ->orderBy('sub_b2b_subscriptions.num_teacher_license', 'asc')
                //             ->limit(1);
                //     });
            } elseif ($filter == 'name') {
                // $query->join('organisations', 'subscriptions.id', '=', 'organisations.curr_subscription_id')->select('organisations.*', 'subscriptions.*')
                //     ->orderBy('organisations.name', config('sorting.orderBy'));
            } elseif ($filter == 'plan') {
                // $query->join('plan', 'subscriptions.id', '=', 'b2b_subscriptions.subscription_id')
                //     ->orderBy('b2b_subscriptions.num_student_license', config('sorting.orderBy'));
            } elseif ($filter == 'students') {
                $query->join('b2b_subscriptions', 'subscriptions.id', '=', 'b2b_subscriptions.subscription_id')
                    ->orderBy('b2b_subscriptions.num_student_license', config('sorting.orderBy'));
            } elseif ($filter == 'storage') {
                $query->join('b2b_subscriptions', 'subscriptions.id', '=', 'b2b_subscriptions.subscription_id')
                    ->orderBy('b2b_subscriptions.storage_limit', config('sorting.orderBy'));
            } elseif ($filter == 'user') {
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }
}
