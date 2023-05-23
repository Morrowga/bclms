<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Domain\Model;

use Hash;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;


    // for images
    protected $appends = [
        'image',
    ];

    protected $fillable = [
        'id',
        'stripe_id',
        'name',
        'description',
        'price',
        'payment_period',
        'allocated_storage',
        'teacher_license',
        'student_license',
        'is_hidden'
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
