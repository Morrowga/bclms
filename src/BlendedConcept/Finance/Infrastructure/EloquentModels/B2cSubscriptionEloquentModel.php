<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Finance\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;

class B2cSubscriptionEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'b2c_subscriptions';

    protected $fillable = [
        'subscription_id',
        'parent_id',
        'teacher_id',
        'plan_id',
    ];

    public function plan()
    {
        return $this->belongsTo(PlanEloquentModel::class, 'plan_id', 'id');
    }

    // public function user()
    // {
    //     return $this->belongsTo(UserEloquentModel::class, 'teacher_id', 'id');
    // }
    public function teacher()
    {
        return $this->belongsTo(TeacherEloquentModel::class, 'teacher_id')->with('user');
    }

    public function parent()
    {
        return $this->belongsTo(ParentEloquentModel::class, 'parent_id')->with('user');
    }
}
