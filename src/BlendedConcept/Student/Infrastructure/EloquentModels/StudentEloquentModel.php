<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Student\Infrastructure\EloquentModels;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2cUserEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;

class StudentEloquentModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'students';

    // for images
    protected $appends = [
        'image',
        'age'
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
        // Replace 'dob' with the actual field name of date of birth in your database
        $dob = $this->attributes['dob'];

        // Check if the date of birth is set
        if ($dob) {
            $dob = Carbon::createFromFormat('Y-m-d H:i:s', $dob);
            return $dob->age;
        }

        return null; // Return null if date of birth is not set
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
    }

    public function b2cUsers()
    {
        return $this->belongsToMany(B2cUserEloquentModel::class, 'b2c_students', 'student_id', 'b2c_user_id');
    }

    public function organizations()
    {
        return $this->belongsToMany(OrganizationEloquentModel::class, 'organization_students', 'student_id', 'organization_id');
    }

    public function disability_types()
    {
        return $this->belongsToMany(DisabilityTypeEloquentModel::class, 'student_disability_types', 'student_id', 'disability_type_id');
    }

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id', 'id');
    }
}
