<?php

declare(strict_types=1);

namespace Src\BlendedConcept\User\Domain\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Student extends Model implements HasMedia
{
    use InteractsWithMedia;

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

    public function setDobAttribute($value)
    {
       return Carbon::parse($value)->format('Y-m-d');
    }

}
