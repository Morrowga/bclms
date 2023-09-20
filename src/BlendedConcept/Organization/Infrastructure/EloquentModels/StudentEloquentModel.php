<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Organization\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class StudentEloquentModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'students';

    // for images
    protected $appends = [
        'image',
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

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->orWhere('name', 'like', '%'.$search.'%');
        });
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(OrganizationEloquentModel::class, 'organization_students', 'student_id', 'organization_id');
    }

    public function learningneeds(): BelongsToMany
    {
        return $this->belongsToMany(SubLearningTypeEloquentModel::class, 'storybook_learning_needs', 'student_id', 'sub_learning_type_id');
    }

    public function disability_types(): BelongsToMany
    {
        return $this->belongsToMany(DisabilityTypeEloquentModel::class, 'storybook_disability_types', 'student_id', 'disability_type_id');
    }
}
