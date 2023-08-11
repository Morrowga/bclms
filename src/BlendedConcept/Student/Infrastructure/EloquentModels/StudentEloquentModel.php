<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Student\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
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

    protected $fillable = [
        'organization_id',
        'device_id',
        'student_code',
        'name',
        'nickname',
        'description',
        'dob',
        'grade',
        'star_earn',
        'coin_earn',
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
}
