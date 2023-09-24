<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Organization\Infrastructure\EloquentModels;

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
                $query->whereHas('user', function ($query) {
                    $query->orderBy('first_name', 'asc');
                });
            } else if ($filter == 'desc') {
                $query->whereHas('user', function ($query) {
                    $query->orderBy('first_name', 'desc');
                });
            } else if ($filter == 'contact_number') {
                $query->whereHas('user', function ($query) {
                    $query->orderBy('contact_number', config('sorting.orderBy'));
                });
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(OrganizationEloquentModel::class, 'organization_students', 'student_id', 'organization_id');
    }

    public function learningneeds(): BelongsToMany
    {
        return $this->belongsToMany(SubLearningTypeEloquentModel::class, 'student_learning_needs', 'student_id', 'sub_learning_type_id');
    }

    public function disability_types(): BelongsToMany
    {
        return $this->belongsToMany(DisabilityTypeEloquentModel::class, 'student_disability_types', 'student_id', 'disability_type_id');
    }

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id', 'id');
    }
}
