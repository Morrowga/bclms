<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Student\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Src\BlendedConcept\Classroom\Infrastructure\EloquentModels\ClassroomEloquentModel;
use Src\BlendedConcept\Classroom\Infrastructure\EloquentModels\ClassroomGroupEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2cUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class StudentEloquentModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'students';

    // for images
    protected $appends = [
        'image',
        // 'age'
    ];

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'user_id',
        'device_id',
        'gender',
        'dob',
        'education_level',
        'num_gold_coins',
        'num_silver_coins',
        'student_code',
        'total_time_spent',

    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }

    public function getAgeAttribute()
    {
        return $this->getMedia('image');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->whereHas('user', function ($query) use ($search) {
                $query
                    ->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%');
            });
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'asc') {
                $query->join('users', 'students.user_id', '=', 'users.id')
                    ->orderBy('users.first_name', 'asc');
            } elseif ($filter == 'desc') {
                $query->join('users', 'students.user_id', '=', 'users.id')
                    ->orderBy('users.first_name', 'desc');
            } elseif ($filter == 'role') {
                $query->join('roles', 'users.role_id', 'roles.id')->orderBy('name', config('sorting.orderBy'));
            } else {
                $query->join('users', 'students.user_id', '=', 'users.id')
                    ->orderBy("users.$filter", config('sorting.orderBy'));
            }
        });
    }

    public function organisations()
    {
        return $this->belongsToMany(OrganisationEloquentModel::class, 'organisation_id');
    }

    public function classrooms()
    {
        return $this->belongsToMany(ClassroomEloquentModel::class, 'classroom_students', 'student_id', 'classroom_id');
    }

    public function playlists()
    {
        return $this->hasMany(PlaylistEloquentModel::class, 'student_id');
    }

    public function disability_types()
    {
        return $this->belongsToMany(DisabilityTypeEloquentModel::class, 'student_disability_types', 'student_id', 'disability_type_id');
    }

    public function learningneeds()
    {
        return $this->belongsToMany(SubLearningTypeEloquentModel::class, 'student_learning_needs', 'student_id', 'sub_learning_type_id');
    }

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id', 'id');
    }

    public function groups()
    {
        return $this->belongsToMany(ClassroomGroupEloquentModel::class, 'group_students', 'student_id', 'classroom_group_id')->with('students');
    }
}
