<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Organisation\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class StudentEloquentModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'students';

    // for images
    protected $appends = [
        'profile_pics',
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

    public function getProfilePicsAttribute()
    {
        return $this->getMedia('profile_pics');
    }

    public function scopeFilter($query, $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->whereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
                $query->orWhere('last_name', 'like', '%' . $search . '%');
            });
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {

            if ($filter == 'asc') {
                $query->join('users', 'students.user_id', '=', 'users.id')
                    ->orderBy('users.first_name', 'asc');
            } elseif ($filter == 'desc') {
                $query->join('users', 'students.user_id', '=', 'users.id')
                    ->orderBy('users.first_name', 'desc');
            } else {
                $query->join('users', 'students.user_id', '=', 'users.id')
                    ->orderBy("users.$filter", config('sorting.orderBy'));
            }
        });
    }

    // public function organisations(): BelongsToMany
    // {
    //     return $this->belongsToMany(OrganisationEloquentModel::class, 'organisation_students', 'student_id', 'organisation_id');
    // }
    public function organisation()
    {
        return $this->belongsTo(OrganisationEloquentModel::class, 'organisation_id', 'id');
    }

    public function learningneeds(): BelongsToMany
    {
        return $this->belongsToMany(SubLearningTypeEloquentModel::class, 'student_learning_needs', 'student_id', 'sub_learning_type_id');
    }

    public function disability_types(): BelongsToMany
    {
        return $this->belongsToMany(DisabilityTypeEloquentModel::class, 'student_disability_type', 'student_id', 'disability_type_id');
    }

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id', 'id');
    }
}
