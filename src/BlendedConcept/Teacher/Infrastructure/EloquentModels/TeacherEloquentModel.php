<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Teacher\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Src\BlendedConcept\Classroom\Infrastructure\EloquentModels\ClassroomEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class TeacherEloquentModel extends Authenticatable
{
    protected $table = 'teachers';
    protected $primaryKey = 'teacher_id';
    protected $fillable = [
        'teacher_id',
        'user_id',
        'organisation_id',
        'allocated_storage_limit',
        'curr_subscription_id',
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

    public function scopeFilter($query, $filters)
    {
    }
    public function classrooms()
    {
        return $this->belongsToMany(ClassroomEloquentModel::class, 'classroom_teachers', 'teacher_id', 'classroom_id');
    }
}
